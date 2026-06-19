<?php
$csrfToken = Security::generateCSRFToken();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | CMS</title>
    <link rel="stylesheet" href="/css/auth.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <h1>Регистрация</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $field => $messages): ?>
                            <?php foreach ((array)$messages as $message): ?>
                                <li><?php echo Security::escape($message); ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="post" action="/register">
                <input type="hidden" name="csrf_token" value="<?php echo Security::escape($csrfToken); ?>">

                <div class="form-group">
                    <label for="login">Имя пользователя</label>
                    <input type="text" id="login" name="login" value="<?php echo Security::escape($_POST['login'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo Security::escape($_POST['email'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
            </form>

            <p class="form-footer">Уже есть аккаунт? <a href="/login">Войти</a></p>
        </div>
    </div>
</body>
</html>
