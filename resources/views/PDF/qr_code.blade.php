<html>
<head>
    <title>QR Code PDF</title>
</head>
<body>
    <div>
        <h1>QR Code PDF</h1>
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>
</body>
</html>