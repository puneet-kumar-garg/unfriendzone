<?php
session_start();
include "config.php"; // Add this line to connect to the database

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

// Fetch profile pic from DB
$query = $conn->query("SELECT profile_pic FROM users WHERE email_or_phone = '$user'");
$pic = "images/default.jpg"; // default image path

if ($query && $query->num_rows > 0) {
    $row = $query->fetch_assoc();
    if (!empty($row['profile_pic'])) {
        $pic = $row['profile_pic'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 200px;
            height: 100vh;
            background-color: #eee;
            padding: 20px;
            float: left;
        }
        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            margin: 10px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
        }
        .sidebar ul li a.logout-link:hover {
            color: red;
            text-decoration: underline;
        }
        .main-content {
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
<img src="<?php echo $pic; ?>" alt="Profile Pic">
<p><a href="update_picture.php">Update Profile Pic</a></p>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Friends</a></li>
        <li><a href="#">Message</a></li>
        <li><a href="#">Notification</a></li>
        <li><a href="#">Scrap</a></li>
        <li><a href="#">Post</a></li>
        <li><a href="#">Setting</a></li>
        <li><a href="#">Game</a></li>
        <li><a href="#">Group Chat</a></li>
        <li><a href="logout.php" class="logout-link">Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
    <p>This is your dashboard. Select an option from the sidebar.</p>
</div>

</body>
</html>
