<!doctype html>
<html lang="en">
    <head>

    </head>
    <body>
        <h1>Hello World!</h1>
        <div id="future"></div>
        <form id="form" id="chat_form">
            <input id="chat_input" type="text">
            <input type="submit" value="Send">
        </form>
         <script src="../resources/scripts/jquery-1.10.2.min.js"></script>
        <script src="../resources/scripts/socket.io.js"></script>
<script>
function call_ringing(data){
    var number = data.split(":");
    var ext = "<?php echo $_SESSION["ext"]; ?>";
    ext = '101';
    console.log(number[0]);
    if ((ext.length > 0) && (number[0].length > 2) && (number[1] === ext)){ 
        window.open("http://ql.nhilong.com/popup/makhach.php?phone=" + number[0], '_blank');
    }
}
var socket = io.connect('http://115.79.57.172:3000');
socket.on('ringing', function (data) {
        call_ringing(data);
});
$('#form').submit(function() {
    socket.emit('call',$('#chat_input').val());
});
</script>
</head>
<body>
        <div id="last_event" style="background-color: #FFE6CC;">
        </div>
</body>
</html>

