<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generator</title>
    {{-- @vite('resources/css/app.css')  --}}
</head>
<body class="p-6">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">QR Code Generator</h1>
        
        <form action="/generate-qr-pdf" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Name (for QR code):</label>
                <input type="text" name="name" required 
                       class="w-full px-3 py-2 border rounded-md">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Message (for PDF):</label>
                <textarea name="message" rows="4" required
                          class="w-full px-3 py-2 border rounded-md"></textarea>
            </div>
            
            <button type="submit" 
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Generate & Download PDF
            </button>
        </form>
    </div>
</body>
</html>