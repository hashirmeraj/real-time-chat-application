<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location:./login.php");
    exit();
}
$loggedinId = $_SESSION['userId'];
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="./src/output.css">
    <script src="https://kit.fontawesome.com/b01bd35356.js" crossorigin="anonymous"></script>
    <title>Chat Room</title>
</head>

<body>
    <div class="main flex w-screen h-screen bg-slate-500 justify-between ">
        <aside class="left h-screen w-1/4 text-white ">
            <div class="h-full w-full  bg-gray-900 rounded-r-2xl flex flex-col items-center pt-10 ">
                <div class="heading">
                    <h1>Chat</h1>
                </div>
                <div class="flex flex-col w-4/5  p-2 scrollable-content h-full">
                    <div class="users flex mt-6">
                        <div class="users-img"> <img class=" w-[60px] h-[50px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="" srcset=""></div>
                        <div class="details flex justify-between w-full  ml-4">
                            <div class="username font-semibold ">
                                <span class="block font-bold">Hashir Meraj</span>

                                <span>This is text</span>
                            </div>
                            <div class="time">5:30</div>
                        </div>

                    </div>

                    <!-- User Area -->
                    <?php
                    require './database/users.php';
                    $objUser = new Users();
                    $result = $objUser->getRestUserByid($loggedinId);

                    while ($users = $result->fetch_assoc()) {

                        if (strlen($users['msg']) > 20) {
                            $msg = substr($users['msg'], 0, 20) . "...";
                        } else {
                            $msg = $users['msg'];
                        }

                        $datetime = new DateTime($users['createdOn']);
                        $time = $datetime->format('H:i');
                        echo '
                            <div class="users flex mt-6">
                                <div class="users-img"> <img class=" w-[60px] h-[50px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="" srcset=""></div>
                                <div class="details flex justify-between w-full  ml-4">
                                    <div class="username  ">
                                        <span class="block font-bold">' . $users['name'] . '</span>

                                        <span>'  . $msg . '</span>
                                    </div>
                                    
                                    <div class="time">' . $time . '</div>
                                    
                                </div>

                            </div>
                        
                        ';
                    }
                    ?>

                    <!-- Example End -->
                </div>
            </div>
        </aside>
        <div class="right w-[73%] h-full bg-slate-900 rounded-l-2xl">
            <div class="chatarea w-full h-full p-8 ">
                <div class="display-chat w-full h-[93%]   flex flex-col  scrollable-content pr-2" id="chatArea">

                    <!-- message -->
                    <div class="message-area flex w-full justify-start">
                        <div class="users flex  w-2/5 mb-4 ">
                            <div class="users-img"> <img class=" w-[60px] h-[50px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="" srcset=""></div>
                            <div class="details flex justify-between w-full  ml-4 bg-gray-700 p-2 rounded-b-xl">
                                <div class="username   text-white">
                                    <span class="block font-bold">Hashir Meraj</span>

                                    <span class=" message-text break-words ">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque quos atque officia ad necessitatibus. Excepturi ex natus quasi vel officiis.</span>
                                </div>
                                <div class="time">5:30</div>
                            </div>

                        </div>
                    </div>
                    <!-- sending message -->

                    <div class="message-area flex w-full justify-end">
                        <div class="users flex w-2/5 mb-4">
                            <div class="users-img">
                                <img class="w-[60px] h-[50px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                            </div>
                            <div class="details flex justify-between w-full ml-4 bg-gray-700 p-2 rounded-b-xl">
                                <div class="username text-white">
                                    <span class="block font-bold">Me</span>
                                    <span class="message-text break-words">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Labore dolores officiis exercitationem nesciunt non pariatur.</span>
                                </div>
                                <div class="time text-white ml-4">5:30</div>
                            </div>
                        </div>
                    </div>

                    <!-- showing message from database -->
                    <?php
                    require './database/chatrooms.php';
                    $objChatroom = new Chatrooms();
                    $result = $objChatroom->getAllmsg();  // Get the result set from the method

                    // Loop through the result set and fetch rows as associative arrays
                    while ($chatroom = $result->fetch_assoc()) {
                        // Checking if the logged-in user is the sender
                        if ($chatroom['userid'] == $loggedinId) {
                            $justify = "justify-end";
                            $fromName = "Me";
                        } else {
                            $justify = "justify-start"; // Show other users' messages on the left
                            $fromName = $chatroom['name'];
                        }

                        // Showing message
                        echo '
        <div class="message-area flex w-full ' . $justify . '">
            <div class="users flex w-2/5 mb-4">
                <div class="users-img">
                    <img class="w-[60px] h-[50px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                </div>
                <div class="details flex justify-between w-full ml-4 bg-gray-700 p-2 rounded-b-xl">
                    <div class="username text-white">
                        <span class="block font-bold">' . $fromName . '</span>
                        <span class="message-text break-words">' . $chatroom['msg'] . '</span>
                    </div>
                    <div class="time">' . $chatroom['createdOn'] . '</div>
                </div>
            </div>
        </div>
    ';
                    }
                    ?>



                    <!-- testing text -->

                    <div class="typing-area ">
                        <form id="chat-room-form" action="" method="post">
                            <div class="form-controll  w-[70%] flex    fixed bottom-5  bg-slate-900 ">
                                <input type="hidden" id="userId" name="userId" value="<?php echo $loggedinId ?>">
                                <input id="message" name="message" class="  rounded-lg  p-1 pl-5 w-11/12 focus:outline-none" type="text" placeholder="Type a message" maxlength="1000" required>
                                <button id="send" type="submit" class=" h-10 w-10 rounded-full text-gray-400 focus:text-white "><i class="fa-solid fa-paper-plane  text-2xl"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- sending end -->


                <!-- <div class="typing-area ">
                    <form id="chat-room-form" action="" method="post">
                        <div class="form-controll  w-2/3 flex  justify-around  fixed bottom-5  bg-slate-900">
                            <input type="hidden" id="userId" name="userId" value="<?php echo $userId ?>">
                            <input id="message" name="message" class="  rounded-lg  p-1 w-11/12 focus:outline-none" type="text" placeholder="Type here..." maxlength="1000" required>
                            <button id="send" type="submit" class=" h-10 w-10 rounded-full text-gray-400 focus:text-white "><i class="fa-solid fa-paper-plane  text-2xl"></i></button>
                        </div>
                    </form>
                </div> -->
            </div>

            <!-- typing area -->

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./src/script.js"></script>
</body>

</html>