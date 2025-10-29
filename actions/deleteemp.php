<?php
include '../includes/db.php';
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $result = mysqli_query($conn, "SELECT name FROM employee WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
    $empname = $row['name'];

    $sql = "DELETE FROM employee WHERE id=$id";
    if (!mysqli_query($conn, $sql)) {
        die("Delete failed: " . mysqli_error($conn));
    }

    echo "<script>
    alert('Employee \"$empname\" has been deleted sucessfully');
    window.location.href=' ../actions/viewemp.php';
    </script>";
    exit;
}
