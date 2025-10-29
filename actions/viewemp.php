<?php
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE INFO</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        html,
        body {
            height: 80%;
            margin: 0;
            padding: 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: rgb(196, 235, 196);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        table {
            table-layout: fixed;
            width: 100%;
        }

        .container {
            flex: 1;
            padding: 20px;
        }

        th,
        td {

            white-space: normal;
        }

        td {
            word-break: break-word;
        }


        .table-container {
            flex: 1;
            max-height: 400px;
            overflow-y: auto;
            overflow-x: auto;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        th {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }
    </style>

</head>

<body class="d-flex flex-column min-vh-100">



    <div class="container">

        <h3>
            Employee Information
        </h3>
        <br>
        <div class="table-container">
            <table class="table table-striped table-bordered">

                <thead class="table-success">
                    <tr>

                        <th>Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Educational Qualification</th>
                        <th style=" min-width:150px;">Employeement Type</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_connect_errno()) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = "SELECT *FROM employee";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        die("Invalid query: " . mysqli_error($conn));
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "
        <tr>
       
        <td>$row[name]</td>
        <td>$row[contact]</td>
        <td>$row[email]</td>
        <td>$row[gender]</td>
        <td>$row[designation]</td>
        <td>$row[department]</td>
        <td>$row[educationalqualification]</td>
        <td>$row[employeementtype]</td>
        <td>$row[salary]</td>
        <td>
        <a class='btn btn-primary btn-sm' href='updateemp.php?id=$row[id]'>Edit </a>
        <a class='btn btn-danger btn-sm' href='../actions/deleteemp.php?id=$row[id]'>Delete </a>

        </td>
        </tr>
        ";
                    }

                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>


</html>