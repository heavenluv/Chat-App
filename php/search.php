<?php
    session_start();
    include '../dbconnect.php';
    $outgoing_id = $_SESSION['user_id'];
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
    $output = "";
    //$line = "SELECT * FROM user WHERE first_name LIKE '%$searchTerm%'";
    $searchquery = mysqli_query($conn, "SELECT * FROM user WHERE first_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%'");
    if(mysqli_num_rows($searchquery) > 0){
        while($row = mysqli_fetch_assoc($searchquery)){
            $output .=
                '<li class="contact" id="info-' . $row['user_id'] . '" value="info-' . $row['user_id'] . '" >
                    <div class="wrap">
                        <span class="contact-status offline"></span>
                        <img src= "../assets/images/faces/1.jpg" alt="" />
                        <div class="meta">
                            <p class="name">' . $row['first_name'] . " " . $row['last_name'] . '</p>
                            <p>'. $_POST['searchTerm'] .'</p>
                        </div>
                    </div>
                </li>';
        }
    
    } else {
        $output .=
        
                    '<li class="contact">
                        <div class="wrap">
                            <span class="contact-status offline"></span>
                            <img src= "../assets/images/faces/1.jpg" alt="" />
                            <div class="meta">
                                <p class="name">No available users</p>
                                <p>' . $searchTerm . '</p>
                            </div>
                        </div>
                    </li>';
    }
    echo $output;
?>