<!DOCTYPE html>
<html>
<head>
    <title>Your Message</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .qr-container { text-align: center; margin: 20px 0; }
        .message { margin-top: 30px; line-height: 1.6; }
        .qr-image { width: 200px; height: 200px; }
    </style>
</head>
<body>
    <h1>Hello, {{ $name }}!</h1>
    
    <div class="qr-container">
        <img class="qr-image" src="{{ $qrImage }}" alt="QR Code">
        <p>Scan this QR code to see your name</p>
    </div>
    
    <div class="message">
        <h2>Greetings!</h2>
        <p>{{ $message }}</p>
    </div>
</body>
</html>