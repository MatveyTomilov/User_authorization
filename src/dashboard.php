<?php
// dashboard.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получение имени пользователя из сессии для персонализации
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email']); // Добавляем получение email
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Панель управления</title>
    <link href="css/styles.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Навигационная панель -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="font-bold text-xl text-blue-600">Моё Приложение</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="logout.php" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                        Выйти
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <!-- Карточка приветствия -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Добро пожаловать, <?php echo $username; ?>!</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Это ваша панель управления. Здесь вы можете управлять своим аккаунтом и настраивать параметры.</p>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <!-- Пример секции информации -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Ваше имя</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo $username; ?></dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"><?php echo $email; ?></dd>
                        </div>
                        <!-- Добавьте дополнительные секции по мере необходимости -->
                    </dl>
                </div>
            </div>

            <!-- Дополнительные блоки или функциональность -->
            <div class="mt-10">
                <h4 class="text-lg font-semibold text-gray-700 mb-4">Последние действия</h4>
                <!-- Пример списка последних действий пользователя -->
                <ul class="bg-white shadow overflow-hidden sm:rounded-md">
                    <li class="border-t border-gray-200">
                        <a href="#" class="block hover:bg-gray-50">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-blue-600 truncate">Создание нового аккаунта</p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Успешно
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-8 4h8m-8 4h8m-8 4h8m-8 4h8" />
                                            </svg>
                                            Зарегистрировано с IP: 192.168.1.10
                                        </p>
                                    </div>
                                    <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 8c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z" />
                                        </svg>
                                        Последний вход: 12 Сентября 2024, 14:35
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <!-- Добавьте дополнительные элементы списка по мере необходимости -->
                </ul>
            </div>
        </div>
    </main>

    <!-- Футер (опционально) -->
    <footer class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">&copy; 2024 Моё Приложение. Все права защищены.</p>
        </div>
    </footer>

</body>

</html>