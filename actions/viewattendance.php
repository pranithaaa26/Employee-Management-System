<?php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php';
?>
<?php
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');


$search_db = mysqli_real_escape_string($conn, $search);
if (!empty($search) && !empty($_GET['date'])) {                //both 
    $sql = "SELECT e.id, e.name, a.date AS att_date, a.status, a.hours
            FROM employee e
            LEFT JOIN attendance a 
            ON e.id = a.id AND a.date = '$date'
            WHERE e.name LIKE '%$search%'
            ORDER BY a.date DESC";
} elseif (!empty($search)) {                                 //seaarch
    $sql = "SELECT e.id, e.name, a.date AS att_date, a.status, a.hours
            FROM employee e
            LEFT JOIN attendance a 
            ON e.id = a.id  
            WHERE e.name LIKE '%$search%'
            ORDER BY a.date DESC";
} else {                                               //adte
    $sql = "SELECT e.id, e.name, a.date AS att_date, a.status, a.hours
            FROM employee e
            LEFT JOIN attendance a 
            ON e.id = a.id AND a.date = '$date'";
}
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
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
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        background-color: rgb(196, 235, 196);

    }

    .container {
        flex: 1;
        max-width: 95%;
        margin: 0 auto;
        padding: 20px;
        height: 500px;
    }

    .employee {
        width: 90%;
        padding: 10px;
        border-radius: 8px;
        max-height: 400px;
        margin-bottom: 40px;
        padding-bottom: 40px;
    }

    table {
        width: 100%;
        font-size: 16px;

        padding-bottom: 50px;
    }

    .table-container {
        max-height: 400px;
        overflow-y: auto;
        width: 100%;
    }

    .employee table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    th,
    td {
        border: 1px solid black;
        padding: 14px;
        text-align: center;
    }

    label {
        font-weight: bold;
    }

    .view {
        background-color: rgb(2, 17, 31);

        color: white;
        cursor: pointer;
        font-size: 15px;
        padding: 5px 5px;
        border-radius: 8px;
        margin: 20px;
    }
</style>

<body>
    <div class="container">

        <div class="date">
            <form method="GET" action="">
                <label for="date ">Select Date:</label>
                <input type="date" name="date" id="date">

                <div class="d-flex align-items-center gap-2 mt-2">
                    <label for="search" class="form-label fw-bold">Search Employee:</label>
                    <input type="text" name="search" id="search" value="<?php echo $search; ?>" placeholder="Enter name..." class="form-control" style="width: 200px;border: 1px solid black; " ;>
                    <button type="submit" class="view">View</button>
                </div>

            </form>
        </div>
        <br>
        <div class="employee">
            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Employee Name </th>
                            <th> Status</th>
                            <th> No. of hours worked</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {

                            $status = $row['status'] ? ucfirst($row['status']) : "Not Marked";
                            $hours = isset($row['hours']) ? $row['hours'] : "-";

                        ?>
                            <tr>
                                <td><?php echo $row['att_date'] ?: "-"; ?></td>
                                <td><?php echo $row['name']; ?> </td>
                                <td><?php echo $status; ?> </td>
                                <td><?php echo $hours; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../includes/footer.php'; ?>