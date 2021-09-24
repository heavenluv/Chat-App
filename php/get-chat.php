<?php 
    session_start();
    include "../dbconnect.php";
    $outgoing_id = $_SESSION["user_id"];
    //echo "outgoing id is" . $outgoing_id;
    $incoming_id = mysqli_real_escape_string($conn, $_SESSION["target_chat_user"]);
    //echo "incoming id is " . $incoming_id;
    $output = "";
    $sql = "SELECT * FROM chat LEFT JOIN user ON user.user_id = chat.outgoing_msg_id
            WHERE (outgoing_msg_id = '$outgoing_id' AND incoming_msg_id = '$incoming_id')
            OR (outgoing_msg_id = '$incoming_id' AND incoming_msg_id = '$outgoing_id') ORDER BY msg_id";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    if(mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            if($row['outgoing_msg_id'] === $outgoing_id){//message send
                if($row['msg'] !== null){
                    $output .= '
                            <li class="sent" 
                            style="display: inline-block; clear: both;
                                float: right; margin: 15px 15px 5px 15px;
                                width: calc(100% - 25px); font-size: 0.9em;">
                               
                                <p style="background: #d5ebff; color: #000000; display: inline-block; float:right;
                                    padding: 10px 15px;
                                    border-radius: 20px;
                                    max-width: 205px;
                                    line-height: 100%;">' . $row['msg'] . '</p>
                            </li>';
                } else {//means the message is a file
                    if($row['img_or_not']){//means that it is an image
                        $output .= '<li class="sent" 
                                    style="display: inline-block; clear: both;
                                        float: right; margin: 15px 15px 5px 15px;
                                        width: calc(100% - 25px); font-size: 0.9em;">
                                       
                                        <p style="background: #d5ebff; color: #000000; display: inline-block; float:right;
                                            padding: 10px 15px;
                                            border-radius: 20px;
                                            max-width: 205px;
                                            line-height: 100%;"> 
                                            <img style="max-width: 100%; max-height: 100%;" 
                                            src="' . $row['uploadfile'] . '" alt=""> </p>
                                    </li>';
                    } else{
                        $output .=
                    '<li class="sent" 
                                    style="display: inline-block; clear: both;
                                        float: right; margin: 15px 15px 5px 15px;
                                        width: calc(100% - 25px); font-size: 0.9em;">
                                       
                                        <p style="background: #d5ebff; color: #000000; display: inline-block; float:right;
                                            padding: 10px 15px;
                                            border-radius: 20px;
                                            max-width: 205px;
                                            line-height: 100%;"> 
                                            <a href="' . $row['uploadfile'] . '" download="' . $row['filename'] . '">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            '. $row['filename'] . '</a>
                                            </p>
                                    </li>';
                    }
               
                }
                
            }else{ //message receiver
                if ($row['msg'] !== null) {
                    $output .= '<li class="replies" style="display: inline-block;
                                    clear: both; float: left;
                                    margin: 15px 15px 5px 15px; width: calc(100% - 25px);
                                    font-size: 0.9em;">
                                  
                                    <p style="background: #000000; float: left; display: inline-block; 
                                        color:white; float:left;
                                        padding: 10px 15px; border-radius: 20px;
                                        max-width: 205px; line-height: 100%;">' . $row['msg'] . '</p>
                                </li>';
                } else{
                if ($row['img_or_not']) {//means that it is an image
                    $output .= '<li class="replies" style="display: inline-block;
                                    clear: both; float: left;
                                    margin: 15px 15px 5px 15px; width: calc(100% - 25px);
                                    font-size: 0.9em;">
                                   
                                    <p style="background: #000000; float: left; display: inline-block; 
                                        color:white; float:left;
                                        padding: 10px 15px; border-radius: 20px;
                                        max-width: 205px; line-height: 150%;">
                                        <img style="max-width: 100%; max-height: 100%;" 
                                            src="' . $row['uploadfile'] . '" alt="">
                                    </p>
                                </li>';
                } else {
                    $output .= '<li class="replies" style="display: inline-block;
                                    clear: both; float: left;
                                    margin: 15px 15px 5px 15px; width: calc(100% - 25px);
                                    font-size: 0.9em;">
                                   
                                    <p style="background: #000000; float: left; display: inline-block; 
                                        color:white; float:left;
                                        padding: 10px 15px; border-radius: 20px;
                                        max-width: 205px; line-height: 150%;">
                                        <a href="' . $row['uploadfile'] . '" download="' . $row['filename'] . '">
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        ' . $row['filename'] . '</a>
                                    </p>
                                </li>';
                }
            }
                
            }
        }
    }else{
        $output .= 
        '<div style="display:flex; align-items:center; justify-content:center; ">
            <div style="margin: 50% 10px 10px 10px; text-align:center">
                No messages are available. Once you send message they will appear here.
            </div>
        </div>';
    }
    echo $output;

?>