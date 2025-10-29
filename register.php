<?php

include 'includes/db.php';

$username = 'admin';
$password = 'admin123';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo " Admin user created successfully.";
} else {
    echo " Error : " . mysqli_error($conn);
}
