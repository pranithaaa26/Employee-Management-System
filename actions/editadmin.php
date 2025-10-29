<?php
include '../includes/session.php';
include '../includes/db.php';

if (isset($_POST['update'])) {
    $newUsername = $_POST['username'];
    $newDob      = $_POST['dob'];
    $newGender   = $_POST['gender'];

    // use correct session variable from login.php
    $sessionUsername = $_SESSION['admin_username'];

    // update profile based on current username
    $sql = "UPDATE admin 
            SET username='$newUsername', dob='$newDob', gender='$newGender' 
            WHERE username='$sessionUsername'";

    if (mysqli_query($conn, $sql)) {
        // keep session in sync with new username
        $_SESSION['admin_username'] = $newUsername;
        echo "<script>
                alert('Profile updated successfully!');
                window.location.href = '../profile.php';
              </script>";
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

include '../includes/header.php';
?>
<style>
    .container {
        width: 120%;
        margin: 75px auto;
        justify-content: center;
        align-items: center;
        min-height: 50vh;
        margin-left: 250px;
    }

    .card.login-form {
        border: none;
        border-radius: 15px;

    }

    .card-body h4 {
        font-weight: 400;
        color: #333;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-weight: bold;
    }

    label {
        font-weight: 600;
        color: #444;
        display: block;
    }

    .btn {
        background-color: rgb(2, 17, 31);
        color: white;
    }

    .btn:hover {
        border: none;
        background-color: rgba(0, 94, 111, 1);
        color: black;
        font-weight: bold;
    }

    input {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<div class="login-form-bg ">
    <div class="container ">
        <div class="form-input-content">
            <div class="card login-form">
                <div class="card-body shadow">
                    <h4 class="text-center">Edit Your Profile</h4>
                    <br>
                    <form method="POST" action="editadmin.php">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" class="form-control" name="username" required><br><br>
                        </div>
                        <div class="form-group">
                            <label>Date of Birth:</label>
                            <input type="date" class="form-control" name="dob" required><br><br>
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender:</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select><br><br>
                        </div>

                        <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group">
                                <input type="submit" value="Save Changes" class="btn  w-20 " name="update">
                            </div>
                            <div class="input-group">
                                <a href="../profile.php" class="btn  w-20">Close</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>

<?php include '../includes/footer.php'; ?>