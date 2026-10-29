<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Profil</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?> !</h2>
    <p>Vous êtes connecté(e).</p>
    <a href="logout.php">Déconnexion</a>
</body>
</html>