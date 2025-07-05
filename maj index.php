<?php
require_once 'db.php'; // Connexion à la base de données
date_default_timezone_set('Europe/Paris');

// Récupération des IP depuis la base
$stmt = $pdo->query("SELECT * FROM adresses_logiques");
$adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des adresses DHCP</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .button { padding: 10px; margin: 10px; background-color: #d0e0f0; border: 1px solid #555; c>
    </style>
</head>
<body>

<h2 style="text-align:center;">Adresses DHCP détectées</h2>

<div style="text-align:center;">
<form action="scanner.php" method="post">
        <button class="button" type="submit">Mettre à jour depuis DHCP</button>
    </form>
</div>

<?php if (isset($_GET['updated'])): ?>
    <p style="text-align:center; color:green;">Mise à jour effectuée !</p>
<?php endif; ?>

<table>
    <tr>
        <th>IP</th>
        <th>MAC</th>
        <th>Date d’attribution</th>
        <th>Durée (minutes)</th>
    </tr>

    <?php foreach ($adresses as $a): ?>
        <tr>
            <td><?= htmlspecialchars($a['adresse_logique']) ?></td>
            <td><?= htmlspecialchars($a['adresse_physique']) ?></td>
            <td><?= $a['date_attribution'] ?></td>
            <td>
                <?php
                $start = new DateTime($a['date_attribution']);
                $now = new DateTime();
                $interval = $now->diff($start);
                echo ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

