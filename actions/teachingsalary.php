<?php
include '../includes/session.php';
include '../includes/db.php';

if (isset($_GET['id'], $_GET['from_date'], $_GET['to_date'])) {
    $emp_id = $_GET['id'];
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

    // Get employee info
    $sql_emp = "SELECT name, salary FROM employee WHERE id = '$emp_id'";
    $res_emp = mysqli_query($conn, $sql_emp);
    $emp = mysqli_fetch_assoc($res_emp);


    // Get hourly rate from employee table
    $sql_emp = "SELECT name, salary FROM employee WHERE id = '$emp_id'";
    $res_emp = mysqli_query($conn, $sql_emp);
    $emp = mysqli_fetch_assoc($res_emp);

    // Get total hours worked from attendance
    $sql_att = "SELECT SUM(hours) AS total_hours 
                FROM attendance 
                WHERE id = '$emp_id' AND date BETWEEN '$from_date' AND '$to_date' AND status='Present'";
    $res_att = mysqli_query($conn, $sql_att);
    $att = mysqli_fetch_assoc($res_att);

    $total_hours = $att['total_hours'] ?? 0;
    $hourly_rate = $emp['salary'];
    $base_salary = $total_hours * $hourly_rate;
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_salary'])) {
        $allowances = $_POST['allowances'] ?? 0;
        $deductions = $_POST['deductions'] ?? 0;
        $net_salary = $_POST['net_salary'];


        $check_sql = "SELECT salary_id FROM salary
                  WHERE emp_id = '$emp_id'
                  AND NOT (to_date < '$from_date' OR from_date > '$to_date')";
        $check_res = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_res) > 0) {

            echo "<script>
            alert('Salary record already exists for this employee in the selected date range!');
            window.location.href = 'calsalary.php';
        </script>";
            exit();
        }


        $sql_insert = "INSERT INTO salary (emp_id, from_date, to_date, hours_worked, base_salary, allowances, deductions, net_salary)
                   VALUES ('$emp_id', '$from_date', '$to_date', '$total_hours', '$base_salary', '$allowances', '$deductions', '$net_salary')";
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
            z-index: 1000;

        }

        .main-content {
            max-height: calc(100vh - 140px);
            overflow-y: auto;
            box-sizing: border-box;
            margin-left: 350px;
            margin-top: 10px;

        }

        .container {
            /* max-width: 900px;*/
            margin-left: 30px;
            padding: 30px;
            background-color: #f7f7f7;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            font-family: Arial, sans-serif;
            width: 600px;
        }


        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
        }


        .container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }


        .container label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .container input[type="text"],
        .container input[type="number"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
        }

        .container input[disabled],
        .container input[readonly] {
            background-color: #e9ecef;
            color: #555;
        }

        .container button {
            padding: 10px;
            background-color: rgb(2, 17, 31);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;

        }

        .container button:hover {
            background-color: rgba(20, 46, 72, 1);
        }

        .calc {
            display: flex;
            flex-direction: column;
        }

        .main-content::-webkit-scrollbar {
            width: 8px;
        }
    </style>
    <div class="main-content">
        <div class="container">
            <h2>Teaching Staff Salary</h2>
            <form method="POST" id="salaryForm">
                <div class="calc">
                    <label>Name:</label>
                    <input type="text" value="<?= $emp['name'] ?>" disabled>
                </div>

                <div class="calc">
                    <label>Hourly Rate:</label>
                    <input type="number" value="<?= $hourly_rate ?>" disabled>
                </div>

                <div class="calc">
                    <label>Total Hours Worked:</label>
                    <input type="number" value="<?= $total_hours ?>" disabled>
                </div>

                <div class="calc">
                    <label>Allowances:</label>
                    <input type="number" name="allowances" value="0" step="0.01" id="allowances">
                </div>

                <div class="calc">
                    <label>Deductions:</label>
                    <input type="number" name="deductions" value="0" step="0.01" id="deductions">
                </div>

                <div class="calc">
                    <label>Net Salary:</label>
                    <input type="number" name="net_salary" value="<?= $base_salary ?>" step="0.01" id="net_salary" readonly>
                </div>

                <button type="submit" name="save_salary">Save Salary</button>
            </form>
        </div>
    </div>

    <script>
        const baseSalary = <?= $base_salary ?>;
        const allowancesinput = document.getElementById('allowances');
        const deductionsinput = document.getElementById('deductions');
        const netsalaryinput = document.getElementById('net_salary');

        function updatenetsalary() {
            const allowances = parseFloat(allowancesinput.value) || 0;
            const deductions = parseFloat(deductionsinput.value) || 0;
            netsalaryinput.value = baseSalary + allowances - deductions;
        }

        allowancesinput.addEventListener('input', updatenetsalary);
        deductionsinput.addEventListener('input', updatenetsalary);
    </script>
<?php
}
include '../includes/footer.php';
?>