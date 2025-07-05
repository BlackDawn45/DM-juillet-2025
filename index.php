<?php
// On inclut le fichier qui permet la connexion à la base de données
require_once 'db.php';

// On règle le fuseau horaire pour afficher des dates correctes
date_default_timezone_set('Europe/Paris');

// On prépare la requête SQL pour récupérer toutes les lignes de la table
$sql = "SELECT * FROM adresses_logiques";

// On exécute la requête
$stmt = $pdo->query($sql);

// On récupère toutes les adresses sous forme de tableau PHP
$adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des adresses DHCP</title>
    <style>
        /* On crée un design simple pour la page */
        body { font-family: Arial; padding: 2em; background: #f9f9f9; }
        table { border-collapse: collapse; width: 100%; background: white; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #eee; }
        .attribuee { color: green; font-weight: bold; }
        .disponible { color: orange; font-weight: bold; }
        button { padding: 10px 20px; margin-bottom: 15px; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Adresses DHCP détectées</h1>

    <!-- Formulaire avec bouton pour lancer la mise à jour -->
    <form method="post">
        <button type="submit" name="update">🔄 Mettre à jour depuis DHCP</button>
    </form>

    <!-- Formulaire pour exporter -->
    <form method="get" action="export_yaml.php">
    <button type="submit">📤 Exporter en YAML</button>
    </form>

<?php
// Si on a cliqué sur le bouton "update"
if (isset($_POST['update'])) {
    // On lance le script scanner.php en l'incluant dans la même page
    include 'scanner.php';
    // On recharge la liste mise à jour
    $stmt = $pdo->query($sql);
    $adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<p><strong>Mise à jour effectuée !</strong></p>";
}
?>

    <!-- On commence le tableau -->
    <table>
        <tr>
            <th>IP</th>
            <th>MAC</th>
            <th>Attribuée ?</th>
            <th>Date d’attribution</th>
            <th>Durée (minutes)</th>
        </tr>

        <!-- On affiche chaque adresse dans le tableau -->
        <?php foreach ($adresses as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['adresse_logique']) ?></td>
            <td><?= htmlspecialchars($a['adresse_physique']) ?></td>
            <td class="<?= $a['attribuee'] ? 'attribuee' : 'disponible' ?>">
                <?= $a['attribuee'] ? 'Oui' : 'Non' ?>
            </td>
            <td><?= $a['date_attribution'] ?></td>
            <td>
                <?php
                if ($a['date_attribution']) {
                    // On calcule la durée depuis l’attribution
                    $start = new DateTime($a['date_attribution']);
                    $now = new DateTime();
                    $diff = $now->getTimestamp() - $start->getTimestamp();
                    echo floor($diff / 60); // On affiche la durée en minutes
                } else {
                    echo '-';
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
