<?php
session_start();
include "config.php";
include "functions.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        .message {
            color: red;
            margin-top: 10px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="user" placeholder="Email or Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>

        <p style="margin-top: 15px; text-align: center;">
            Not registered? <a href="register.php">Click here</a>
        </p>

        <?php
        if (isset($_POST['login'])) {
    $input = trim($_POST['user']);
    $pass = $_POST['password'];

    $user = findUser($conn, $input);

    if ($user && $pass === $user['password']) {
        $_SESSION['user'] = $input;
        header("Location: welcome.php");
        exit;
    } else {
        echo "<div class='message'>Invalid email/phone or password.</div>";
    }
}

        ?>
    </div>
</body>
</html>
