const WebSocket = require('ws');
const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

const webSocketUrl = process.argv[2];

if (!webSocketUrl) {
  console.error('Usage: node main.js <WebSocket_URL>');
  process.exit(1);
}

const ws = new WebSocket(webSocketUrl);

ws.on('open', () => {
  console.log('Connected to WebSocket server.');
  rl.prompt();
});

ws.on('message', (data) => {
  console.log(`Received data: ${data}`);
});

ws.on('close', () => {
  console.log('WebSocket connection closed.');
  rl.close();
});

rl.on('line', (input) => {
    // console.log("发送" + JSON.parse(input))
//   ws.send(JSON.stringify(JSON.parse(input)));
  ws.send(input);
  rl.prompt();
});

rl.on('close', () => {
  ws.close();
});
