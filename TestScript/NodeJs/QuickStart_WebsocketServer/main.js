const http = require('http');
const WebSocket = require('ws');
const readline = require('readline');


const rl = readline.createInterface({
    input: process.stdin,
    output: process.stdout
  });

  
// 创建HTTP服务器
const server = http.createServer((req, res) => {
    res.writeHead(200, { 'Content-Type': 'text/plain' });
    res.end('WebSocket Server\n');
});

// 创建WebSocket服务器，将其关联到HTTP服务器
const wss = new WebSocket.Server({ server });
var lastWs;


// 监听WebSocket连接
wss.on('connection', (ws) => {
    lastWs = ws;
    console.log('Client connected');

    // 监听消息事件
    ws.on('message', (message) => {
        console.log(`Received: ${message}`);
    });

    // 发送欢迎消息
    // ws.send('Welcome to the WebSocket server!');

    // setTimeout(() => {
    //     ws.send('close!');
    //     // ws.terminate();
    // }, 1000 * 5)
});


rl.on('line', (input) => {
    // console.log("发送" + JSON.parse(input))
//   ws.send(JSON.stringify(JSON.parse(input)));
lastWs.send(input);
  rl.prompt();
});



rl.on('close', () => {
    lastWs.close();
  });

  
// 启动HTTP服务器，监听端口8080
server.listen(9200, () => {
    console.log('Server is running on port 9200');
    rl.prompt();
});


