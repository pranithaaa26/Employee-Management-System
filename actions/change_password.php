<?php
include '../includes/session.php';
include '../includes/header.php';
include '../includes/db.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>

<style>
    .container {
        width: 70%;
    }



    .card-header {
        background-color: rgb(2, 17, 31);
        padding: 10px 10px;
    }

    h3 {
        color: white;
    }



    .btn-group {
        padding: 10px;
        background-color: rgb(2, 17, 31);
        color: white;
    }
</style>
<?php
$oldpassErr = "";
$newpassErr = "";
$confirmpassErr = "";
$oldpass = "";
$newpass = "";
$confirmpass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_REQUEST["oldpass"])) {
        $oldpassErr = " <p style='color:red'>* Old Password Is required </p>";
    } else {
        $oldpass = trim($_REQUEST["oldpass"]);
    }

    if (empty($_REQUEST["newpass"])) {
        $newpassErr = " <p style='color:red'>* New Password Is required </p>";
    } else {
        $newpass = trim($_REQUEST["newpass"]);
    }

    if (empty($_REQUEST["confirmpass"])) {
        $confirmpassErr = " <p style='color:red'>* Please Confirm new Password! </p>";
    } else {
        $confirmpass = trim($_REQUEST["confirmpass"]);
    }

    if (!empty($oldpass) && !empty($newpass) && !empty($confirmpass)) {
        $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['admin_username']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($oldpass, $row['password'])) {
                if ($newpass === $confirmpass) {
                    $hashednewpass = password_hash($newpass, PASSWORD_DEFAULT);

                    $update = $conn->prepare("UPDATE admin SET password=? WHERE username=?");
                    $update->bind_param("ss", $hashednewpass, $_SESSION['admin_username']);

                    if ($update->execute()) {
                        echo "<script>
                            alert('Password changed successfully! ');
                            window.location.href = '/thirdyear/profile.php';
                        </script>";
                        exit;
                    }
                } else {
                    $confirmpassErr = "<p style='color:red'>* New & Confirm password do not match</p>";
                }
            } else {
                $oldpassErr = "<p style='color:red'>* Old Password is incorrect</p>";
            }
        }
    }
}



?>


<div class="container mt-5 ">
    <div class="card shadow-lg" style="max-width: 400px; margin: auto;">
        <div class="card-header text-center">
            <h3>Change Password </h3>
        </div>

        <div class="card-body">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Old Password : </label>
                    <input type="password" name="oldpass" class="form-control">
                    <?= $oldpassErr ?>
                </div>
                <br>
                <div class="form-group">
                    <label>New Password : </label>
                    <input type="password" name="newpass" class="form-control">
                    <?= $newpassErr ?>
                </div>
                <br>
                <div class="form-group">
                    <label>Confirm Password : </label>
                    <input type="password" name="confirmpass" class="form-control">
                    <?= $confirmpassErr ?>
                </div>

                <br>

                <div class=" d-flex justify-content-center ">
                    <div class="btn ">
                        <input type="submit" class="btn-group " value="Save Changes" name="save_changes">
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>



<?php include '../includes/footer.php'; ?>