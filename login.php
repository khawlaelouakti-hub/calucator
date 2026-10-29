<?php
session_start();
include("config.php");

$error = "";
if(isset($_POST['btn_login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        if($password == $user['mot_de_passe']){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nom'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Mot de passe incorrect";
        }
    } else {
        $error = "Email non trouvé";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Connexion</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Connexion</h2>
    <?php if($error != "") echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <button name="btn_login">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
</body>
</html>