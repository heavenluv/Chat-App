<?php include 'dbconnect.php';
// error_reporting(E_ALL);
// ini_set('display_errors', 'on');
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["name"]) || $_SESSION["loggedin"] !== true) {
	header("location: auth-login.php");
	exit;
}
$username = $_SESSION["name"];

function console_log($output, $with_script_tags = true)
{
	$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
		');';
	if ($with_script_tags) {
		$js_code = '<script>' . $js_code . '</script>';
	}
	echo $js_code;
}

?>
<!-- <?= console_log($username); ?> -->



<!DOCTYPE html>
<html class=''>

<head>
	<meta charset='UTF-8'>
	<meta name="robots" content="noindex">
	<title>CHATAPP</title>
	<script src="https://use.typekit.net/hoy3lrg.js"></script>
	<script>
		try {
			Typekit.load({
				async: true
			});
		} catch (e) {}
	</script>
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
	<link rel="stylesheet" href="chat.css">
</head>

<body>
	<!-- 

A concept for a chat interface. 

Try writing a new message! :)


Follow me here:
Twitter: https://twitter.com/thatguyemil
Codepen: https://codepen.io/emilcarlsson/
Website: http://emilcarlsson.se/

-->

	<div id="frame">
		<div id="sidepanel">
			<div id="profile">
				<div class="wrap">
					<?php
					$sql = mysqli_query($conn, "SELECT * FROM user WHERE first_name = '$username'");
					$row = mysqli_fetch_assoc($sql);
					$_SESSION["user_id"] = $row['user_id'];
					?>
					<img id="profile-img" src="avatar.jpg" class="online" alt="" />
					<p><?php echo $row['first_name'] . " " . $row['last_name'] ?></p>
					<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
					<div id="status-options">
						<ul>
							<li id="status-online" class="active"><span class="status-circle"></span>
								<p>Online</p>
							</li>
							<li id="status-away"><span class="status-circle"></span>
								<p>Away</p>
							</li>
							<li id="status-busy"><span class="status-circle"></span>
								<p>Busy</p>
							</li>
							<li id="status-offline"><span class="status-circle"></span>
								<p>Offline</p>
							</li>
						</ul>
					</div>
					<div id="expanded">
						<label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
						<input name="twitter" type="text" value="<?php echo $row['first_name'] . " " . $row['last_name'] ?>" />
						<label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
						<input name="twitter" type="text" value="<?php echo $row['first_name'] . " " . $row['last_name'] ?>" />
						<label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
						<input name="twitter" type="text" value="<?php echo $row['first_name'] . " " . $row['last_name'] ?>" />
					</div>
				</div>
			</div>
			<div id="search">
				<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
				<input type="text" placeholder="Search contacts..." id="search" name="searchvalue">
			</div>
			<div id="contacts">
				<ul class="users-list">

				</ul>
			</div>
			<div id="bottom-bar">
				<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
				<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
			</div>
		</div>

		<div class="content" style="display:none">

		</div>
		<div class="nomessage">
			<img id="chatboximg" src="assets/img/chatmsg.png" alt="" />
			<div class="startchat">
				<h1>Start new chat now!</h1>
			</div>

		</div>
	</div>
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script>
		<?php
		function listalluser($user_id, $conn)
		{
			$outgoing_id = $user_id;
			$sql = "SELECT * FROM user WHERE NOT user_id = '$user_id' ORDER BY user_id DESC";
			$query = mysqli_query($conn, $sql);
			$output = "";
			if (mysqli_num_rows($query) == 0) {
				$output .= '<li class="contact">
                    <div class="wrap">
                        <span class="contact-status offline"></span>
                        <img src= "avatar.jpg" alt="" />
                        <div class="meta">
                            <p class="name">Nobody</p>
                            <p class="preview"> No users are available to chat</p>
                        </div>
                    </div>
                </li>';
			} elseif (mysqli_num_rows($query) > 0) {
				while ($row = mysqli_fetch_assoc($query)) {
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
					//($outgoing_id == $row['user_id']) ? $hid_me = "hide" : $hid_me = "";

					$output .= '
                <li class="contact">
                    <div class="wrap">
                        <span class="contact-status online"></span>
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
		}
		?>
	</script>
	<script type="text/javascript">
		$(document).ready(function() {

			const usersList = document.querySelector('.users-list');
			const searchBar = document.querySelector("#frame #search input");
			const userItem = document.querySelectorAll(".users-list li");
			const chatBox = document.querySelector(".content")

			var target_userid = 0;
			const delay = millis => new Promise((resolve, reject) => {
				setTimeout(_ => resolve(), millis)
			});


			$("#contacts").on("click", ".contact", function() {
				const elems = document.querySelector(".active");
				if (elems !== null) {
					elems.classList.remove("active");
				}
				// console.log("active selection!");
				$(this).addClass("active");
				if ($(this).hasClass("active")) {
					$(".nomessage").css("display", "none");
					$(".content").css("display", "block");
					target_userid = $(this).attr("value").split("info-").join(""); //This is used to obtain the target user_id (user wanted to chat with) by saving the id in the li value attr (check userlist.php)
					//alert(target_userid);
					// console.log(target_userid);
					$.ajax({
						url: "php/obtainTargetUserID.php",
						method: "POST",
						data: {
							"target_userid": target_userid
						},
						success: function(result) {
							refreshUserList();
							// console.log(result);
							chatBox.innerHTML = result;
							const ChatBubbleBox = document.querySelector(".content .messages");
							const ChatContent = document.querySelector(".content");
							const form = document.querySelector(".content .message-input");
							const inputField = form.querySelector(".wrap .input-field")
							const sendBtn = form.querySelector(".wrap .submitbutton")
							refreshChatRoom()
							scrollToBottom()
							// setInterval(refreshChatRoom, 5000)
							async function scrollToBottom() { //Automatically scroll to the bottom of page as keep showing the latest messages
								//wrong scroll now maybe because of the slow rendering of the picture and attachment
								// Fix by giving a delay to render
								await delay(1000)
								ChatBubbleBox.scrollTop = ChatBubbleBox.scrollHeight;
								// console.log(ChatBubbleBox.scrollHeight)
							}


							function refreshChatRoom() { //Refresh the chatroom while send message or select the user to chat to
								$.ajax({
									url: "php/get-chat.php",
									method: "GET",
									// data: {
									// 	"incoming_id": target_userid
									// },
									success: function(result) {
										// console.log(result);
										// var ChatBubbleBox = document.querySelector(".content .messages");
										// let div = document.createElement('div');
										// div.innerHTML = result;
										ChatBubbleBox.innerHTML = result;
										// ChatBubbleBox.appendChild(div);
										// console.log(ChatBubbleBox);

										//personContactWith.innerHTML=data;
										// console.log("getting chat data here!");
										// refreshChatRoom();
										scrollToBottom(target_userid);
										// setTimeout(scrollToBottom(), 3000);
									},
									error: function(e) {
										console.log(e);
									}
								})
							};
							setInterval(refreshChatRoom, 10000); //Refresh chatroom automatically every 10 sec

							const incoming_id = '<?php echo $_SESSION["user_id"]; ?>' // get the current user_id

							form.onsubmit = (e) => {
								e.preventDefault();
							}
							inputField.onkeyup = (e) => { //form will submit while clicking enter/return key
								if (e.keyCode === 13) {
									e.preventDefault();
									sendBtn.click();
								}
								// console.log(inputField.value)
								// formData = new FormData(form)
								// console.log(formData)
							}
							const fileUpload = document.querySelector("#fileupload");
							const attachmentBtn = document.querySelector("#frame > div.content > form > div > div:nth-child(1) > button");

							sendBtn.onclick = () => { // Send the message to database
								// console.log(inputField.value)
								if (!!fileUpload.files[0]) {
									// console.log(fileUpload.files[0]); 
									console.log("run file")
									upload(fileUpload.files[0])

								} else {
									console.log("run text")
									$.ajax({
										url: "php/insert.php",
										method: "POST",
										data: {
											"message": inputField.value,
										},
										success: function(result) {
											refreshChatRoom()
											inputField.value = ""; //clear the input once submitted
											scrollToBottom();
										},
										error: function(e) {
											console.log(e);
										}
									})
								}


							}


							function upload(ufile) {
								var file = ufile
								// console.log(file);
								var fd = new FormData();
								// fd.append("incoming_id", incoming_id);
								fd.append("file", file);
								var xhr = new XMLHttpRequest();
								xhr.open('POST', 'php/uploadfile.php', true);

								xhr.upload.onprogress = function(e) {
									if (e.lengthComputable) {
										var percentComplete = (e.loaded / e.total) * 100;
										console.log(percentComplete + '% uploaded');
									}
								};

								xhr.onload = function() {
									if (this.status == 200) {
										// var resp = JSON.parse(this.response);

										// console.log('Server got:', resp);

										// var image = document.createElement('img');
										// image.src = resp.dataUrl;
										// document.body.appendChild(image);
										refreshChatRoom();
										inputField.value = ""
										fileUpload.files[0] = ""; //clear the input once submitted
										scrollToBottom()
										console.log(xhr.response);
									};
								};

								xhr.send(fd);
							}
							attachmentBtn.onclick = () => {
								fileUpload.click()
								inputField.value = "A file is selected"
								// setInterval(upload, 1);

							}

						},
						error: function(e) {
							console.log(e);
						}
					})
				}
			});

			function refreshUserList() {
				$.ajax({
					url: "php/userlist.php",
					method: "GET",
					success: function(result) {
						// console.log("Obtain function runs here!");
						usersList.innerHTML = result;
					},
					error: function(e) {
						console.log(e);
					}
				})
			}
			refreshUserList();
			setInterval(refreshUserList, 60000);

			searchBar.onkeyup = () => {
				let searchTerm = searchBar.value;
				if (searchTerm != "") {
					searchBar.classList.add("active");
				} else {
					searchBar.classList.remove("active");
				}
				let xhr = new XMLHttpRequest();
				xhr.open("POST", "php/search.php", true);
				xhr.onload = () => {
					if (xhr.readyState === XMLHttpRequest.DONE) {
						if (xhr.status === 200) {
							let data = xhr.response;
							//console.log(data);
							if (searchBar.classList.contains("active")) {
								usersList.innerHTML = data;
								console.log(searchTerm)
							} else {
								refreshUserList();
							}
						}
					}
				};
				xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xhr.send("searchTerm=" + searchTerm);
			};


		})
	</script>
	<script>
		$(".messages").animate({
			scrollTop: $(document).height()
		}, "fast");

		$("#profile-img").click(function() {
			$("#status-options").toggleClass("active");
		});

		$(".expand-button").click(function() {
			$("#profile").toggleClass("expanded");
			$("#contacts").toggleClass("expanded");
		});

		$("#status-options ul li").click(function() {
			$("#profile-img").removeClass();
			$("#status-online").removeClass("active");
			$("#status-away").removeClass("active");
			$("#status-busy").removeClass("active");
			$("#status-offline").removeClass("active");
			$(this).addClass("active");

			if ($("#status-online").hasClass("active")) {
				$("#profile-img").addClass("online");
			} else if ($("#status-away").hasClass("active")) {
				$("#profile-img").addClass("away");
			} else if ($("#status-busy").hasClass("active")) {
				$("#profile-img").addClass("busy");
			} else if ($("#status-offline").hasClass("active")) {
				$("#profile-img").addClass("offline");
			} else {
				$("#profile-img").removeClass();
			};

			$("#status-options").removeClass("active");
		});

		function newMessage() {
			message = $(".message-input input").val();
			if ($.trim(message) == '') {
				return false;
			}
			$('<li class="sent"><img src="http://emilcarlsson.se/assets/mikeross.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
			$('.message-input input').val(null);
			$('.contact.active .preview').html('<span>You: </span>' + message);
			$(".messages").animate({
				scrollTop: $(document).height()
			}, "fast");
		};

		$('.submit').click(function() {
			newMessage();
		});

		$(window).on('keydown', function(e) {
			if (e.which == 13) {
				newMessage();
				return false;
			}
		});
	</script>
</body>

</html>