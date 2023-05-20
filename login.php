<?php 
$databaseConnection = mysqli_connect("localhost", "root", "MyNewPass", "largesocial");

// Storing errors in an array
$errors = [];
session_start();

if (mysqli_connect_error()) {
    exit("Database connection failed!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signInClicked'])) {
    $nickname = mysqli_real_escape_string($databaseConnection, $_POST['nickname']);
    $password = mysqli_real_escape_string($databaseConnection, $_POST['password']);

    // Find user by their username
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE nickname='" . $nickname . "'";

    $user = mysqli_query($databaseConnection, $sql);
    $user = mysqli_fetch_assoc($user);

    if ($user) {
        // Verify their password
        if (password_verify($password, $user['hashedPassword'])) {
            // Login user
            session_regenerate_id(); // Security feature fixation
            $_SESSION['userId'] = $user['id'];
            $_SESSION['nickname'] = $user['nickname'];
            header("Location: index.php");
            exit();
        } else {
            // Passwords don't match
            $errors[] = "Wrong username or password.";
        }
    } else {
        $errors[] = "Invalid username or password.";
    }
}
?>

<span class="error">
    <?php 
    foreach ($errors as $currentError) {
        echo($currentError);
    }
    ?>
</span>

<form action="login.php" method="post">
    <input type="text" name="nickname" placeholder="Nickname">
    <input type="password" name="password" placeholder="Password">
    <input type="submit" value="Sign in" name="signInClicked">
</form>
