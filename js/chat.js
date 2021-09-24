const form = document.querySelector(".content .message-input"),
incoming_id = target_userid,
inputField = form.querySelector(".input-field"),
sendBtn = form.querySelector(".submitbutton"),
//attachBtn = form.querySelector(".attachmentbtn")
ChatBubbleBox = document.querySelector(".content .messages"),
personContactWith = document.querySelector(".content .contact-profile .person-received");
console.log("anything here")
form.onsubmit = (e) => {
    e.preventDefault();
}
inputField.focus();
inputField.onkeyup = () => {
  if (inputField.value != "") {
    sendBtn.classList.add("active");
  } else {
    sendBtn.classList.remove("active");
  }
};
/*
//Not doing first
attachBtn.onclick = () => {
  let xhr = new XMLHttpRequest()
  xhr.open('POST', 'php/insert-attach.php', true)
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        inputField.value = '' //clear the input once submitted
        scrollToBottom()
      }
    }
  }
  let formData = new FormData(form)
  console.log(formData)
  xhr.send(formData)
}
ChatBubbleBox.onmouseenter = () => {
  ChatBubbleBox.classList.add('active')
}
*/

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "insert-chat.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
            inputField.value = "";//clear the input once submitted
            scrollToBottom();
        }
      }
    };
    let formData = new FormData(form);
    console.log(formData)
    xhr.send(formData);
}
ChatBubbleBox.onmouseenter = () => {
  ChatBubbleBox.classList.add("active");
};

ChatBubbleBox.onmouseleave = () => {
  ChatBubbleBox.classList.remove("active");
};

setInterval(() => {
  let xhr = new XMLHttpRequest();
  console.log('getting chat data here outside!')
  xhr.open("POST", "get-chat.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        ChatBubbleBox.innerHTML = data;
        //personContactWith.innerHTML=data;
        console.log("getting chat data here!");

        if (!ChatBubbleBox.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  };
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("incoming_id=" + incoming_id);
}, 500);

function scrollToBottom() {
  ChatBubbleBox.scrollTop = ChatBubbleBox.scrollHeight;
}
  