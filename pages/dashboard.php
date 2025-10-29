<?php
include '../includes/session.php';
include '../includes/db.php';
include '../includes/header.php';
?>

<?php

$sql_total = "SELECT COUNT(*) AS total FROM employee";
$res_total = mysqli_query($conn, $sql_total);
$total = mysqli_fetch_assoc($res_total)['total'];

$sql_teach = "SELECT COUNT(*) AS teaching FROM employee WHERE employeementtype='Teaching'";
$res_teach = mysqli_query($conn, $sql_teach);
$teaching = mysqli_fetch_assoc($res_teach)['teaching'];

$sql_non = "SELECT COUNT(*) AS nonteaching FROM employee WHERE employeementtype='Non-Teaching'";
$res_non = mysqli_query($conn, $sql_non);
$nonteaching = mysqli_fetch_assoc($res_non)['nonteaching'];
?>
<div class="dashboard">
    <div class="card">
        <h3>Employees</h3>
        <p>Total Employees: <b><?= $total ?></b></p>
        <p>Teaching Staff: <b><?= $teaching ?></b></p>
        <p>Non-Teaching Staff: <b><?= $nonteaching ?></b></p>
    </div>
</div>
<style>
    .dashboard {
        display: flex;
        justify-content: center;
        /* centers horizontally */

        /* space between cards */
        margin-top: 40px;
        /* pushes down from top */
        margin-left: 250px;
    }

    .card {
        background: #fff;
        padding: 20px;
        margin: 15px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 250px;
        display: inline-block;
        vertical-align: top;
        height: 180px;
    }

    .card h3 {
        margin-bottom: 10px;
        color: #333;
        position: relative;
        font-size: 20px;
        font-weight: bold;
    }

    .card h3::after {
        content: "";
        display: block;
        width: 100%;
        height: 2px;
        background: #ddd;
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .card p {
        margin: 5px 0;
        color: #555;
    }
</style>
<?php
$today = date('Y-m-d');
$sql_att = "SELECT COUNT(*) AS present FROM attendance WHERE date='$today' AND status='Present'";
$res_att = mysqli_query($conn, $sql_att);
$present = mysqli_fetch_assoc($res_att)['present'];
?>
<div class="dashboard">


    <div class="card">
        <h3>Today's Attendance</h3>
        <p>Present Today: <b><?= $present ?></b></p>
        <br>
        <a href="../actions/markattendance.php" style="font-weight:bold; color:#2a4d9c; text-decoration:none;">+ Add Attendance</a>
    </div>
</div>
<?php include '../includes/footer.php' ?>