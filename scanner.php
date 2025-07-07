<?php
require_once 'db.php'; // Connexion à la base de données
date_default_timezone_set('Europe/Paris');

// On réinitialise la base : suppression de toutes les entrées
$pdo->exec("TRUNCATE TABLE adresses_logiques");

// On lit le fichier des baux DHCP
$leasesFile = '/var/lib/dhcp/dhcpd.leases';
$lines = file($leasesFile);
$leases = [];
$currentIP = '';
$mac = '';
$start = '';
$binding = '';

// On parcourt le fichier pour trouver les baux actifs
foreach ($lines as $line) {
    $line = trim($line);

    if (preg_match('/^lease (.+) {$/', $line, $matches)) {
        $currentIP = $matches[1];
        $mac = '';
        $start = '';
        $binding = '';
    }

    if (strpos($line, 'starts') === 0) {
        $parts = preg_split('/\s+/', $line);
        $start = $parts[2] . ' ' . rtrim($parts[3], ';');
    }

    if (strpos($line, 'binding state') === 0) {
        $binding = trim(explode(' ', $line)[2], ';');
    }

    if (strpos($line, 'hardware ethernet') === 0) {
        $mac = trim(explode(' ', $line)[2], ';');
    }

    if ($line === '}') {
        if ($binding === 'active') {
            // On écrase l'ancienne entrée si on trouve une plus récente
            $leases[$currentIP] = [
                'mac' => $mac,
                'start' => $start
            ];
        }
        $currentIP = '';
    }
}

// On teste si les IP sont en ligne avec un ping
foreach ($leases as $ip => $data) {
    $pingResult = exec("ping -c 1 -W 1 $ip", $output, $status);
    if ($status === 0) { // 0 = la machine a répondu
        // On insère dans la base uniquement les IP en ligne
        $stmt = $pdo->prepare("INSERT INTO adresses_logiques (adresse_logique, adresse_physique, date_attribution) VALUES (:ip, :mac, :date)");
        $stmt->execute([
            'ip' => $ip,
            'mac' => $data['mac'],
            'date' => $data['start']
        ]);
    }
}

// On retourne sur l'IHM
header('Location: index.php?updated=1');
exit;
?>
