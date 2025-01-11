# UniApp uCharts 插件条形图点击改变颜色
> LastUpdateTime: The 11th of January, 2025

## 目录
- [UniApp uCharts 插件条形图点击改变颜色](#uniapp-ucharts-插件条形图点击改变颜色)
  - [目录](#目录)
  - [原因](#原因)
  - [存在的问题](#存在的问题)
  - [思路](#思路)
  - [源码](#源码)
  - [效果图](#效果图)


## 原因
最近一个项目中需要uCharts插件的条形图支持点击改变对应条形颜色的需求.  
查了官方文档发现并不支持, 后面发现可以使用`堆叠特性`来实现效果.   

## 存在的问题
1.  每次点击后整个图表会闪一下, 暂时还没想到解决方法

## 思路
使用条形图堆叠特性+点击事件来实现.

## 源码
```javascript
<template>
	<view class="content">
		<view class="charts-box" style="height:450rpx" >
            <qiun-data-charts :animation="false" :opts="opts" type="bar" :chartData="chartData" @getIndex="tap" />
        </view>
	</view>
</template>

<script>
    import { ref } from 'vue'
    const inputClose=ref();
    export default {
        data() {
            return {
                opts: {
                    animation: false,
                    dataLabel: false,
                    legend: {
                        show: false,
                    },
                    color: ['#0e9c59', "#FFFF00"],
                    padding: [15,30,5],
                    enableScroll: false,
                    xAxis: {
                        disabled: true,
                        boundaryGap: "justify",
                        disableGrid: true,
                        min: 0,
                        axisLine: false,
                        max: 5,
                    },
                    yAxis: {
                        showTitle: true,
                        disabled: false,
                        disableGrid: true,
                        data:[
                            {
                                type: 'categories',
                                position:'right',
                                title: "V",
                                formatter:(val, e, t)=>{
                                    return this.ysdata[e]
                                },
                                fontSize:20,
                                titleFontSize:20
                            },
                            {
                                fontColor: "#0e9c59",
                                type: 'categories',
                                position:'left',
                                title: "",
                                fontSize:20,
                            }
                        ]
                    },
                    extra: {
                        tooltip: {
                            showBox: false,
                        },
                        bar: {
                            type: "stack",
                            width: 35,
                            meterBorde: 1,
                            meterFillColor: "#FFFFFF",
                            activeBgColor: "#000000",
                            activeBgOpacity: 0.08,
                        }
                    },
                    series: {
                    },
                },
                chartData: {
                    categories: ["①","②","③","④","⑤","⑥","⑦","⑧","⑨","⑩"],
                    series: [
                        {
                            name: "目标值",
                            data: [5,2,1,3,4,1.5,2,5,3,5],
                        },
                        {
                            name: "目标值",
                            data: [0,0,0,0,0,0,0,0,0,0],
                        }
                    ]
                },
                ysdata: [5,2,1,3,4,1.5,2,5,3,5],
                lastIndex: -1,
            }
        },
        methods: {
            tap(e) {
                if(this.lastIndex > -1) {
                    this.chartData.series[0].data[this.lastIndex] = this.ysdata[this.lastIndex];
                    this.chartData.series[1].data[this.lastIndex] = 0;
                }
                
                let index = e.currentIndex.index;
                this.lastIndex = index;
                this.chartData.series[1].data[index] = this.chartData.series[0].data[index];
                this.chartData.series[0].data[index] = 0;
                console.log(e, index, this.chartData.series[0].data[index]);
            }
        }
    }
</script>
```

## 效果图
![展示图片](./resources/bar%20chart%20click%20to%20change%20color%20image.png)
