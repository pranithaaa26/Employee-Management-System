<?php
include '../includes/db.php';
include '../includes/header.php';

// Fetch all salary records
$sql = "SELECT s.salary_id, e.name, e.employeementtype, 
               s.from_date, s.to_date, 
               s.hours_worked, s.base_salary, 
               s.allowances, s.deductions, s.net_salary, s.created_at
        FROM salary s
        INNER JOIN employee e ON s.emp_id = e.id
        ORDER BY s.salary_id DESC";

$result = mysqli_query($conn, $sql);
if (!$result) {
    die("SQL Error: " . mysqli_error($conn));
}
?>

<style>
    .salary-title {
        margin: 20px 0;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
    }

    .table-container {
        width: 95%;
        margin: 20px auto;
        overflow-y: auto;
        /* ✅ Vertical scrollbar */
        max-height: 500px;
        /* ✅ Limit table height */
        border: 1px solid #ccc;
        border-radius: 8px;
        background: white;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table th,
    table td {
        border: 1px solid #999;
        padding: 10px 12px;
        text-align: center;
        white-space: nowrap;
    }

    table th {
        background: rgb(2, 17, 31);
        color: white;
        text-transform: uppercase;
        position: sticky;
        top: 0;
        /* ✅ Keep headers visible when scrolling */
        z-index: 2;
    }
</style>



<?php
if (mysqli_num_rows($result) > 0) {
    echo "<div class='table-container'>";
    echo "<table>";
    echo "<tr>
         
            <th>Employee Name</th>
            <th>Type</th>
            <th>From Date</th>
            <th>To Date</th>
            <th>Hours Worked</th>
            <th>Base Salary</th>
            <th>Allowances</th>
            <th>Deductions</th>
            <th>Net Salary</th>
           
          </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";

        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['employeementtype']}</td>";
        echo "<td>{$row['from_date']}</td>";
        echo "<td>{$row['to_date']}</td>";
        echo "<td>{$row['hours_worked']}</td>";
        echo "<td>{$row['base_salary']}</td>";
        echo "<td>{$row['allowances']}</td>";
        echo "<td>{$row['deductions']}</td>";
        echo "<td><b>{$row['net_salary']}</b></td>";

        echo "</tr>";
    }
    echo "</table>";
    echo "</div>"; // close table-container
} else {
    echo "<p style='text-align:center; color:red;'>No salary records found.</p>";
}

include '../includes/footer.php';
?>