<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = escape($_POST['name']);
    $email = escape($_POST['email']);
    $message = escape($_POST['message']);
    
    // Insert ke database
    $insert = $conn->query("INSERT INTO testimonials (name, email, message, rating, status) 
                           VALUES ('$name', '$email', '$message', 0, 'pending')");
    
    if ($insert) {
        // Redirect kembali dengan pesan sukses
        header('Location: index.php?message=sent');
        exit();
    }
}

redirect('index.php');
?>
