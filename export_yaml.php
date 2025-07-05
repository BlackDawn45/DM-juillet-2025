<?php
require_once 'db.php';

// On récupère toutes les adresses
$sql = "SELECT * FROM adresses_logiques";
$stmt = $pdo->query($sql);
$adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// On génère le YAML
$yaml = "---\nadresses:\n";

foreach ($adresses as $a) {
    $yaml .= "  - ip: \"" . $a['adresse_logique'] . "\"\n";
    $yaml .= "    mac: \"" . $a['adresse_physique'] . "\"\n";
    $yaml .= "    attribuee: " . ($a['attribuee'] ? 'true' : 'false') . "\n";
    $yaml .= "    date_attribution: \"" . $a['date_attribution'] . "\"\n";
}

// Envoie les bons en-têtes pour forcer le téléchargement
header('Content-Type: text/yaml');
header('Content-Disposition: attachment; filename="adresses.yaml"');
echo $yaml;
?>
