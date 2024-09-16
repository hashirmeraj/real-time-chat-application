<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location:./login.php");
    exit();
}
require './database/users.php';
$loggedinId = $_SESSION['userId'];
$objLoggedUser = new Users();
$result = $objLoggedUser->getUserByid($loggedinId);
$loggedinUser = $result['name'];


// Handle form submission to unset session variables
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['close'])) {
    unset($_SESSION['search']);
    unset($_SESSION['searchResult']);
}


if (isset($_POST['searchName'])) {
    $searchName = $_POST['searchName'];
    $objSearch = new Users();
    $result = $objSearch->getUserByName($searchName);

    // Check if a user is found

    if ($result->num_rows > 0) {
        $_SESSION['search'] = "true";
        $_SESSION['searchResult'] = $result; // Store the search result in session
    } else {
        $_SESSION['search'] = "false";
        unset($_SESSION['searchResult']); // Clear the search result if no user is found
    }
}

if (isset($_POST['leaveChat'])) {
    $objUser->updateLoginStatus();
    session_destroy();
}

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
        <aside class="left h-screen w-[25.9%] text-white ">
            <div class="h-full w-full  bg-gray-900 rounded-r-2xl flex flex-col items-center pt-10 ">
                <div class="user-section w-full   flex items-center justify-around">
                    <div class="profile ml-9"><img class="w-[60px] h-[60px]  rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="" srcset=""></div>
                    <div class="name  text-xl"> <?php echo $loggedinUser ?></div>
                    <div class="name  ml-9 text-xl">

                        <form method="post">
                            <button type="submit" name="leaveChat" class=" text-sm h-auto w-auto p-1 border-2 focus:bg-red-500 text-gray-500 border-gray-600 rounded-lg hover:bg-slate-800 hover:text-white hover:border-white ">Leave Chat</button>
                        </form>

                    </div>
                </div>
                <div class="user-section w-4/5 h-10 p-2 rounded-full  flex   mt-6  border-2 border-solid border-gray-400">
                    <form action="" method="post" class="flex items-center w-full">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input class=" w-full p-2  bg-transparent focus:outline-none text-white cursor-pointer" type="search" name="searchName" placeholder="Search Name...">
                    </form>
                </div>

                <div class="flex flex-col w-4/5  p-2 scrollable-content h-full" id="userDisplay">


                    <!-- User Area -->

                    <?php

                    if (isset($_SESSION['search'])) {
                        if ($_SESSION['search'] == "true" && isset($_SESSION['searchResult'])) {
                            $result = $_SESSION['searchResult'];

                            while ($exist = $result->fetch_assoc()) {
                                if (strlen($exist['msg']) > 20) {
                                    $msg = substr($exist['msg'], 0, 20) . "...";
                                } else {
                                    $msg = $exist['msg'];
                                }
                                $status = ($exist['login_status'] == 1) ? "bg-green-600" : "bg-red-600";

                                $datetime = new DateTime($exist['createdOn']);
                                $time = $datetime->format('h:i A');

                                echo '
                            <div class="users flex mt-6">
                                <div class="users-img flex flex-col justify-start"> 
                                    <div class="status h-3 w-3 rounded-xl ' . $status . '"></div>
                                    <img class="w-[55px] h-[45px] rounded-full -mt-2" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                                </div>
                                <div class="details flex justify-between w-full ml-4">
                                    <div class="username">
                                        <span class="block font-bold">' . htmlspecialchars($exist['name']) . '</span>
                                        <span>' . htmlspecialchars($msg) . '</span>
                                    </div>
                                    <div class="time">' . htmlspecialchars($time) . '</div>
                                </div>
                            </div>';
                                echo '<div class="user-section w-full h-10 p-2 flex mt-6 justify-end">
                            <form method="post">
                                <button type="submit" name="close" class=" h-auto w-auto p-2 border-2 focus:bg-black text-gray-500 border-gray-600 rounded-lg hover:bg-slate-800 hover:text-white active:bg-black">Close</button>
                            </form>
                        </div>';
                            }
                        } elseif ($_SESSION['search'] == "false") {
                            echo '<p>No user found with that name.</p>';
                            echo '<div class="user-section w-full h-10 p-2 flex mt-6 justify-end">
                                <form method="post">
                                    <button type="submit" name="close" class=" h-auto w-auto p-2 border-2 focus:bg-black text-gray-500 border-gray-600 rounded-lg hover:bg-slate-800 hover:text-white active:bg-black">Close</button>
                                </form>
                            </div>';
                        }
                    } else {
                        $objUser = new Users();
                        $result = $objUser->getRestUserByid($loggedinId);

                        while ($users = $result->fetch_assoc()) {
                            if (strlen($users['msg']) > 20) {
                                $msg = substr($users['msg'], 0, 20) . "...";
                            } else {
                                $msg = $users['msg'];
                            }
                            $status = ($users['login_status'] == 1) ? "bg-green-600" : "bg-red-600";

                            $datetime = new DateTime($users['createdOn']);
                            $time = $datetime->format('h:i A');

                            echo '
                        <div class="users flex mt-6">
                            <div class="users-img flex flex-col justify-start"> 
                                <div class="status h-3 w-3 rounded-xl ' . $status . '"></div>
                                <img class="w-[55px] h-[45px] rounded-full -mt-2" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                            </div>
                            <div class="details flex justify-between w-full ml-4">
                                <div class="username">
                                    <span class="block font-bold">' . htmlspecialchars($users['name']) . '</span>
                                    <span>' . htmlspecialchars($msg) . '</span>
                                </div>
                                <div class="time">' . htmlspecialchars($time) . '</div>
                            </div>
                        </div>';
                        }
                    }
                    ?>

                    <!-- Example End -->
                </div>
            </div>
        </aside>
        <div class="right w-[74%] h-full bg-slate-900 rounded-l-2xl">
            <div class="chatarea w-full h-full p-8 ">
                <div class="display-chat w-full h-[93%]   flex flex-col  scrollable-content pr-2" id="chatArea">

                    <!-- message -->


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
                        $datetime = new DateTime($chatroom['createdOn']);
                        $time = $datetime->format('h:i A');
                        // Showing message
                        echo '
                    <div class="message-area flex w-full ' . $justify . '">
            <div class="users flex w-2/5 mb-4">
                <div class="users-img">
                    <img class="w-[40px] h-[35px] rounded-full" src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="">
                </div>
                <div class="details flex justify-between w-full ml-4 bg-gray-700 p-2 rounded-b-xl">
                    <div class="username text-white">
                        <span class="block font-bold">' . $fromName . '</span>
                        <span class="message-text break-words">' . $chatroom['msg'] . '</span>
                    </div>
                    <div class="time">' . $time . '</div>
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






            </div>

            <!-- typing area -->

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./src/script.js"></script>
</body>

</html>