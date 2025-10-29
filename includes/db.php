<?php

$host = "sql107.infinityfree.com";
$user = "if0_40274726";
$pass = "PJYKtDsjpzq";
$name = "if0_40274726_emp";

$conn = mysqli_connect($host, $user, $pass, $name);


if (!$conn) {
     die("connection failed." . mysqli_connect_error());
}
