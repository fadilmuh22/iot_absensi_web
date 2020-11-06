<!DOCTYPE html>
<html>

<head>
    <title>Event Token</title>
</head>

<body>
    <h2>You are registered to the event Seminar Pemuda Hebat</h2>
    <br />
    Your registered email-id is {{$user['email']}} , Please show QR Code below to the event staff
    <br />
    <br />
    <img src="{!!$message->embedData($qrCode, 'QrCode.png', 'image/png')!!}">
</body>

</html>