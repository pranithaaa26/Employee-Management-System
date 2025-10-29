<?php
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php';
?>
<?php
if (isset($_POST['submit'])) {
    $deptname = trim($_POST['deptname']);
    if (!empty($deptname)) {
        $stmt = $conn->prepare("INSERT INTO department (dept_name) VALUES (?)");
        $stmt->bind_param("s", $deptname);
        $stmt->execute();
        $stmt->close();
    }
}

// Delete department (using prepared statement)
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM department WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department</title>
</head>
<style>
    body {
        justify-content: center;
    }

    h4 {
        font-family: 'Times New Roman', Times, serif;
        font-weight: bold;
        margin-top: 10px;
        display: block;
        margin-right: 10px;
        margin-left: 5px;
    }

    .dept {
        display: flex;
        flex-direction: column;
        /*align-items: flex-start;*/
        margin-left: 10px;
        margin-top: 20px;
        align-items: center;
    }

    .dept form {
        display: flex;
        align-items: center;
        /* Vertically centers input and button with label */
        gap: 10px;
        /* Provides space between elements */
        margin-bottom: 10px;
    }


    .department {
        margin-top: 0;
        /* Remove any extra top margin */
        width: 100%;
    }

    .table-container {
        width: 100%;
        margin-top: 0;
        margin-left: 0;
        max-height: 450px;
        overflow-y: auto;
    }

    .table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
    }

    input {
        background-color: rgba(232, 244, 232, 1);
    }

    .submitbtn {
        background-color: rgb(2, 17, 31);
        color: white;
        margin-left: 20px;
        padding: 5px 8px;
        border-radius: 10px;
        margin-top: 2px;
    }

    .deletebtn {
        background-color: rgba(243, 42, 42, 1);
        color: white;
        padding: 5px 8px;
        border-radius: 5px;
        text-decoration: none;
        align-items: center;
        justify-content: center;
    }

    tbody {
        align-items: center;
        justify-content: center;
    }

    .deletebtn:hover {
        background-color: darkred;
    }
</style>

<body>
    <div class="dept">
        <form method="POST" action="">
            <h4>Enter the Department Name:</h4>
            <input type="text" name="deptname" required>
            <button type="submit" name="submit" class="submitbtn">Submit</button>
        </form>

        <br>

        <div class="department">
            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Sr.no</th>
                            <th>Department Name</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM department ORDER BY id ASC";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                <td>" . $i++ . "</td>
                                <td>" . htmlspecialchars($row['dept_name']) . "</td>
                                <td><a class='deletebtn' href='?delete=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this department?');\">Delete</a></td>
                              </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
<?php include '../includes/footer.php' ?>