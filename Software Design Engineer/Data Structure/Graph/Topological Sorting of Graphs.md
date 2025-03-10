# Topological Sorting of Graph (图的拓扑排序)
CreateAt: The 11th March, 2025

- [Topological Sorting of Graph (图的拓扑排序)](#topological-sorting-of-graph-图的拓扑排序)
  - [脑图](#脑图)
  - [定义](#定义)
  - [Activity On Vertex network, AOV](#activity-on-vertex-network-aov)
  - [转换过程](#转换过程)


## 脑图
![Topological Sorting of Graph Mind.png](./Resouces/Topological%20Sorting%20of%20Graph%20Mind.png)

## 定义
是一种将图应用在实际在的方式. 即将图转换成一种排序. 
`前提:此图必须是AOV, 即有向无环图`

## Activity On Vertex network, AOV
若以顶点表示活动，用有向边表示活动之间的优先关系，则称这样的有向图为AOV.
注意:
1.  AOV网中不允许出现回路，即AOV必须是一个有向无环图

## 转换过程
实际:访问某个结点前, 保证入度结点都提前被访问过.

如图片题目  
先走入度为0的，0号结点。走完该节点后，你可以任何选择1或2结点。但是一定没办法走1和2后面的其他结点，因为这些结点的前提条件就是要1和2必须得走完。
故而有:02143657,01243647 ... 多种可能性。
![Topological Sorting sample](./Resouces/Topological%20Sorting%20sample.png)