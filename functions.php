<?php
include "config.php";

function validatePassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password);
}

function saveUser($conn, $emailOrPhone, $password) {
    $stmt = $conn->prepare("INSERT INTO users (email_or_phone, password) VALUES (?, ?)");
    if (!$stmt) {
        echo "Prepare failed: " . $conn->error;
        return false;
    }

    $stmt->bind_param("ss", $emailOrPhone, $password);
    return $stmt->execute();
}


function findUser($conn, $input) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email_or_phone = ?");
    $stmt->bind_param("s", $input);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
