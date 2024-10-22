<?php
session_start();
header('Content-Type: application/json'); // Set the content type to JSON

if (isset($_POST['sub'])) {
    $_SESSION['name'] = $_POST['fname'];
    $_SESSION['email'] = $_POST['mail'];
    $_SESSION['num'] = $_POST['number'];
    $_SESSION['pass'] = $_POST['pass'];
    echo json_encode(['success' => true]);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid form submission']);
    exit;
}
?>
