<?php 
$databaseConnection = mysqli_connect("localhost", "root", "MyNewPass", "largesocial");

// Storing errors in an array
$errors = [];
session_start();


if (mysqli_connect_error()) {
    exit("Database connection failed!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signUpClicked'])) {
    $nickname = mysqli_real_escape_string($databaseConnection, $_POST['nickname']);
    $password = mysqli_real_escape_string($databaseConnection, $_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nickname, hashedPassword) VALUES ('$nickname', '$hashedPassword')";

    $userInsertedSuccessful = mysqli_query($databaseConnection, $sql);

    if ($userInsertedSuccessful) {
        // echo("User Inserted Successful");  
        header("Location: login.php");
        exit();
    } else {
        echo(mysqli_error($databaseConnection));

        if ($databaseConnection) {
            mysqli_close($databaseConnection);
        }
        exit();
    }
}
?>
<h3>Sign up</h3>
<form action="signup.php" method="post">
    <input type="text" name="nickname" placeholder="Nickname">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Join" name="signUpClicked">
</form>
