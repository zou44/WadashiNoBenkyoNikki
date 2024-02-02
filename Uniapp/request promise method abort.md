# Uniapp 中断请求 (uni.request的Promise形式)
## 业务背景
中断请求在很多场景下都是需要的. 如上拉刷新、输入框实时搜索和上传文件等.

## Uni.request 的 Promise
根据UniApp[文档](https://uniapp.dcloud.net.cn/api/request/request.html)可知,只要不传入任何回调属性,返回的就是 Promise.

## Promise.race
[官方文档](https://developer.mozilla.org/zh-CN/docs/Web/JavaScript/Reference/Global_Objects/Promise/race) 简单说下该方法.它可传入一个`Promise类型的迭代对象(理解为数组且元素都是Promise)`,该函数会返回一个Promise.这个Promise回调成功或是失败,由传入参数中的第一个响应Promise决定.

## 思路
使用Promise.race的特性达到中断特性. 即在把可能要中断的Promise请求和专门用于中断的Promise一并放入Promise.race,最后封装下Promise.race的返回值.
```javascript
// globalRequest.js - 这是个符合vue3的插件文件

const BAST_URL = "...";

const globalRequest = {
    install (app, options) {
        const store = app.config.globalProperties.$store;

        // 创建可中断对象
        app.config.globalProperties.$globalCreateAbortRequest = (fetchPromise) => {
            // 专门用于中断的Promise
            let abort = null
            const abortPromise = new Promise((resolve, reject) => {
                abort = () => reject('abort')
            })
            let promiseWithAbort = Promise.race([fetchPromise, abortPromise])
            promiseWithAbort.abort = abort
            return promiseWithAbort;
        }

        // 中断
        app.config.globalProperties.$globalAbortRequest = (promiseWithAbort) => {
            if (promiseWithAbort != null && promiseWithAbort.abort) {
                promiseWithAbort.abort()
            }
        }
        
        // 请求
        app.config.globalProperties.$globalRequest = (api, options) => {
            return uni.request(Object.assign({
                url: BAST_URL.concat(api),
            }, options));
        };

    }
};

export default globalRequest;
```
使用
```javascript
// 组件中的某块上下文.

let fetchRequest = this.$globalRequest('/device', {});
let abortRequest = this.$globalCreateAbortRequest(fetchRequest);

abortRequest.then(() => {
    console.log('请求成功')
}).catch((e) => {
    if(e && e === 'abort') {
        console.log('中断');
    }
})

// 中断
this.$globalAbortRequest(abortRequest);
```