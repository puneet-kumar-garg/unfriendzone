<?php 
include "config.php"; 
include "functions.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
        input[type="text"], input[type="password"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        .message {
            margin-top: 10px;
            color: red;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Register</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="email_phone" placeholder="Email or Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="file" name="profile_pic" accept="image/*" required>
            <input type="submit" name="register" value="Register">
        </form>
        <p style="text-align:center;">Already have an account? <a href="login.php">Login here</a></p>

        <?php
        if (isset($_POST['register'])) {
            $user = trim($_POST['email_phone']);
            $pass = $_POST['password'];

            if (!validatePassword($pass)) {
                echo "<div class='message'>Password must be 8+ characters with 1 capital and 1 number.</div>";
            } else {
                // Upload image
                $imageName = $_FILES['profile_pic']['name'];
                $imageTmp = $_FILES['profile_pic']['tmp_name'];
                $targetDir = "uploads/";
                $imagePath = $targetDir . uniqid() . "_" . basename($imageName);

                if (move_uploaded_file($imageTmp, $imagePath)) {
                    // Save user in DB
                    $stmt = $conn->prepare("INSERT INTO users (email_or_phone, password, profile_pic) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $user, $pass, $imagePath);
                    if ($stmt->execute()) {
                        echo "<div class='message' style='color:green;'>Registration successful! <a href='login.php'>Login now</a></div>";
                    } else {
                        echo "<div class='message'>Error: User already exists or could not save.</div>";
                        unlink($imagePath); // delete uploaded image if DB insert fails
                    }
                } else {
                    echo "<div class='message'>Failed to upload profile picture.</div>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
