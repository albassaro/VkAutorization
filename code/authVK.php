<?php 
require __DIR__ . '/application/config/functions.php';
require __DIR__ . '/application/config/vkToken_config.php';

foreach ($data as $key){
    foreach($key as $value){
        $_SESSION['vk-data'] = $value;
    }
}

redirect('/content.php');
