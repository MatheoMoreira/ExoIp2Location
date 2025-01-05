<?php 
// Mesure du temps d'exécution
$index_start = microtime(true);


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ip2Location</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="assets/images/france.gif" type="image/x-icon">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-between">
    <!-- Section principale avec le bouton centré -->
    <div class="flex-grow flex items-center justify-center">
        <div id="result" class="text-center">
            <button 
                class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300"
                onclick="checkFrenchOrNot()">
                Vérifier si je suis Français
            </button>
        </div>
    </div>

    <!-- Section pour le temps d'exécution alignée en bas -->
    <footer class="bg-gray-200 py-4 text-center">
        <?php

            if ( !isset($_SERVER['DOCUMENT_ROOT'])) {
                throw new \Exception("Fatal error: This application must be run in a web environnement.", 1);
            }

            // Configuration dossiers
            $sBasepath = $_SERVER['DOCUMENT_ROOT'].'/';
            $sClassPath = $sBasepath . 'src/';
            require_once($sClassPath . "autoload.php");

            // Calcul du temps d'exécution
            $index_end = microtime(true);
            $temps_execution = ($index_end - $index_start) * 1000;
            echo "Le temps d'exécution de la page est de : " . number_format($temps_execution, 3, '.', '') . " ms";
        ?>
    </footer>

    <script>
        function checkFrenchOrNot() {
            fetch('../src/french_or_not.php')
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
