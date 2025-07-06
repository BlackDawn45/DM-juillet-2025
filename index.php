<?php
require_once 'db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
date_default_timezone_set('Europe/Paris');

$stmt = $pdo->query("SELECT * FROM adresses_logiques ORDER BY date_attribution DESC");
$adresses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des adresses DHCP</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f7f7f7; }
        h2 { text-align: center; color: #333; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; background: white; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background-color: #eee; }
        .button {
            padding: 10px 20px;
            margin: 10px 5px;
            background-color: #cfe3f5;
            border: 1px solid #666;
            border-radius: 4px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #bcd7ec;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Adresses DHCP détectées</h2>
<p class="center">👤 Connecté en tant que <?= htmlspecialchars($_SESSION['user']) ?> | <a href="logout.php">Déconnexion</a></p>

<div class="center">
    <!-- Bouton mettre à jour -->
    <form action="scanner.php" method="post" style="display:inline;">
        <button class="button" type="submit">🔄 Mettre à jour depuis DHCP</button>
    </form>

    <!-- Bouton export YAML -->
    <form action="export_yaml.php" method="post" style="display:inline;">
        <button class="button" type="submit">📄 Exporter en YAML</button>
    </form>
</div>

<?php if (isset($_GET['updated'])): ?>
    <p class="center" style="color: green;">✅ Mise à jour effectuée avec succès</p>
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
            <td><?= htmlspecialchars($a['date_attribution']) ?></td>
            <td>
                <?php
                if (!empty($a['date_attribution'])) {
                    $start = new DateTime($a['date_attribution']);
                    $now = new DateTime();
                    $interval = $now->diff($start);
                    echo ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
                } else {
                    echo "-";
                }
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
