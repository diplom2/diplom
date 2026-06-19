<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Страница не найдена</title>
    <link rel="stylesheet" href="/css/modern.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="/" class="navbar-brand">📝 CMS Blog</a>
            </div>
        </div>
    </nav>

    <div class="container" style="text-align: center; padding: 4rem 0;">
        <h1 style="font-size: 3rem; color: #ef4444; margin-bottom: 1rem;">404</h1>
        <h2>Страница не найдена</h2>
        <p style="color: #64748b; margin: 1.5rem 0;">К сожалению, запрошенная страница не существует или была удалена.</p>
        <a href="/" class="btn btn-primary btn-lg" style="display: inline-flex; margin-top: 2rem;">← Вернуться на главную</a>
    </div>

    <footer class="footer" style="margin-top: 4rem;">
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2026 CMS Blog. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>

<?php
echo ob_get_clean();
?>
