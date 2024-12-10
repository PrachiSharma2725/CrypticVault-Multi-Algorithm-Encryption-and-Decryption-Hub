<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $key_id = $_POST['key_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM user_keys WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $key_id, $user_id);
    $stmt->execute();

    header("Location: profile.php");
    exit;
}
?>
