<?php
include('assets/conn_db.php');

FrenchOrNot($conn);

// Fonction pour savoir si l'user est français ou non
function FrenchOrNot($conn) {
    // Récupération de l'adresse IP de l'utilisateur DEUX MÉTHODES DIFFÉRENTES ICI :
    // $ip_address = $_SERVER['REMOTE_ADDR'];
    $ip_address = getPublicIP();

    // $ip_address = '1.90.113.0'; // Test avec une Adresse IP Chinoise
    // $ip_address = '37.58.179.26'; // Test avec une Adresse IP Française
    
    // Convertir l'adresse IP en nombre entier
    $int_ip = ipToInt($ip_address);

    // if ($int_ip !== false) {
    //     echo "<p>L'adresse IP $ip_address convertie en nombre entier est : $int_ip</p>";
    // } else {
    //     echo "<p>Adresse IP invalide.</p>";
    // }

    // Requête SQL pour récupérer le pays et d'autres informations
    $sql = "SELECT country_name, region_name, city_name, latitude, longitude FROM geoip WHERE ? BETWEEN ip_from AND ip_to";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $int_ip);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $country = htmlspecialchars($row["country_name"], ENT_QUOTES, 'UTF-8');
            // Affichage si l'utilisateur est français ou non !
            if ($country === 'France') {
                echo "<div class='relative top-10 flex flex-col items-center p-4 bg-white shadow-md rounded-lg'>
                        <h1 class='text-2xl font-bold text-green-600'>" . htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8') . "</h1>
                        <h1 class='text-2xl font-bold text-green-600'>Bienvenue en France !</h1>
                        <img src='assets/images/france.gif' alt='Bienvenue en France' class='mt-4 w-64 h-64'>
                        </div>";
            } else {
                echo "<div class='relative top-10 flex flex-col items-center p-4 bg-white shadow-md rounded-lg'>
                        <h1 class='text-2xl font-bold text-red-600'>" . htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8') . "</h1>
                        <h1 class='text-2xl font-bold text-red-600'>Tu viens de $country</h1>
                        <h1 class='text-2xl font-bold text-red-600'>Tu n'es pas français !</h1>
                        <img src='assets/images/touche_pas_a_ma_france.jpg' alt='Pas français' class='mt-4 w-64 h-64'>
                        </div>";
            }
        }
    } else {
        echo "<div class='relative top-10 flex flex-col items-center p-4 bg-white shadow-md rounded-lg'>
                <h1 class='text-2xl font-bold text-red-600'>Aucun pays trouvé pour l'adresse IP : " . htmlspecialchars($ip_address, ENT_QUOTES, 'UTF-8') . "</h1>
                </div>";
    }

    $conn->close();
}

// Fonction qui vas intéroger une api pour avoir l'adreses IP
function getPublicIP() {
    $apiUrl = "https://api.ipify.org/?format=json";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo "Erreur cURL : " . curl_error($ch);
        return null;
    }
    
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    // Vérifier si l'IP est présente dans la réponse
    if (isset($data['ip'])) {
        return $data['ip'];
    } else {
        echo "Erreur : impossible de récupérer l'adresse IP.";
        return null;
    }
}

// Fonction pour convertir une adresse IP en un nombre entier
function ipToInt($ip_address) {
    $parts = explode('.', $ip_address);
    if (count($parts) === 4) {
        return ($parts[0] * 256 * 256 * 256) + ($parts[1] * 256 * 256) + ($parts[2] * 256) + $parts[3];
    }
    return false;
}

// Fonction pour convertir un nombre entier en adresse IP
function IntToIP($int_ip) {
    return long2ip($int_ip);
}

?>


