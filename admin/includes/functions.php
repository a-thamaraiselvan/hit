<?php
session_start();

function checkLogin() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }
}

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function slugify($text) {
    // Replace non letter or digits by _
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '_');
    // Remove duplicate _
    $text = preg_replace('~_+~', '_', $text);
    // Lowercase
    $text = strtolower($text);
    if (empty($text)) {
        return 'faculty_image';
    }
    return $text;
}
?>