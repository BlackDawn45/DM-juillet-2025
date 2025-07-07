<?php
require_once 'db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && hash('sha256', $password) === $user['password_hash']) {
        $_SESSION['user'] = $user['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body { font-family: Arial; background-color: #f4f4f4; }
        .login-box {
            width: 300px; margin: 100px auto;
            padding: 20px; background: white;
            border: 1px solid #ccc; border-radius: 5px;
        }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px; margin-bottom: 10px;
        }
        input[type=submit] {
            width: 100%; padding: 10px;
            background-color: #5cb85c; color: white; border: none;
            border-radius: 3px; cursor: pointer;
        }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Connexion</h2>
    <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="submit" value="Se connecter">
    </form>
</div>

</body>
</html>
