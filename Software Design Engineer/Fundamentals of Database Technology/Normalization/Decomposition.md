![header](./Resouces/Decomposition%20header%20image.png)
# 分解 (Decomposition)

## 目录
- [分解 (Decomposition)](#分解-decomposition)
  - [目录](#目录)
    - [分解作用](#分解作用)
    - [保持函数依赖 (Perserving Functional Dependency)](#保持函数依赖-perserving-functional-dependency)
    - [无损分解 (Lossless Decomposition)](#无损分解-lossless-decomposition)

### 分解作用
即将一个关系模式拆分成多个,使其符合期望的范式

### 保持函数依赖 (Perserving Functional Dependency)
-   定义:设关系模式R(U,F)的一个分解p={R1(U1,F1), R2(U2,F2),...,Rk{Uk,Fk}}, 如果F+=(∪(i=1->k) ΠRi (F+)). `从i=1到n的所有值的并集，其中ΠRi(F+)表示从F+中选择与Ri集合相关函数依赖。`
    -   大白话: `分解后的关系模式依旧保持分解前的函数依赖关系`
-   例题
    -   例:设关系模式R(U,F)，其中U={A，B，C，D，E}，F={A→BC，C→D，BC→E，E→A}，则分解p={R1(ABCE)，R2(CD)}是否保持函数依赖?而分解p={R1(ABE)，R2(CD)}是否保持函数依赖?
        -   p={R1(ABCE)，R2(CD)}  
            推R1关系 {A->BC, BC->E, E->A}  
            推R2关系 {C->D}  
            将上述集合合并等于F   
            ∴ 保持了函数依赖  
        -   p={R1(ABE)，R2(CD)}  
            推R1关系 {E->A}  
            推R2关系 {C->D}  
            上述集合并不等于 F  
            ∴ 不保持函数依赖  
### 无损分解 (Lossless Decomposition)
-   定义:指将一个关系模式分解成若干关系模式后，通过自然连接或投影仍然能还原到原来的关系模式 (注:不能进行选择操作)
-   还原方法 (自然连接)  
    `因使用自然连接，则关系必须要有同名属性`
    -   表格法
        -   使用限制:`仅针对分解成2个关系模式求解，超过两个的得用表格法.`
        -   定理:对分解后关系求交得A，在对分解后关系求差 (被减集合和减集合需要交替求一边)得 B‘ 和 B’‘。若A和B’ 或 B‘’ 存在至少一个函数依赖，则判定为无损连接.
        -   例题:设R=ABC，F={A->B}，则分解γ1={R1(AB), R2(AC)}与分解γ2={R1(AB), R3(BC)}是否都为无损分解。
            -   γ1={R1(AB), R2(AC)}  
                A=R1∩R2={A}； γ1=R1-R2={B}; γ2=R2-R1={C}；  
                A->B存在函数依赖，即为无损分解
            -   γ2={R1(AB), R3(BC)}  
                A=R1∩R3={B}； γ1=R1-R3={A}；γ2=R3-R1={C}  
                B与A和C都不存在函数依赖，即为有损分解。  
    -   表格法
        -   一句话:画出初始表后通过同名属性列，凑出拥有完整列的一行，即为无损连接. `(若表格中同行依赖成立,这则一列的依赖也都成立,如此往复直到某行所有列都成立,则表无损)`
        -   [B站视频 22:56](https://www.bilibili.com/video/BV13U4y1E7oA?p=69&vd_source=613656291b0f8c3d8366da6a4a57ee05)
        -   ![图片](./Resouces/Lossless%20Decomposition.png)
