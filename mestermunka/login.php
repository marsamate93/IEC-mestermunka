<?php
session_start();

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    
    $users = [
        'admin' => 'admin12345',
        'user' => 'user12345' 
    ];

    if (isset($users[$username]) && $password === $users[$username]) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = $username === 'admin' ? 'admin' : 'user';
        header("Location: index.php");
        exit();

    } else {
        $error = "Hibás felhasználónév vagy jelszó!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Traktoros munkák</title>
    <link rel="stylesheet" href="res/style2.css">
</head>
<body>
    <div class="login-container">
        <h2>Bejelentkezés</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Felhasználónév:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Jelszó:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <input type="submit" name="login" value="Bejelentkezés">
            </div>
        </form>
    </div>
</body>
</html>