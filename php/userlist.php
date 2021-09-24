<?php
    session_start();
    include "../dbconnect.php";
    $outgoing_id = $_SESSION['user_id'];
    $current_id = $_SESSION['user_id'];
    //echo "$outgoing_id";
    //SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC
    $listed_user = mysqli_query($conn, "SELECT * FROM user WHERE NOT user_id='$current_id'");
    $output = "";
    if (mysqli_num_rows($listed_user) == 0) {
        echo "ERROR: " . mysqli_error($conn);

    } elseif (mysqli_num_rows($listed_user) > 0) {
        while ($row = mysqli_fetch_assoc($listed_user)) {
            if ($row['first_name']==$_SESSION['first_name']){
                continue;
            }
            //$_SESSION["target_chat_user"]=$row["user_id"];
            $sql2 = "SELECT * FROM chat WHERE (incoming_msg_id = {$row['user_id']}
                                            OR outgoing_msg_id = {$row['user_id']}) AND (outgoing_msg_id = {$outgoing_id} 
                                            OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";

            $query2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($query2);
            if (mysqli_num_rows($query2) > 0) {
                $result = $row2['msg'];
            } else {
                $result = "No message available";
            }
            if (strlen($result) > 28) {
                $msg =  substr($result, 0, 28) . '...';
            } else {
                $msg = $result;
            }
            if (isset($row2['outgoing_msg_id'])) {
                ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
            } else {
                $you = "";
            }
            $offoron = "";
            //($outgoing_id == $row['user_id']) ? $hid_me = "hide" : $hid_me = "";
            if($row['status'] === 'online'){
                $offoron = "online";
            } else{
                $offoron = "offline";
            }
            // the li tag which contains id and value attr are used to save the user_id then which i can later by using jquery in index.php(line 293)
            $output .= '
                    <!-- <a href="chat.php?user_id=' . $row['user_id'] . '"> -->
                    <li class="contact" id="info-' . $row['user_id'] . '" value="info-' . $row['user_id'] . '" " >
                        <div class="wrap">
                            <span class="contact-status ' . $row['status'] . '"></span>
                            <img src= "avatar.jpg" alt="" />
                            <div class="meta">
                                <p class="name">' . $row['first_name'] . " " . $row['last_name'] . '</p>
                                <p class="preview"> ' . $you . $msg . '</p>
                            </div>
                        </div>
                    </li>';
        }
    }
    echo $output;
?>

