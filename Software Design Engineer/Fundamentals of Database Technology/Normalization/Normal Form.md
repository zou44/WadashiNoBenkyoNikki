![Normal Form of header img.png](./Resouces/Normal%20Form%20of%20header%20img.png)
# 范式 (Normal Form)
## 目录
- [范式 (Normal Form)](#范式-normal-form)
  - [目录](#目录)
  - [什么是规范化？](#什么是规范化)
  - [范式](#范式)
    - [1NF](#1nf)
    - [2NF](#2nf)
      - [解决了什么?](#解决了什么)
    - [3NF](#3nf)
      - [解决了什么?](#解决了什么-1)
    - [BCNF](#bcnf)
      - [例子](#例子)
      - [来源](#来源)
      - [解决了什么?](#解决了什么-2)
    - [4NF(后续补充)](#4nf后续补充)
    - [其他](#其他)
      - [做题步骤](#做题步骤)
      - [简记方式](#简记方式)
      - [升级方式](#升级方式)

## 什么是规范化？
通过分解，将一个低等级范式的关系模式转换成若干个高一级范式的关系模式，这个过程称为规范化。

## 范式
范式共有六种, 分别为1NF ⊃ 2NF ⊃ 3NF ⊃ BCNF ⊃ 4NF ⊃ 5NF. 一般只会用到前三个范围,又称三范式. `注意:范式程度和系统效率成反比`

### 1NF  
若关系模式中R的每个分量(属性),都是不可再分的数据项,则关系模式R属于第一范式。

### 2NF
若关系模式R∈1NF，并且每一个非主属性都 [完全函数依赖](./Functional%20Dependency.md#完全函数依赖-full-functional-dependency) 于任何一个候选码，则R∈2NF.
#### 解决了什么?
1范式还存在着一些问题,这些问题基本都可以归为 `因非主属性对候选码的部分依赖` 造成的问题. 所以2范式就是为了解决这个问题的.

### 3NF
若关系模式R∈2NF,且关系模式 R(U,F) 中若`不存在`这样的码X,属性组Y及非主属性Z(Z⊈Y)使得`X->Y(Y!->X),Y->Z`成立，则关系模式R∈3NF
#### 解决了什么?
2范式还存在着`非主属性`对`候选码`的[传递函数依赖](./Functional%20Dependency.md#传递函数依赖-transitive-functional-dependency)问题, 所以有了3范式.

### BCNF
设关系模式R<U,F>∈1NF，若X->Y且Y⊄X时，X必含有候选码，则R<U,F>∈BCNF. 换言之，在关系模式R<U,F>中，如果每一个决定属性集(X)都是候选码，则R∈BCNF 
#### 例子
-   关系模式  
    Course_Student(CourseID, StudentID, Instructor, CourseName, InstructorOffice)
-   函数依赖
    1.  {CourseID, StudentID} → {Instructor, CourseName, InstructorOffice}
    2.  {StudentID} → {Instructor}
-   问题  
    {StudentID} → {Instructor} , StudentID主属性对候选码有传递函数依赖.
#### 来源
BCNF (Boyce Codd Normal Form) 是由Boyce和Codd提出，比3NF更进一步。通常认为BCNF是修正了第三范式 (3NF),有时也称为扩展的第三范式
#### 解决了什么?
3范式中还存在着`主属性对码的部分函数依赖和传递函数依赖`

### 4NF(后续补充)

### 其他
#### 做题步骤
1.  找关系中的主属性
2.  判断关系 (完全依赖、部分依赖)
3.  拆表 (升级)
#### 简记方式
某一种关系模式R为第n范式，可简记为R∈nNF
#### 升级方式
模式分解 (投影分解)，就是拆表，一拆多
-   例
    S-L-C(Sno, Sdept, Sloc, Cno, Grade) 不符合2NF
    对上面的表进行拆解
    SC (Sno，Cno, Grade) 符合2NF
    S-L (Sno, Sdept, Sloc) 符号2NF