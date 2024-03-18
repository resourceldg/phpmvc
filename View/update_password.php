<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password</title>
</head>
<body>
    <h2>Update Password</h2>
    <form method="post">
        <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>">
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" id="new_password" required><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
