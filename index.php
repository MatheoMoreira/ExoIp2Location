<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ip2Location</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="assets/images/france.gif" type="image/x-icon">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div id="result" class="text-center">
        <button 
            class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300"
            onclick="checkFrenchOrNot()">
            Vérifier si je suis Français
        </button>
    </div>

    <script>
        function checkFrenchOrNot() {
            fetch('french_or_not.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('result').innerHTML = data;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }
    </script>
</body>
</html>