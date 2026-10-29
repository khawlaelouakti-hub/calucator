<?php
ini_set('display_errors', 1);
include("config.php");

if(isset($_POST['btn'])){
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "INSERT INTO users (nom, email, mot_de_passe) VALUES ('$nom', '$email', '$password')";
    
    if(mysqli_query($conn, $sql)){
        echo "Inscription réussie!";
    } else {
        echo "Erreur: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Inscription</title>
</head>
<body>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom" required><br><br>
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <button name="btn">S'inscrire</button>
    </form>
    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
</body>
</html>