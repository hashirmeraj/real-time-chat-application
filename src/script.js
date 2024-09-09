// Initialize the WebSocket connection when the page loads
var conn = new WebSocket('ws://localhost:8080');

conn.onopen = function (e) {
    console.log("Connection established!");
};

// Receiving messages from the server
conn.onmessage = function (e) {
    console.log(e.data);
    var data = JSON.parse(e.data);
    var html_data = "<div class='sender h-auto w-40 bg-blue-500'> " + data.msg + "</div>";
    $('#message_area').append(html_data);
    $('#chat_message').val('');  // Clear the message input after sending
};

// Sending messages through the existing WebSocket connection
$('#chat_form').on('submit', function (event) {
    event.preventDefault();

    var messages = $('#chat_message').val();
    if (messages.trim() !== "") {
        var data = {
            msg: messages
        };
        conn.send(JSON.stringify(data));  // Send message through the WebSocket
        $('#chat_message').val('');  // Clear input after sending
    } else {
        alert("Please enter a message before sending.");
    }
});
