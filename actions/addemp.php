<?php
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php';
?>

<?php

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        if (empty($name) ||  empty($contact) || empty($email) || empty($gender) || empty($designation) || empty($department) || empty($educationalqualification) || empty("$employeementtype") || empty("$salary")) {
            $errormessage = "All the Feilds are Required";
            break;
        }

        $sql = "INSERT INTO employee(`name`, `contact`, `email`, `gender`, `designation`, `department`, `educationalqualification`, `employeementtype`, `salary`) 
        VALUES('$name', '$contact', '$email', '$gender', '$designation', '$department', '$educationalqualification', '$employeementtype', '$salary')";


        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $errormessage = "inavlid query:" . mysqli_error($conn);
            break;
        }


        $name = "";
        $contact = "";
        $email = "";
        $gender = "";
        $designation = "";
        $department = "";
        $educationalqualification = "";
        $employeementtype = "";
        $salary = "";
        if ($result) {
            echo "
            <script>
            alert('Employee added successfully!');
            window.location.href = 'viewemp.php' ; 
            </script>";
            exit();
        }
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


    <style>
        label.col-form-label {
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
        }

        .btn {
            background-color: rgb(2, 17, 31);
        }

        html,
        body {
            height: 100vh;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: rgb(196, 235, 196);

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="m-3"></div>
        <div class="text-center  fw-bold">
            <h2>Add New Employee</h2>
        </div>
        <div class="p-2"></div>
        <?php
        if (!empty($errormessage)) {
            echo " <div class='alert alert-danger alert-dismissible fade show' role='alert'>$errormessage
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button> </div>";
        }
        if (!empty($successmessage)) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>$successmessage
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        ?>

        <form method="post">
            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label"> Name </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required>
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label"> CONTACT </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contact" maxlength="10" pattern="\d{10}" title="Please enter digits only(10)" value="<?php echo $contact; ?>" required>
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label">GENDER</label>
                <div class="col-sm-6">
                    <select class="form-select" name="gender" required>
                        <option value="" disabled selected>Select gender</option>
                        <option value="Male" <?php if ($gender == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($gender == 'Female') echo 'selected'; ?>>Female</option>
                        <option value="Other" <?php if ($gender == 'Other') echo 'selected'; ?>>Other</option>
                    </select>
                </div>
            </div>


            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label"> DESIGNATION </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="designation" size="50" value="<?php echo $designation; ?>">
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label">DEPARTMENT</label>
                <div class="col-sm-6">
                    <select class="form-select" name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <?php
                        // Fetch all departments from department table
                        $deptQuery = "SELECT id, dept_name FROM department";
                        $deptResult = mysqli_query($conn, $deptQuery);

                        if ($deptResult && mysqli_num_rows($deptResult) > 0) {
                            while ($row = mysqli_fetch_assoc($deptResult)) {
                                $selected = ($department == $row['dept_name']) ? "selected" : "";
                                echo "<option value='" . htmlspecialchars($row['dept_name']) . "' $selected>"
                                    . htmlspecialchars($row['dept_name']) . "</option>";
                            }
                        } else {
                            echo "<option disabled>No departments available</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label">EDUCATIONAL QUALIFICATION</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="educationalqualification" value="<?php echo $educationalqualification; ?>" required>
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label">EMPLOYEEMENT TYPE</label>
                <div class="col-sm-6">
                    <select class="form-select" name="employeementtype" required>
                        <option value="" disabled selected>Select Employeement Type</option>
                        <option value="Teaching" <?php if ($employeementtype == 'Teaching') echo 'selected'; ?>>Teaching Staff</option>
                        <option value="Non-Teaching" <?php if ($employeementtype == 'nonteaching') echo 'selected'; ?>>Non-Teaching Staff</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3" id="text">
                <label class="col-sm-3 col-form-label">SALARY</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="salary" value="<?php echo $salary; ?>" required>
                </div>
            </div>

            <div class="row mb-3" id="btn">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

                <div class="col-sm-3 d-grid" id="btn">
                    <a href="../actions/viewemp.php" class="btn btn-primary" role="button">Cancel</a>
                </div>

            </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>


<?php include '../includes/footer.php'; ?>