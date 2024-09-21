<?php
session_start();
require_once 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username)) {
        $errors[] = "Имя пользователя обязательно.";
    }
    if (empty($password)) {
        $errors[] = "Пароль обязателен.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Неверное имя пользователя или пароль.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Вход</title>
</head>

<body>
    <h2>Вход</h2>
    <?php
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green;">' . $_SESSION['success'] . '</p>';
        unset($_SESSION['success']);
    }
    if (!empty($errors)) {
        echo '<ul style="color:red;">';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
    ?>
    <form action="login.php" method="POST">
        <label>Имя пользователя:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Войти</button>
    </form>
    <p>Нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
</body>

</html>