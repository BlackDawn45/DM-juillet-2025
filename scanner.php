<?php
// On inclut la connexion à la base de données
require_once 'db.php';

// On règle le fuseau horaire
date_default_timezone_set('Europe/Paris');

// On lit tout le fichier dhcpd.leases et on met chaque ligne dans un tableau
$lines = file('dhcpd.leases');

// On initialise les variables
$ip = $mac = $start = null;
$inserted = 0; // Compteur d’IP ajoutées
$updated = 0;  // Compteur d’IP mises à jour

// On parcourt chaque ligne du fichier
foreach ($lines as $line) {
    $line = trim($line); // On enlève les espaces

    // Si la ligne commence par "lease", c’est une nouvelle adresse IP
    if (str_starts_with($line, "lease ")) {
        $ip = explode(" ", $line)[1]; // On récupère l’IP
    }

    // Si la ligne commence par "starts", c’est la date d’attribution
    if (str_starts_with($line, "starts ")) {
        preg_match('/starts \d (\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2});/', $line, $matches);
        $start = $matches[1] ?? null; // On récupère la date
    }

    // Si la ligne contient l’adresse MAC
    if (str_starts_with($line, "hardware ethernet")) {
        $mac = explode(" ", $line)[2]; // On récupère la MAC
    }

    // Quand on arrive à la fin d’un bloc DHCP
    if ($line === "}") {
        if ($ip && $mac && $start) {
            // On convertit la date au format MySQL
            $start_dt = DateTime::createFromFormat('Y/m/d H:i:s', $start);
            $start_mysql = $start_dt ? $start_dt->format('Y-m-d H:i:s') : null;

            // Requête : insérer ou mettre à jour la ligne
            $sql = "INSERT INTO adresses_logiques (adresse_logique, adresse_physique, attribuee, date_attribution)
                    VALUES (:ip, :mac, true, :date)
                    ON DUPLICATE KEY UPDATE
                    adresse_physique = VALUES(adresse_physique),
                    date_attribution = VALUES(date_attribution),
                    attribuee = true";

            // On prépare et on exécute la requête
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':ip' => $ip,
                ':mac' => $mac,
                ':date' => $start_mysql
            ]);

            // On compte les ajouts et les mises à jour
            if ($stmt->rowCount() === 1) {
                $inserted++;
            } else {
                $updated++;
            }
        }

        // On vide les variables pour la prochaine adresse
        $ip = $mac = $start = null;
    }
}

// On peut afficher ces messages dans index.php si besoin
?>
