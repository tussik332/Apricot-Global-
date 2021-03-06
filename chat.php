<?php
include_once('auth.php');
include_once('chat_working.php');

$auth = new auth();
$work = new chat_working();

if (!isset($_COOKIE['checked'])) {
    header('Location: ' . $auth->getUrl('chat.php'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

<meta charset="UTF-8">
<title>Lifechat</title>
<link href="style.css" rel="stylesheet">
<script type="text/javascript" src="http://www.google.com/jsapi"></script>

<script type="text/javascript">

    google.load("jquery", "1.3.2");
    google.load("jqueryui", "1.7.2");


    function send() {

        var mess = $("#mess_to_send").val();
        var us_id = $("#user_id").val();

        $.ajax({
            type: "POST",
            url: "add_mess.php",
            data: {text_message: mess, sub: us_id},

            success: function (html) {

                load_messes();

                $("#mess_to_send").val('');
            }
        });
    }


    function load_messes() {
        $.ajax({
            type: "POST",
            url: "load_messes.php",
            data: "req=ok",

            success: function (html) {

                $("#messages").empty();
                $("#messages").append(html);
                $("#messages").scrollTop(90000);
            }
        });
    }

</script>
<div>
    You logged as '<b> <?php echo $_COOKIE['checked']; ?></b> ' .
    <a href="ex.php">EXIT!</a>
</div>
<div class="all">
    <div class="dinamic" id="messages"></div>

    <div>
        <form action="javascript:send();" method="post">
            <div class="form">
                <label><b>Your text message:</b></label>

                <p><textarea name="text_message" id="mess_to_send" required></textarea></p>
            </div>
            <button type="submit" name="sub" id="user_id" value="<?php echo $work->getId($_COOKIE['checked']); ?>">
                Send
            </button>
        </form>
    </div>
</div>

<script>
    load_messes();

    setInterval(load_messes, 5000);
</script>

</body>
</html>