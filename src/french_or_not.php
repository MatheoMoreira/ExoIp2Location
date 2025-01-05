<?php
include('conn_db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

FrenchOrNot($conn);

// Fonction pour savoir si l'utilisateur est français ou non
function FrenchOrNot($conn) {
    // Récupération de l'adresse IP de l'utilisateur DEUX MÉTHODES DIFFÉRENTES ICI :
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // $ip_address = '1.0.8.0'; // Test avec une Adresse IP Chinoise
    // $ip_address = '37.58.179.26'; // Test avec une Adresse IP Française
    
    // Convertir l'adresse IP en nombre entier
    $int_ip = ipToInt($ip_address);

    // Requête SQL pour récupérer le pays et d'autres informations
    $sql = "SELECT country_name, country_code FROM ip2location WHERE ? BETWEEN ip_from AND ip_to";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $int_ip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $country = htmlspecialchars($row["country_name"], ENT_QUOTES, 'UTF-8');
            // Affichage si l'utilisateur est français ou non !
            if ($country === 'France') {
                echo "<div class='relative top-10 flex flex-col items-center p-4 bg-white shadow-md rounded-lg'>
                        <h1 class='text-2xl font-bold text-green-600'>" . htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8') . "</h1>
                        <h1 class='text-2xl font-bold text-green-600'>Bienvenue en France !</h1>
                        <img src='../src/images/france.gif' alt='Bienvenue en France' class='mt-4 w-64 h-64'>
                        </div>";
            } else {
                echo "<div class='relative top-10 flex flex-col items-center p-4 bg-white shadow-md rounded-lg'>
                        <h1 class='text-2xl font-bold text-red-600'>" . htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8') . "</h1>
                        <h1 class='text-2xl font-bold text-red-600'>Tu viens de $country</h1>
                        <h1 class='text-2xl font-bold text-red-600'>Tu n'es pas français !</h1>
                        <img src='../src/images/touche_pas_a_ma_france.jpg' alt='Pas français' class='mt-4 w-64 h-64'>
                        </div>";
            }
        }
    } else {
        echo "<div class='relative top-10 flex flex-col items-center p-4 bg-white shadow-md rounded-lg'>
                <h1 class='text-2xl font-bold text-red-600'>Aucun pays trouvé pour l'adresse IP : " . htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8') . " Adresse IP en entier : ". htmlspecialchars($int_ip, ENT_QUOTES, 'UTF-8'). "</h1>
                </div>";
    }

    $conn->close();
}

// Fonction pour convertir une adresse IP en un nombre entier
function ipToInt($ip_address) {
    $parts = explode('.', $ip_address);
    if (count($parts) === 4) {
        return ($parts[0] * 256 * 256 * 256) + ($parts[1] * 256 * 256) + ($parts[2] * 256) + $parts[3];
    }
    return false;
}

?>