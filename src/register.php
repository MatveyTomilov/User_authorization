<?php
// register.php
session_start();
require_once 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и очистка данных
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Валидация
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

    // Проверка уникальности пользователя
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $errors[] = "Имя пользователя или email уже существует.";
        }
    }

    // Регистрация пользователя
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
    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Регистрация</h2>
        <?php
        if (!empty($errors)) {
            echo '<ul class="text-red-500 mb-4">';
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo '</ul>';
        }
        ?>
        <form action="register.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Имя пользователя:</label>
                <input type="text" name="username" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email:</label>
                <input type="email" name="email" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Пароль:</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700">Подтвердите пароль:</label>
                <input type="password" name="confirm_password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Зарегистрироваться</button>
        </form>
        <p class="mt-4 text-center">Уже есть аккаунт? <a href="login.php" class="text-blue-500 hover:underline">Войти</a></p>
    </div>
</body>

</html>