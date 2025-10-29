<?php

include '../includes/db.php';


$message = "";

// Handle salary save (if any)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_salary'])) {
    $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
    $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
    $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
    $hours_worked = $_POST['hours_worked'] ?? 0;
    $base_salary = $_POST['base_salary'];
    $allowances = $_POST['allowances'] ?? 0;
    $deductions = $_POST['deductions'] ?? 0;
    $net_salary = $_POST['net_salary'];

    $sql = "INSERT INTO salary (emp_id, from_date, to_date, hours_worked, base_salary, allowances, deductions, net_salary)
            VALUES ('$emp_id', '$from_date', '$to_date', '$hours_worked', '$base_salary', '$allowances', '$deductions', '$net_salary')";
    if (mysqli_query($conn, $sql)) {
        $message = "Salary saved successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle redirect to teaching andnon-teaching salary calculation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emp_id'], $_POST['from_date'], $_POST['to_date'])) {
    $emp_id = mysqli_real_escape_string($conn, $_POST['emp_id']);
    $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
    $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);

    $sql = "SELECT employeementtype FROM employee WHERE id = '$emp_id'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        if ($row['employeementtype'] == 'Teaching') {
            header("Location: teachingsalary.php?id=$emp_id&from_date=$from_date&to_date=$to_date");
            exit();
        } else {
            header("Location: nonteaching.php?id=$emp_id&from_date=$from_date&to_date=$to_date");
            exit();
        }
    } else {
        $message = "Employee not found.";
    }
}
include '../includes/header.php';
?>

<style>
    .table-container {
        max-height: 350px;
        /* control vertical scroll */
        overflow-y: auto;
        /* only vertical scroll */
        overflow-x: hidden;
        /* prevent horizontal scrollbar */
        margin-top: 20px;
        width: 90%;
    }

    .calc {
        margin: 0;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 15px;
        white-space: nowrap;
        margin-left: 10px;
        margin-top: 10px;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        width: 100%;
    }

    form {
        padding: 15px;
        border-radius: 8px;
        margin-top: 50px;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
    }

    form label {
        margin-right: 5px;
        font-weight: bold;
        color: #333;
    }

    form input,
    form button {
        padding: 6px 12px;
        border: 1px solid #aaa;
        border-radius: 5px;
    }

    form button {
        background: rgb(2, 17, 31);
        color: white;
        cursor: pointer;
        border: none;
    }

    form button:hover {
        background: rgba(41, 76, 109, 1);
    }

    .submit {
        background: rgb(2, 17, 31);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
    }

    table {
        margin-right: 130px;
        border-collapse: collapse;
        width: 100%;
        background: white;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }

    table th,
    table td {
        border: 1px solid #999;
        padding: 10px 15px;
        text-align: center;
    }

    table th {
        background: rgb(2, 17, 31);
        color: white;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        z-index: 2;
    }
</style>

<h2 class="calc" style="text-align: center;">Salary Calculation</h2>
<?php if ($message) echo "<p style='color:green;'>$message</p>"; ?>

<div class="container">
    <!-- Date Range -->
    <form method="POST">
        <label>From Date:</label>
        <input type="date" name="from_date" required>
        <label>To Date:</label>
        <input type="date" name="to_date" required>
        <button type="submit">Ok</button>
    </form>

    <?php
    // Show employee list if date range selected
    if (isset($_POST['from_date'], $_POST['to_date'])) {

        $from_date = $_POST['from_date'];
        $to_date = $_POST['to_date'];

        $emp_sql = "SELECT id, name, employeementtype FROM employee";
        $emp_res = mysqli_query($conn, $emp_sql);

        echo "<div class='table-container'>";
        echo "<table border='1' cellpadding='8'>";

        echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Action</th></tr>";

        while ($row = mysqli_fetch_assoc($emp_res)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['employeementtype']}</td>";
            echo "<td>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='emp_id' value='{$row['id']}'>
                    <input type='hidden' name='from_date' value='$from_date'>
                    <input type='hidden' name='to_date' value='$to_date'>
                    <button class='submit' type='submit'>Calculate Salary</button>
                </form>
              </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    }
    ?>

</div>

<?php include '../includes/footer.php'; ?>