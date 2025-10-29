<?php
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php';

$id = "";
$name = "";
$contact = "";
$email = "";
$gender = "";
$designation = "";
$department = "";
$educationalqualification = "";
$employeementtype = "";
$salary = "";
$errormessage = "";
$successmessage = "";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {


    $id = $_GET["id"];
    $sql = "SELECT * FROM employee WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);



    $name = $row["name"];
    $contact = $row["contact"];
    $email = $row["email"];
    $gender = $row["gender"];
    $designation = $row["designation"];
    $department = $row["department"];
    $educationalqualification = $row["educationalqualification"];
    $employeementtype = $row["employeementtype"];
    $salary = $row["salary"];
} else {
    $id = $_POST["emp_id"];
    $name = trim($_POST["name"]);
    $contact = trim($_POST["contact"]);
    $email = trim($_POST["email"]);
    $gender = isset($_POST["gender"]) ? trim($_POST["gender"]) : "";
    $designation = trim($_POST["designation"]);
    $department = trim($_POST["department"]);
    $educationalqualification = trim($_POST["educationalqualification"]);
    $employeementtype = isset($_POST["employeementtype"]) ? trim($_POST["employeementtype"]) : "";
    $salary = trim($_POST["salary"]);

    do {
        if (empty($id) || empty($name) || empty($contact) || empty($email) || empty($gender) || empty($designation) || empty($department) || empty($educationalqualification) || empty($employeementtype) || empty($salary)) {
            $errormessage = "All fields are required";
            break;
        }

        $sql = "UPDATE employee SET 
                    name='$name', 
                    contact='$contact', 
                    email='$email', 
                    gender='$gender',
                    designation='$designation',
                    department='$department',
                    educationalqualification='$educationalqualification',
                    employeementtype='$employeementtype',
                    salary='$salary'
                WHERE id = $id";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $errormessage = "Invalid query: " . mysqli_error($conn);
            break;
        }

        echo "
        <script>
        alert('Employee updated successfully!');
        window.location.href = 'viewemp.php';
        </script>";
        exit;
    } while (false);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">

</head>
<style>
    html,
    body {
        background-color: rgb(196, 235, 196);
    }

    .btn {
        background-color: rgb(2, 17, 31);
        color: white;
    }
</style>

<body>
    <div class="container">
        <br>
        <br>
        <?php
        if (!empty($errormessage)) {
            echo "<div class='alert alert-danger'>$errormessage</div>";
        }
        if (!empty($successmessage)) {
            echo "<div class='alert alert-success'>$successmessage</div>";
        }
        ?>

        <form method="post">
            <input type="hidden" name="emp_id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"> Name </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Conatct</label>
                <div class="col-sm-6">
                    <input type="contact" class="form-control" name="contact" value="<?php echo $contact; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"> Email </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" size="50" value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Gender</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="gender" value="<?php echo $gender; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Designation</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="designation" value="<?php echo $designation; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Department</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="department" value="<?php echo $department; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Educational Qualification</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="educationalqualification" value="<?php echo $educationalqualification; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Employeement Type</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="employeementtype" value="<?php echo $employeementtype; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Salary</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="salary" value="<?php echo $salary; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn ">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="../actions/viewemp.php" class="btn " role="button">Cancel</a>
                </div>

            </div>
    </div>
</body>

</html>