<?php

require __DIR__ . '/../config/functions.php';

// Проверка что доступ к этому файлу произошел по методу post после отправки формы
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
    // Получение данных с формы 
    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;
    $CSRF = $_POST['token'] ?? null;

    // Валидация полей формы
    if (empty($login)) {
        setErrorMessage('login','Ошибка. Пустое поле с логином');
    }
    if (empty($password)) {
        setErrorMessage('password', 'Ошибка. Пустое поле с паролем');
    }

    // Редирект на страницу формы если есть ошибки
    redirectWithError($login,$password,'authorise.php');

    // Начинаем проверку логина и пароля в БД
    if ($CSRF == $_SESSION['CSRF-token']) {

        $user = searchUserInDB($login);

        if (!$user){
            setErrorMessage('login',"Ошибка. Пользователь с таким логином не зарегистрирован");
            // Редирект на страницу формы если есть ошибки
            redirectWithError($login,$password,'authorise.php');
        }

        if(!password_verify($password , $user['user_password'])){
            setErrorMessage('password', "Ошибка. Неверный пароль");
            // Редирект на страницу формы если есть ошибки
            redirectWithError($login,$password,'authorise.php');
        }
        
        // Если ошибок нет то записываем id пользователя в сессию и пускаем на страницу
        $_SESSION['user']['id'] = $user['user_id'];
        redirect('/content.php');
    }
}else {
    redirect('/authorise.php');
}


