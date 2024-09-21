<?php
// login.php
session_start();
require_once 'db.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и очистка данных
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Валидация
    if (empty($username)) {
        $errors[] = "Имя пользователя обязательно.";
    }
    if (empty($password)) {
        $errors[] = "Пароль обязателен.";
    }

    // Аутентификация
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Успешный вход
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email']; // Добавляем email в сессию
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
    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Вход</h2>
        <?php
        if (isset($_SESSION['success'])) {
            echo '<p class="text-green-500 mb-4">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        if (!empty($errors)) {
            echo '<ul class="text-red-500 mb-4">';
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo '</ul>';
        }
        ?>
        <form action="login.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Имя пользователя:</label>
                <input type="text" name="username" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700">Пароль:</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Войти</button>
        </form>
        <p class="mt-4 text-center">Нет аккаунта? <a href="register.php" class="text-blue-500 hover:underline">Зарегистрируйтесь</a></p>
    </div>
</body>

</html>