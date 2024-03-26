<?php

require __DIR__ . '/../config/functions.php';

// Проверка что доступ к этому файлу произошел по методу post после отправки формы
if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Получение данных с формы 
    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;

    // Соединение с БД
    $pdo = connectDB();

    // Поиск введенного логина в БД для проверки
    $user = searchUserInDB($login);

    // Валидация полей формы
    if(empty($login)){
        setErrorMessage('login', 'Ошибка. Пустое поле с логином');
    }
    if(empty($password)){
        setErrorMessage('password', 'Ошибка. Пустое поле с паролем');
    }
    // Проверка что пользователь уже зарегистрирован
    if(!empty($user)){
        setErrorMessage('login', 'Ошибка. Пользователь с таким логином уже зарегистрирован');
    }

    // Редирект на страницу формы регистрации если есть ошибки
    redirectWithError($login,$password,'register.php');

    // Если ошибок нет, записываем пользователя в БД
    $query = "INSERT INTO users (user_login, user_password) VALUES (:login, :password)";

    $params = [
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ];

    $stmt = $pdo ->prepare($query);

    try {
        $stmt->execute($params);

        // Заново ищем пользователя чтобы записать его в сессию
        $user = searchUserInDB($login);
        
        // Если ошибок нет то записываем id пользователя в сессию и пускаем на страницу
        $_SESSION['user']['id'] = $user['user_id'];
        redirect('/content.php');
    } catch (\Exception $error) {
        die($error->getMessage());
    }

}else {
    redirect('/register.php');
}




















