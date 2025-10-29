<?php
include 'includes/session.php';
include 'includes/db.php';
include 'includes/header.php';


$sql = "SELECT *FROM admin WHERE username ='$_SESSION[admin_username]'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($rows = mysqli_fetch_assoc($result)) {
        $username = ucwords($rows["username"]);
        $gender = ucwords($rows["gender"]);
        $dob = $rows["dob"];
        $pic = $rows["pic"];
    }

    if (empty($gender)) {
        $gender = "Not defined";
    }
    if (empty($dob)) {
        $dob = "Not defined";
        $age = "Not Defined";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html,
        body {
            background-color: rgb(196, 235, 196);
        }

        .profile-card {
            width: 55%;
            max-width: 550px;
            margin: 50px auto;
        }

        .profile-card img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 15px;
        }

        card-body h4 {
            text-decoration: underline;
        }

        span {
            font-weight: bold;
        }

        .btn {
            background-color: rgb(2, 17, 31);
            color: white;
        }

        .btn:hover {
            background-color: rgba(0, 94, 111, 1);
            color: black;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="card profile-card shadow text-center">
        <div class="card-body">
            <img src="<?php if (!empty($pic)) {
                            echo $pic;
                        } else {
                            echo "images/form-user.png";
                        } ?>" alt="Profile">
            <h4 class="card-title">Admin Information</h4>
            <p class="card-text"><span>Username: </span><?php echo $username; ?></p>
            <p class="card-text"><span>Gender: </span><?php echo $gender ?> </p>
            <p class="card-text"><span>Date of Birth: </span><?php echo $dob ?> </p>
            <p class="card-text"><span>Age: </span><?php if ($dob != "Not Defined") {
                                                        $date1 = date_create($dob);
                                                        $date2 = date_create("now");
                                                        $difference = date_diff($date1, $date2);
                                                        echo $difference->format("%y Years");
                                                    } ?></p>

            <br>
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
                <a href="actions/editadmin.php" class="btn">Edit Profile</a>
                <br>
                <a href="../actions/change_password.php" class="btn ">Change Password</a>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php include 'includes/footer.php'; ?>