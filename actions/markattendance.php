<?php
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $attendance = $_POST['status'];
    if (!empty($date) && !empty($attendance)) {
        foreach ($attendance as $id => $status) {
            $hours = isset($_POST['hours'][$id]) ? $_POST['hours'][$id] : null;
            if ($status == "present") {
                $hours = !empty($hours) ? floatval($hours) : 0;
            } else {
                $hours = 0;
            }
            $check = "SELECT e.name 
            FROM attendance a
            JOIN employee e ON a.id = e.id
            WHERE a.id='$id' AND a.date='$date'";

            $resultcheck = mysqli_query($conn, $check);

            if (!$resultcheck) {
                die("Query Failed: " . mysqli_error($conn));
            }
            if (mysqli_num_rows($resultcheck) > 0) {
                $row = mysqli_fetch_assoc($resultcheck);
                $empname = $row['name'];
                echo "<script> alert ('Attendance already exists for $empname on $date');</script>  ";
            } else {
                $insert = "INSERT INTO attendance (id, date, status,hours) VALUES ('$id', '$date', '$status' , '$hours')";
                mysqli_query($conn, $insert);
            }
        }
        echo "<script> alert('Attendance submitted successfully');</script>";
    } else {
        echo "<script>alert('Please select a date and mark attendance.');</script>";
    }
}
?>
<?php
$sql = "SELECT id, name from employee";
$result = mysqli_query($conn, $sql);
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
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgb(196, 235, 196);
        /* overflow: hidden;*/
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .container {
        height: 500px;
    }

    .employee {

        padding: 25px;
        border-radius: 1px;
        max-height: 400px;
        margin-bottom: 10px;
        padding-bottom: 40px;
    }

    table {
        width: 100%;

    }

    .table-container {
        max-height: 320px;
        overflow-y: auto;

    }

    .employee table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    th,
    td {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
    }

    label {
        font-weight: bold;
    }

    .status {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 10px;

    }

    .status button,
    .submit {

        border-radius: 6px;
        font-weight: bold;

    }

    button {
        background-color: rgb(2, 17, 31);
        color: white;
        cursor: pointer;
        text-align: center;
        padding: 10px 18px;
        border-radius: 6px;
        font-size: 14px;
        margin-top: -30px;

    }

    button:hover {
        background-color: #0d6efd;
        color: black;
        border: none;
    }

    .submit {
        display: flex;
        margin: auto auto;
        justify-content: center;

    }

    header,
    footer {
        flex-shrink: 0;
    }
</style>


<body>
    <div class="container">
        <h2>Mark Attendance</h2>
        <form method="POST">
            <div class="date">
                <label for="date ">Select Date:</label>
                <input type="date" name="date" id="date" required>
            </div>
            <div class="employee">
                <div class="table-container">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Employee Name </th>
                                <th> Status</th>
                                <th>Enter Hours</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><?php echo $row['name']; ?> </td>
                                    <td>
                                        <input type="radio" name="status[<?php echo $row['id']; ?>]" value="present" onchange="enterhours(this, <?php echo $row['id']; ?>)"> Present
                                        <input type="radio" name="status[<?php echo $row['id']; ?>]" value="absent" onchange="enterhours(this, <?php echo $row['id']; ?>)"> Absent
                                    </td>
                                    <td>
                                        <input type="text" name="hours[<?php echo $row['id']; ?>]" id="hours_<?php echo $row['id']; ?>" pattern="^\d+(\.\d{1,2})?$" placeholder="Hours" style="width: 80px;">
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="status">
                <button type="button" onclick="markAll('present')">Mark all Present </button>
                <button type="button" onclick="markAll('absent')">Mark all Absent </button>

            </div>
            <br>
            <button type="submit" class="submit">Submit Attendance</button>
        </form>
    </div>

    <script>
        function markAll(status) {
            const check = document.querySelectorAll('tr');
            check.forEach(row => {
                const radios = row.querySelectorAll('input[type="radio"]');

                radios.forEach(radio => {

                    if (radio.value === status) {
                        radio.checked = true;
                        const id = radio.name.match(/\d+/)[0];
                        enterhours(radio, id);
                    }
                });
            });
        }

        function enterhours(radio, id) {
            const hours = document.getElementById("hours_" + id);
            if (radio.value == "present") {
                hours.style.display = "inline-block";
                hours.disabled = false;
                hours.required = true;
            } else {
                hours.style.display = "none";
                hours.value = "";
                hours.disabled = true;
                hours.required = false;
            }
        }
    </script>
</body>

</html>
<?php include '../includes/footer.php'; ?>