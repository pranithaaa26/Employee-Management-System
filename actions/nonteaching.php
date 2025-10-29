<?php
include '../includes/session.php';
include '../includes/db.php';

if (isset($_GET['id'])) {
    $emp_id = $_GET['id'];
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    // Get employee info
    $sql_emp = "SELECT name, salary FROM employee WHERE id = '$emp_id'";
    $res_emp = mysqli_query($conn, $sql_emp);
    $emp = mysqli_fetch_assoc($res_emp);

    $base_salary = $emp['salary']; // Fixed salary

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_salary'])) {
        $allowances = $_POST['allowances'] ?? 0;
        $deductions = $_POST['deductions'] ?? 0;
        $net_salary = $_POST['net_salary'];
        $check_sql = "SELECT salary_id FROM salary
              WHERE emp_id = '$emp_id'
              AND (
                   (from_date <= '$to_date' AND to_date >= '$from_date')
              )";

        $check_res = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {
            echo "<script>
                alert('Salary record already exists for this employee in the selected date range!');
                window.location.href = 'calsalary.php';
              </script>";
            exit();
        }

        $sql_insert = "INSERT INTO salary (emp_id, from_date, to_date, hours_worked, base_salary, allowances, deductions, net_salary)
               VALUES ('$emp_id', '$from_date', '$to_date', NULL, '$base_salary', '$allowances', '$deductions', '$net_salary')";

        if (mysqli_query($conn, $sql_insert)) {
            echo "<script>
                alert('Salary saved successfully!');
                window.location.href = 'calsalary.php';
              </script>";
            exit();
        } else {
            echo "<p style='color:red;'>Error saving salary: " . mysqli_error($conn) . "</p>";
        }
    }


    include '../includes/header.php';
?>

    <style>
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        footer {
            position: sticky;
            bottom: 0;
            z-index: 1000;
        }

        .main-content {
            max-height: calc(100vh - 140px);
            overflow-y: auto;
            padding: 20px;
            margin-left: 350px;
        }

        .container {
            margin: 20px auto;
            padding: 30px;
            background: #f7f7f7;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            width: 600px;
            font-family: Arial, sans-serif;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
        }


        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .container label {
            font-weight: bold;
            color: #333;
        }

        .container input[type="text"],
        .container input[type="number"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        .container input[disabled],
        .container input[readonly] {
            background: #e9ecef;
            color: #555;
        }

        .container button {
            padding: 10px;
            background: rgb(2, 17, 31);
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .container button:hover {
            background: rgba(20, 46, 72, 1);
        }
    </style>

    <div class="main-content">
        <div class="container">
            <h2>Non-Teaching Staff Salary</h2>
            <form method="POST" id="salaryForm">
                <label>Name:</label>
                <input type="text" value="<?= $emp['name'] ?>" disabled>

                <label>Base Salary:</label>
                <input type="number" value="<?= $base_salary ?>" disabled>

                <label>Allowances:</label>
                <input type="number" name="allowances" value="0" step="0.01" id="allowances">

                <label>Deductions:</label>
                <input type="number" name="deductions" value="0" step="0.01" id="deductions">

                <label>Net Salary:</label>
                <input type="number" name="net_salary" value="<?= $base_salary ?>" step="0.01" id="net_salary" readonly>

                <button type="submit" name="save_salary">Save Salary</button>
            </form>
        </div>
    </div>

    <script>
        const baseSalary = <?= $base_salary ?>;
        const allowancesInput = document.getElementById('allowances');
        const deductionsInput = document.getElementById('deductions');
        const netSalaryInput = document.getElementById('net_salary');

        function updateNetSalary() {
            const allowances = parseFloat(allowancesInput.value) || 0;
            const deductions = parseFloat(deductionsInput.value) || 0;
            netSalaryInput.value = baseSalary + allowances - deductions;
        }

        allowancesInput.addEventListener('input', updateNetSalary);
        deductionsInput.addEventListener('input', updateNetSalary);
    </script>

<?php
    include '../includes/footer.php';
}
?>