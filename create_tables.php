<?php
include("config.php");

$sql_posts = "CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$sql_comments = "CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if(mysqli_query($conn, $sql_posts)){
    echo "Table 'posts' créée avec succès.<br>";
} else {
    echo "Erreur pour 'posts': " . mysqli_error($conn) . "<br>";
}

if(mysqli_query($conn, $sql_comments)){
    echo "Table 'comments' créée avec succès.<br>";
} else {
    echo "Erreur pour 'comments': " . mysqli_error($conn) . "<br>";
}
?>