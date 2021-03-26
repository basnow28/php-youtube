<?php include('reg-server.php') ?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration for YT searching system</title>
</head>

<body>
    <div>
        <h2>Register</h2>
    </div>

    <form method="post" action="register.php">
        <?php include('errors.php'); ?>
        <div>
            <label>Email</label>
            <input type="email" name="email" value=<?php echo $email; ?>>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password_1">
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" name="password_2">
        </div>
        <div>
            <button type="submit" name="reg_user">Register</button>
        </div>
    </form>
</body>

</html>