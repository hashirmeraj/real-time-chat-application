// Initialize the WebSocket connection when the page loads

$(document).ready(function () {

    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function (e) {
        console.log("Connection established!");
    };
    conn.onmessage = function (e) {
        console.log(e.data);
        // var data = JSON.parse(e.data);
        // var html_data = "<div class='sender h-auto w-40 bg-blue-500  mb-2 flex justify-between'> <span> " + data.msg + "</span><span> " + data.uId + "</span></div>";
        // $('#message_area').append(html_data);
        // $('#chat_message').val('');  // Clear the message input after sending
    };

    // Sending messages through the existing WebSocket connection
    $("#send").click(function () {
        var userId = $("#userId").val();
        var message = $("#message").val();
        var data = {
            userId: userId,
            msg: message
        };
        conn.send(JSON.stringify(data));
    })
})
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
