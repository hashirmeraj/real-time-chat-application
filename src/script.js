// Initialize the WebSocket connection when the page loads
$(document).ready(function () {

    // Establish WebSocket connection when the document is ready
    var conn = new WebSocket('ws://127.0.0.1:8080/ws');

    conn.onopen = function (e) {
        console.log("Connection established!");
    };

    conn.onmessage = function (e) {
        console.log(e.data);
        // Uncomment if you want to display the received message
        // var data = JSON.parse(e.data);
        // var html_data = "<div class='sender h-auto w-40 bg-blue-500 mb-2 flex justify-between'> <span> " + data.msg + "</span><span> " + data.uId + "</span></div>";
        // $('#message_area').append(html_data);
        // $('#chat_message').val('');  // Clear the message input after sending
    };

    // Function to send message through the established WebSocket connection
    $("#send").click(function (e) {
        e.preventDefault(); // Prevent any default action
        var userId = $("#userId").val();
        var message = $("#message").val();
        var data = {
            userId: userId,
            msg: message
        };

        // Ensure the WebSocket connection is still open before sending
        if (conn.readyState === WebSocket.OPEN) {
            conn.send(JSON.stringify(data));
            $("#message").val('');
        } else {
            console.log("WebSocket connection is not open.");
        }
    });
});

// Receiving messages from the server



// // Sending messages through the existing WebSocket connection
// $('#chat_form').on('submit', function (event) {
//     event.preventDefault();

//     var messages = $('#chat_message').val();
//     var userId = $('#userId').val();
//     if (messages.trim() !== "") {
//         var data = {
//             uId: userId,
//             msg: messages
//         };
//         conn.send(JSON.stringify(data));  // Send message through the WebSocket
//         $('#chat_message').val('');  // Clear input after sending
//     } else {
//         alert("Please enter a message before sending.");
//     }
// });
