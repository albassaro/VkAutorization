<?php

session_start();

require __DIR__. '/../db/db_config.php';

// ===============================================   CSRF ТОКЕН И Redirect   ========================================

// Генерация токена
function generateSRFToken(){
    $token = random_bytes(25);
    $_SESSION['CSRF-token'] = bin2hex($token);
    return bin2hex($token);
}

// Редирект
function redirect($path)
{
    header("location: $path");
    die();
}

// ===============================================   ФУНКЦИИ  ВАЛИДАЦИИ   ========================================

// Проверка существования сессии
function sessionErrorIsExists($fieldName):bool
{
    return isset($_SESSION['validation'][$fieldName]);
}

// Вывод аттрибуда для отображения выделения поля
function validationErrorAttribute($fieldName)
{
    return sessionErrorIsExists($fieldName) ? 'aria-invalid="true"' : '';
}

// Задаем текст ошибки для пользователя
function setErrorMessage($fieldName, $textMessage): void
{
    $_SESSION['validation'][$fieldName] = $textMessage;
}

// Выводим текст ошибки и сбрасываем сессию
function getErrorMessage($fieldName)
{
    $message = $_SESSION['validation'][$fieldName] ?? '';
    unset($_SESSION['validation'][$fieldName]);
    return $message;
}

// Сохраняем введенное в input-ы значения
function setInputValue($key, $value)
{
    $_SESSION['memoryInput'][$key] = $value;
}

// Получаем сохраненное значение
function getInputValue($key)
{
    $value = $_SESSION['memoryInput'][$key] ?? '';
    unset($_SESSION['memoryInput'][$key]);
    return $value;
}
// Редирект на нужную страницу в случае ошибкок при заполнении форм
function redirectWithError($login,$password,$location)
{
    if (!empty($_SESSION['validation'])) {
        setInputValue('login', $login);
        setInputValue('password', $password);
        redirect('/'.$location);
    }
}

// ===============================================   ФУНКЦИИ  ДЛЯ  РАБОТЫ  С БД   ========================================

// Функция подключения БД
function connectDB():PDO
{
    try {
        return new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USERNAME,DB_PASSWORD);
    } catch (\PDOException $error) {
        echo "Ошибка подключения к БД:  " . $error->getMessage();
        die();
    }
    
}
// Функция поиска польз-ля в БД по логину
function searchUserInDB($login)
{
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_login = :login");
    $stmt->execute(['login' => $login]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

// Функция получения текущего пользователя по id из БД
function currentUser()
{
    $pdo = connectDB();

    if (!isset($_SESSION['user']['id'])){
        return false;
    }

    $userId = $_SESSION['user']['id'] ?? null;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :id");
    $stmt->execute(['id' => $userId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}


// Функция для проверки авторизации пользователя через логин-пароль и через ВК
function checkAuth():void
{
    if (!isset($_SESSION['vk-data'])){
        if(!isset($_SESSION['user']['id'])){
            redirect('/authorise.php');
        }       
    }
}

// Функция чтобы авторизированный пользователь не имел повторного доступа к регистрации и авторизации 
function checkGuest():void
{
    if (isset($_SESSION['user']['id']) or isset($_SESSION['vk-data'])){
        redirect('/content.php');
    }
}

// Функция выхода из аккаунта
function logOut():void
{
    unset($_SESSION['user']['id']);
    unset($_SESSION['access-token-vk']);
    unset($_SESSION['vk-data']);
    redirect('/authorise.php');
}
































