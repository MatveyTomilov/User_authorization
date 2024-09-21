<?php
session_start();
require_once 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username)) {
        $errors[] = "Имя пользователя обязательно.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Действительный email обязателен.";
    }
    if (empty($password)) {
        $errors[] = "Пароль обязателен.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Пароли не совпадают.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Имя пользователя или email уже существует.";
        }
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $hashed_password])) {
            $_SESSION['success'] = "Регистрация успешна. Пожалуйста, войдите.";
            header("Location: login.php");
            exit;
        } else {
            $errors[] = "Ошибка при регистрации. Попробуйте позже.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
</head>

<body>
    <h2>Регистрация</h2>
    <?php
    if (!empty($errors)) {
        echo '<ul style="color:red;">';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }
    ?>
    <form action="register.php" method="POST">
        <label>Имя пользователя:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Пароль:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Подтвердите пароль:</label><br>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Зарегистрироваться</button>
    </form>
    <p>Уже есть аккаунт? <a href="login.php">Войти</a></p>
</body>

</html>