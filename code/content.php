<?php 
require __DIR__ . '/application/config/functions.php';

// Проверка вошел ли пользователь
checkAuth();

// Получение данных текущего пользователя
$currentUser = currentUser();

?>

<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/application/views/template_head.php'; ?>

<body>
    <?php include __DIR__ . '/application/views/template_nav.php'; ?>
    <main>
        <div class="content">
            <div class="content_text">
                <?php if ($currentUser) : ?>
                    <h2>Здравствуйте "<?php echo $currentUser['user_login'] ?>"! Ваш уровень доступа - "<?php echo $currentUser['role']?>"</h2>
                <?php elseif(isset($_SESSION['vk-data'])) :?>
                    <h2>Здравствуйте "<?php echo $_SESSION['vk-data']['first_name'] . " " . $_SESSION['vk-data']['last_name'] ?>"! Ваш уровень доступа - "vk"</h2>
                <?php endif; ?>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus magnam earum minus officia
                    doloribus ut sapiente ex commodi debitis molestias, sint quae ad, rerum illum inventore.
                    Quos rerum labore maiores.
                    
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Harum velit alias veniam sint distinctio autem blanditiis 
                    tenetur odit repudiandae neque repellendus, rem, optio obcaecati quasi necessitatibus facilis! Explicabo, delectus quasi.
                </p>
            </div>
            
            <?php if (isset($_SESSION['vk-data']) or $currentUser['role'] = 'vk') : ?>
                <div class="content_img">
                    <img width="920px" src="/assets/images/breathtaking-shot-beautiful-stones-turquoise-water-lake-hills-background.jpg" alt="Фото">
                    <a href="https://ru.freepik.com/free-photo/breathtaking-shot-of-beautiful-stones-under-turquoise-water-of-a-lake-and-hills-in-the-background_10111649.htm#fromView=search&page=1&position=2&uuid=4d893a5a-a926-4421-96ae-468ced47484d">Изображение от wirestock на Freepik</a>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>