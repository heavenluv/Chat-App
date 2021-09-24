<?php
    session_start();
    include "../dbconnect.php";
    $_SESSION["target_chat_user"] = $_POST['target_userid'];
    $outgoing_id = $_SESSION["user_id"];
    //echo $outgoing_id;
    //console_log($_POST['target_userid']);
    $output = '';
    $target_id = mysqli_real_escape_string($conn, $_SESSION["target_chat_user"]);
    $targetuser = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$target_id'");
    if (mysqli_num_rows($targetuser) > 0) {
        $row = mysqli_fetch_assoc($targetuser);
        $output .= '
                <div class="contact-profile">
                    <img src="../assets/images/faces/1.jpg" alt="" />
                    <p class="person_received">' .$row['first_name'] . " " . $row['last_name'] . '</p>
                    <div class="social-media">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="messages">
                </div>
                <form action="#" class="message-input">
                    <div class="wrap">
                        <div style="float:left">
                            <input type="file" id="fileupload" name="file" value="file" hidden>
                            <button class="attachmentbtn"><i class="fa fa-paperclip attachment" aria-hidden="true"></i></button>
                        </div>
                        <div>
                            <input type="text" class="incoming_id" name="incoming_id" value="message" hidden>
                            <input type="text" name="message" class="input-field" id="chat_message" placeholder="Write your message..." />
                            <button class="submitbutton"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
        ';
    } else {
        $output .= "ERROR: " . mysqli_error($conn);
    }
    echo $output;
