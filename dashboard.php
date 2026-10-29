<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
include("config.php");

// إضافة منشور جديد
if(isset($_POST['add_post'])){
    $user_id = $_SESSION['user_id'];
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    if(!empty($content)){
        $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
        if(!mysqli_query($conn, $sql)){
            echo "error de publication: " . mysqli_error($conn);
        } else {
            header("Location: dashboard.php");
            exit();
        }
    } else {
        echo "le contenue vide";
    }
}
// إضافة تعليق
if(isset($_POST['add_comment'])){
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $content = mysqli_real_escape_string($conn, $_POST['comment_content']);
    if(!empty($content)){
        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iis", $post_id, $user_id, $content);
        mysqli_stmt_execute($stmt);
    }
    header("Location: dashboard.php");
    exit();
}

// جلب جميع المنشورات مع اسم المستخدم
$posts_query = "SELECT posts.*, users.nom FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.id DESC";
$posts_result = mysqli_query($conn, $posts_query);
if(!$posts_result){
    die("Erreur SQL pour les posts : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Fil d'actualité</title>
<link rel="stylesheet" href="style.css">
<style>
    .post { border:1px solid #ccc; margin:20px; padding:10px; border-radius:10px; }
    .comments { margin-left:30px; background:#f9f9f9; padding:10px; }
    .comment { border-bottom:1px solid #ddd; margin:5px 0; }
    textarea { width:100%; margin:5px 0; }
</style>
</head>
<body>
<h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
<a href="logout.php">Déconnexion</a>

<h3>Nouveau post</h3>
<form method="POST">
    <textarea name="content" rows="3" placeholder="Quoi de neuf ?" required></textarea><br>
    <button name="add_post">Publier</button>
</form>

<h3>Actualités</h3>
<?php while($post = mysqli_fetch_assoc($posts_result)): ?>
    <div class="post">
        <strong><?php echo htmlspecialchars($post['nom']); ?></strong>
        <small>le <?php echo $post['created_at']; ?></small>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

        <!-- Formulaire de commentaire -->
        <form method="POST" style="margin-top:10px;">
            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
            <input type="text" name="comment_content" placeholder="Écrire un commentaire..." required>
            <button name="add_comment">Commenter</button>
        </form>

        <!-- Affichage des commentaires -->
        <div class="comments">
            <?php
            $comment_sql = "SELECT comments.*, users.nom FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY comments.created_at ASC";
            $stmt = mysqli_prepare($conn, $comment_sql);
            mysqli_stmt_bind_param($stmt, "i", $post['id']);
            mysqli_stmt_execute($stmt);
            $comments_result = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($comments_result) == 0){
                echo "<em>Aucun commentaire.</em>";
            } else {
                while($comment = mysqli_fetch_assoc($comments_result)){
                    echo "<div class='comment'><strong>" . htmlspecialchars($comment['nom']) . "</strong> <small>" . $comment['created_at'] . "</small><p>" . nl2br(htmlspecialchars($comment['content'])) . "</p></div>";
                }
            }
            ?>
        </div>
    </div>
<?php endwhile; ?>
</body>
</html>