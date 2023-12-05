<button onclick="joinRoom('room1', '4')">
    Join room
</button>

<button onclick="sendMessage('room1', 'hey it is from js')">
    Send message
</button>


<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     class ChatClient {
    //         constructor(serverUrl, roomId, userId) {
    //             this.serverUrl = serverUrl;
    //             this.roomId = roomId;
    //             this.userId = userId;
    //             this.socket = null;
    //         }

    //         connect() {


    //             this.socket = new WebSocket(this.serverUrl);

    //             this.socket.onopen = () => {
    //                 console.log('connection established')
    //                 this.joinRoom();
    //                 // this.sendToken(token)
    //                 // this.sendMessage('Hey it is from javascript')
    //             };

    //             this.socket.onmessage = (event) => {
    //                 const data = JSON.parse(event.data);
    //                 this.handleMessage(data);
    //             };

    //             this.socket.onerror = (error) => {
    //                 console.error('WebSocket Error:', error);
    //             };

    //             this.socket.onclose = () => {
    //                 console.log('WebSocket connection closed');
    //             };
    //         }

    //         joinRoom() {
    //             const message = {
    //                 type: 'join_room',
    //                 room: this.roomId,
    //                 userId: this.userId
    //             };
    //             this.socket.send(JSON.stringify(message));
    //         }

    //         sendMessage(text) {
    //             const message = {
    //                 type: 'message',
    //                 room: this.roomId,
    //                 userId: this.userId,
    //                 message: text
    //             };
    //             this.socket.send(JSON.stringify(message));
    //         }

    //         sendToken(token) {
    //             const message = {
    //                 token: token
    //             };
    //             this.socket.send(JSON.stringify(message));
    //         }

    //         handleMessage(data) {
    //             if (data.type === 'message') {
    //                 console.log('Message from room:', data.message);
    //                 // Burada mesajı kullanıcı arayüzünde gösterebilirsiniz.
    //             }
    //         }
    //     }

    //     // Kullanımı (örnek)
    //     const chatClient = new ChatClient('ws://127.0.0.1:8080/', 'room1', '4');
    //     chatClient.connect();

    //     // Örnek: Mesaj göndermek için bir butona tıklandığında
    //     // document.getElementById('sendButton').addEventListener('click', function() {
    //     //     const message = document.getElementById('messageInput').value;
    //     //     chatClient.sendMessage(message);
    //     // });
    // });
</script>


<script>
    const connection = new WebSocket('ws://127.0.0.1:8080/');

    connection.onopen = () => {
        console.log('connection established')


        const token =
            "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2N1c3RvbWVyL3YxL2xvZ2luIiwiaWF0IjoxNzAxNDM0NzA2LCJuYmYiOjE3MDE0MzQ3MDYsImp0aSI6Im9FZnlnTlhmVHUwcnNXZU0iLCJzdWIiOiI0IiwicHJ2IjoiMWQwYTAyMGFjZjVjNGI2YzQ5Nzk4OWRmMWFiZjBmYmQ0ZThjOGQ2MyJ9.hxOB6t-_V2DkirMxKJ8ssm30aD0LgQEclMZw_Ur3Os4";

        connection.send(JSON.stringify({
            token: token,
        }));


    }

    function sendDirectMessage(toUserId, message) {
        const data = {
            type: 'direct_message',
            toUserId: toUserId,
            message: message
        };
        connection.send(JSON.stringify(data));
    }

    function sendMessage(room, message) {
        const data = {
            type: 'message',
            room: room,
            message: message
        };
        connection.send(JSON.stringify(data));
    }

    function joinRoom(room, userId) {
        const data = {
            type: 'join_room',
            room: room,
            userId: userId
        };
        connection.send(JSON.stringify(data));
    }

    connection.onerror = (error) => {
        console.error('WebSocket Error:', error);
    };

    connection.onmessage = (data) => {
        console.log('WebSocket message:', data.data);
    };

    connection.onclose = () => {
        console.log('WebSocket connection closed');
    };
</script>
