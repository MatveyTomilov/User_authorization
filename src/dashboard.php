<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
</head>

<body>
    <h2>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p><a href="logout.php">Выйти</a></p>
    <p>Здесь вы можете добавить содержимое вашей панели управления.</p>
</body>

</html>