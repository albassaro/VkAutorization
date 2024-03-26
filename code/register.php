<?php 
require __DIR__ . '/application/config/functions.php'; 

checkGuest();

?>

<!DOCTYPE html>
<html lang="en">

<?php include './application/views/template_head.php' ?>

<body>
    <?php include './application/views/template_nav.php' ?>
    <main>
        <form class="form-card" action="application/controllers/registrValidate_controller.php" method="post" enctype="multipart/form-data">
            <h2>Регистрация</h2>
            <fieldset>
                <label for="login">
                    Логин
                    <input type="text" id="name" name="login" placeholder="Введите логин" value="<?php echo getInputValue('login') ?>" <?php echo validationErrorAttribute('login') ?> />

                    <?php if (sessionErrorIsExists('login')) : ?>
                        <small class="error" id="login-helper"><?php echo getErrorMessage('login') ?></small>
                    <?php endif; ?>
                </label>

                <label for="password">
                    Пароль
                    <input type="password" id="password" name="password" placeholder="Введите пароль" value="<?php echo getInputValue('password') ?>" <?php echo validationErrorAttribute('password') ?> />

                    <?php if (sessionErrorIsExists('password')) : ?>
                        <small class="error" id="password-helper"><?php echo getErrorMessage('password') ?></small>
                    <?php endif; ?>
                </label>
                <?php require __DIR__ . '/application/config/vk_config.php'; ?>
            </fieldset>
            <button type="submit" id="submit">Зарегистрироваться</button>
        </form>
    </main>
</body>
</html>