## 奇怪的table长度
`获得table长度,它只会计算连续的整数索引. `
```
myTable = {[1] = "one", [2] = "two", [5] = "three", [6] = "five"}
print(#myTable)
// 5.1以后用#获得table长度, 之前可用table.getn
print(#myTable) // 2
```