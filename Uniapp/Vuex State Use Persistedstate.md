# Vuex 使用 persistedstate 持久化
`npm install --save vuex-persistedstate`
注意在Uniapp中使用Poersistedstate需要修改storage将真正的存储实现改为UNIAPP封装的API

多模块
createPersistedState({  
            paths: ['user.tokens'], 
            storage: {  // 存储方式定义  
              getItem: (key) => uni.getStorageSync(key), // 获取  
              setItem: (key, value) => uni.setStorageSync(key, value), // 存储  
              removeItem: (key) => uni.removeStorageSync(key) // 删除  
            }  
        })