<html>

<head>
<meta charset="utf-8">
  <title>oChat WebSocket BY Jamal Hassouni</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-push-2 col-md-8">
            <h2>oChat WebSocket Application</h2>
            <h3>Messages for <span class="username label label-primary"></span></h3>
            <div class="row">
                <form action="" class="username_setter">
                    <div class="form-group">
                        <label for="">Set username</label>
                        <input type="text" name="name" value="" class="form-control username-input">
                    </div>
                    <button class="btn btn-primary pull-right" type="submit" name="button">Set</button>

                </form>
            </div>
            <h3>Messages </h3>
            <ul class="messages-list">

            </ul>
            <form action="index.php" method="post" class="chatForm">
               <div class="form-group">
                   <label for="message">Message</label>
                   <div class="typing"></div>
                   <textarea name="message" id="message" cols="10" rows="10" class="form-control"></textarea>

               </div>
                <div class="">
                    <button type="submit" name="send" class="btn btn-primary pull-right">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="js/main.js"></script>
</html>