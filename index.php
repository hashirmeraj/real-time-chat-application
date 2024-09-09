<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./src/output.css" rel="stylesheet">
</head>

<body>
    <div class="main flex justify-end items-center w-full h-screen ">

        <div class="chatbox w-[50%] h-[50vh] bg-slate-400 mr-64">
            <div id="message_area" class="chat-area h-[40vh] w-full bg-slate-400">
                <div class="sender h-auto w-40 bg-blue-500  mb-2 flex justify-between"> <span> Message</span><span> Id</span></div>
            </div>
            <div class="form-controll border-2 border-solid border-green-600">
                <form action="" method="post" id="chat_form">
                    <input type="hidden" id="userId" value="109">
                    <textarea id="chat_message" placeholder="Text.." class="w-full"></textarea>
                    <button type="submit" id="send" class="p-2 bg-slate-500 rounded-lg">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./src/script.js"></script>
</body>

</html>