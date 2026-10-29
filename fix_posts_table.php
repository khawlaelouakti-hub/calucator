<?php
include("config.php");

// حذف الجدول القديم إذا وجد
mysqli_query($conn, "DROP TABLE IF EXISTS posts");

// إنشاء الجدول بالأعمدة الصحيحة
$sql = "CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if(mysqli_query($conn, $sql)){
    echo "✅ تم إنشاء جدول 'posts' بنجاح بالأعمدة المطلوبة.";
} else {
    echo "❌ خطأ: " . mysqli_error($conn);
}
?>