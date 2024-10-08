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
        var data = JSON.parse(e.data);
        var dateTime = new Date(data.dt);  // Create a Date object from the string
        var localTime = dateTime.toLocaleString();  // Convert to user's local time format
        if (data.from == 'Me') {

            var html_data = `
            <div class="message-area flex w-full justify-end">
            <div class="users flex sm:w-4/5 md:w-3/6 mb-4">
                <div class="users-img">
                    <img class="w-[40px] h-[35px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                </div>
                <div class="details flex justify-between w-full ml-4 bg-gray-700 p-2 rounded-b-xl">
                    <div class="username text-white">
                        <span class="block text-gray-300 font-bold text-sm md:text-sm">`+ data.from + `</span>
                        <span class="message-text break-words">`+ data.msg + `</span>
                    </div>
                    <div class="time text-gray-400 text-sm md:text-sm">`+ data.dt + `</div>
                </div>
            </div>
        </div>
        `;

        } else {

            var html_data = `
            <div class="message-area flex w-full justify-start">
                <div class="users flex sm:w-4/5 md:w-3/6 mb-4">
                    <div class="users-img">
                        <img class="w-[40px] h-[35px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                    </div>
                    <div class="details flex justify-between w-full ml-4 bg-gray-700 p-2 rounded-b-xl">
                        <div class="username text-white">
                            <span class="block font-boldtext-gray-300 font-bold text-sm md:text-sm">` + data.from + `</span>
                            <span class="message-text break-words">` + data.msg + `</span>
                        </div>
                        <div class="time text-gray-400 text-sm md:text-sm ">` + data.dt + `</div>
                    </div>
                </div>
            </div>
        `;


        }

        $('#chatArea').append(html_data);


        $('#chat_message').val('');  // Clear the message input after sending
        function scrollToBottom() {
            const chatArea = document.getElementById('chatArea');
            chatArea.scrollTop = chatArea.scrollHeight;
        }
        scrollToBottom();

    };

    // Function to send message through the established WebSocket connection
    $(document).ready(function () {
        // Disable send button initially
        $('#send').attr('disabled', true);

        // Enable send button when input is not empty
        $('#message').on('input', function () {
            var message = $(this).val().trim();
            if (message !== "") {
                $('#send').attr('disabled', false);
            } else {
                $('#send').attr('disabled', true);
            }
        });

        $("#send").click(function (e) {
            e.preventDefault(); // Prevent any default action
            var userId = $("#userId").val();
            var msg = $("#message").val();
            if (msg.trim() !== "") {
                var data = {
                    userId: userId,
                    msg: msg
                };

                // Ensure the WebSocket connection is still open before sending
                if (conn.readyState === WebSocket.OPEN) {
                    conn.send(JSON.stringify(data));
                    $("#message").val('');
                    $('#send').attr('disabled', true); // Disable send button after sending
                } else {
                    console.log("WebSocket connection is not open.");
                }
            }
        });
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


function scrollToBottom() {
    const chatArea = document.getElementById('chatArea');
    chatArea.scrollTop = chatArea.scrollHeight;
}

// Call the function when the page loads
window.onload = function () {
    scrollToBottom();
};