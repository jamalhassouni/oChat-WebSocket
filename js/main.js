/* global  $    */
$(document).ready(function () {
    var conn = new WebSocket("ws://localhost:8080"),
        chatForm  = $('.chatForm'),
        messageInputField = chatForm.find("#message"),
        messageList = $(".messages-list"),
        usernameForm = $(".username_setter"),
        usernameInput = usernameForm.find('.username-input'),
        whoTyping = $('.typing');

     chatForm.on("submit",function (e) {
         whoTyping.html(" ");
      e.preventDefault();
      var message = {
          text:messageInputField.val(),
          sender:$.cookie('chat_name'),
          type:'message'
      };
      conn.send(JSON.stringify(message));
         messageList.append("<li class='me'>"+message.text+"</li>");
         messageInputField.val(" ");
         var message = {
             text:" ",
             sender:" ",
             type:'typing'
         };
         conn.send(JSON.stringify(message));
     });

     usernameForm.on("submit",function (e) {
         e.preventDefault();
         var chatName = usernameInput.val();
         if (chatName.length > 0){
            $.cookie("chat_name",chatName);
            $('.username').text(chatName);
         }
     });
    conn.onopen = function (ev) {
        console.log("Connection established");
        $.ajax({
           url :"loadMessages.php",
           dataType:"json",
            success:function (data) {
                $.each(data, function () {
                    if (this.sender === $.cookie('chat_name')){
                        messageList.append('<li class="me">'+this.text+'</li>');
                    }else{
                        messageList.append('<li>'+this.text+'</li>');
                    }
                });
            }
        });
        var chatName =  $.cookie('chat_name');
        if (!chatName){
            var timestamp = (new Date()).getTime();
            chatName ='anonymous'+timestamp;
            $.cookie('chat_name',chatName);
        }
        $(".username").text(chatName);
    };
    conn.onmessage = function (ev) {
        var data = JSON.parse(ev.data);
        console.log(data.data);
        if (data.type ==="message"){
            messageList.append("<li>"+data.data+"</li>");
        }
        else if (data.type ==="typing"){
           if (data.data !==" "){
               whoTyping.html("<span>"+data.data+" typing ...</span>");
           }else {
               whoTyping.html(" ");
           }
        }
    };



    //Indicate that user is typing
    messageInputField.on('keyup', function(){
        var msg = messageInputField.val().trim();
        //if user is typing
        if(msg !==""){
            var message = {
                text:messageInputField.val(),
                sender:$.cookie('chat_name'),
                type:'typing'
            };

            conn.send(JSON.stringify(message));

        }else {
            var message = {
                text:" ",
                sender:" ",
                type:'typing'
            };
            conn.send(JSON.stringify(message));
        }



    });
});