<?php 

$user = currentUser();
?>

<header>
    <div class="container">
        <nav class="menu">
            <ul>
                <li class="link"><a href="/content.php" class="contrast">Главная</a></li>    
            </ul>
            <ul>
                <?php if ($user or isset($_SESSION['vk-data'])) : ?>
                    <form method="post" action="/application/controllers/logOut_controller.php">
                         <button type="submit" id="logOut" style="margin-bottom: 0px !important;">Выйти</button>
                    </form>
                <?php else : ?>
                        <li><a href="/authorise.php" class="contrast">Войти</a></li>
                        <li><a href="/register.php" class="contrast">Зарегистрироваться</a></li>
                <?php endif ?>
            </ul>
        </nav>
    </div>
</header>