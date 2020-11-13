<!DOCTYPE html>
<html>

<head>
    <title>Event Token</title>
</head>

<body>
    <h2>You are registered to the event {{$event->nama}}</h2>
    <br />
    <p>Please attend this event on {{$event->tanggal}}</p>
    <br>
    Please show the QR Code below to the event staff
    <br />
    <br />
    <img src="{!!$message->embedData($qrCode, 'QrCode.png', 'image/png')!!}">
</body>

</html>