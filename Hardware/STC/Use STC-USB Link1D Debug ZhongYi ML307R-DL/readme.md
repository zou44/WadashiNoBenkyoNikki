# 使用STC-USB Link1D 调试中移ML307R-DL

## 步骤
1. 将STC-USB Link1D的P3IO口接到ML307R-DL核心板的串口IO上.
2. 使用额外供电给STC-USB Link1D和ML307R-DL供电.
   注意
    1.  STC-USB Link1D需要跟电源共地
    2.  波特率是115200
    3.  电源最少要5V 1A, 否则芯片会因为供电补足一直重启
3.  发送拨号上网指令
4.  