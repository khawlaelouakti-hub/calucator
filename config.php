<?php
$conn = mysqli_connect("localhost", "root", "", "mini_facebook");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>