<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Management System</title>
</head>

<body>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      height: 100%;
      width: 100%;
      overflow: hidden;
    }

    .welcome-page {
      background-image: url("images/bg.jpg");
      background-size: 100% 100%;
      background-position: center;
      background-repeat: no-repeat;
      width: 100vw;
      height: 100vh;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      color: white;
    }

    .content-box {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 60px;
      border-radius: 12px;
    }

    h6 {
      font-family: 'Times New Roman', Times, serif;
    }

    h1 {
      font-size: 32px;
      margin-bottom: 10px;
    }


    .login-btn {
      padding: 12px 25px;
      background-color: rgb(79, 237, 179);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }

    .login-btn:hover {
      background-color: rgb(5, 136, 93);
    }
  </style>
  <div class="welcome-page">
    <div class="content-box">
      <h1>Welcome to Employee Management System</h1>
      <br>

      <br>
      <a href="login.php" class="login-btn">Go to Login</a>
      <br>

    </div>
  </div>


  <?php if (isset($_GET['logout'])): ?>
    <script>
      alert("logout successfull");
    </script>
  <?php endif ?>
</body>

</html>