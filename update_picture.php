<?php
session_start();
include "config.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Fetch current profile pic
$res = $conn->query("SELECT profile_pic FROM users WHERE email_or_phone = '$user'");
$currentPic = "images/default.jpg";
if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    if (!empty($row['profile_pic'])) {
        $currentPic = $row['profile_pic'];
    }
}

// Handle upload
if (isset($_POST['update'])) {
    if ($_FILES['new_pic']['error'] === 0) {
        $imgName = time() . "_" . basename($_FILES['new_pic']['name']);
        $imgPath = "uploads/" . $imgName;

        if (move_uploaded_file($_FILES['new_pic']['tmp_name'], $imgPath)) {
            // Delete old pic if not default
            if ($currentPic !== 'images/default.jpg' && file_exists($currentPic)) {
                unlink($currentPic);
            }

            // Update DB
            $conn->query("UPDATE users SET profile_pic='$imgPath' WHERE email_or_phone='$user'");
            header("Location: welcome.php");
            exit;
        } else {
            $error = "Upload failed!";
        }
    } else {
        $error = "Please choose a valid file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Profile Picture</title>
    <style>
        body {
            font-family: Arial;
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input[type="file"], input[type="submit"] {
            display: block;
            margin: 10px 0;
        }
        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="box">
        <h3>Update Profile Picture</h3>
        <img src="<?php echo $currentPic; ?>" alt="Current Profile Pic"><br>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="new_pic" required>
            <input type="submit" name="update" value="Upload">
        </form>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <a href="welcome.php">Back to Dashboard</a>
    </div>
</body>
</html>
