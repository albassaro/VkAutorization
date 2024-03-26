<?php

require __DIR__ . '/vk_config.php';

$params = array(
		'client_id'     => $clientId,
		'client_secret' => $clientSecret,
		'code'          => $_GET['code'],
		'redirect_uri'  => $redirectUri
	);
 
	if (!$content = @file_get_contents('https://oauth.vk.com/access_token?' . http_build_query($params))) {
		$error = error_get_last();
		throw new Exception('HTTP request failed. Error: ' . $error['message']);
	}
 
	$response = json_decode($content);

	
	// Если при получении токена произошла ошибка
	if (isset($response->error)) {
		throw new Exception('При получении токена произошла ошибка. Error: ' . $response->error . '. Error description: ' . $response->error_description);
	}
 	
	//выполняем код, если все прошло хорошо
	$token = $response->access_token; // Токен
	$expiresIn = $response->expires_in; // Время жизни токена
	$userId = $response->user_id;
	//https://dev.vk.com/method/users.get
	$data = json_decode(file_get_contents('https://api.vk.com/method/users.get?access_token='.$token.'&user_ids='.$userId.'&fields=first_name,last_name,photo_200_orig&name_case=nom&v=5.199'), true);
 
	if (isset($data->error)){
		throw new Exception('При получении данных произошла ошибка. Error: ' . $data->error . '. Error description: ' . $data->error_description);
	}

	// Сохраняем токен в сессии
	$_SESSION['access-token-vk'] = $token;