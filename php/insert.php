<?php
    session_start();
    include "../dbconnect.php";
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_SESSION["target_chat_user"]);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    //echo "The message is " . $message;
    //console_log($message);
    //echo $message;
    if (!empty($message)) {
        $sql = mysqli_query($conn, "INSERT INTO chat (incoming_msg_id, outgoing_msg_id, msg)
                            VALUES ('$incoming_id', '$outgoing_id', '$message')") or die("Cannot send");
        echo "Success";
    } else {
        echo "Error! Empty message!";
    }
?>