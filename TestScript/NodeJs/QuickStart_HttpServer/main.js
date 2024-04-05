const express = require('express');
const path = require('path');
const http = require('http');

const app = express();

// const customAppDirectory = 'C:\\Users\\64553\\AndroidStudioProjects\\GxCameraCapture\\app\\debug'; // 你的自定义应用目录的路径
const customAppDirectory = 'C:\\Users\\64553\\AndroidStudioProjects\\GxCameraCapture\\app\\release'; // 你的自定义应用目录的路径

app.use(express.static(customAppDirectory));

app.get('/', (req, res) => {
    res.status(200).send("ok!1");
    console.log("有人访问了")
//   res.sendFile(path.join(__dirname, customAppDirectory, 'index.html'));
});


const port = process.env.PORT || 5001;

app.set('port', port);

const server = http.createServer(app);

server.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
