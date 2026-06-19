<?php $pageTitle = 'Вход в систему'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo Security::escape($pageTitle); ?> - CMS</title>
    <link rel="stylesheet" href="/css/auth.css">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-box">
            <h1>Вход в CMS</h1>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $field => $messages): ?>
                            <?php foreach ($messages as $message): ?>
                                <li><?php echo Security::escape($message); ?></li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="/login">
                <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">

                <div class="form-group">
                    <label for="login">Email или имя пользователя:</label>
                    <input type="text" id="login" name="login" required 
                           value="<?php echo Security::escape($_POST['login'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="password">Пароль:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Войти</button>
            </form>

            <p class="form-footer">
                <a href="/forgot-password">Забыли пароль?</a>
                <br>
                <a href="/register">Нет аккаунта? Зарегистрироваться</a>
            </p>
        </div>
    </div>
</body>
</html>
