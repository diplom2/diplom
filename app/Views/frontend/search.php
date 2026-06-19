<?php
$pageTitle = 'Поиск';
ob_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск - CMS Blog</title>
    <link rel="stylesheet" href="/css/modern.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="/" class="navbar-brand">📝 CMS Blog</a>
                <ul class="navbar-nav">
                    <li><a href="/">Главная</a></li>
                    <li><a href="/?page=1">Все посты</a></li>
                    <li><a href="/search" class="active">Поиск</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin: 3rem auto;">
        <h1>🔍 Поиск статей</h1>
        
        <div class="card" style="margin: 2rem 0;">
            <form action="/search" method="get">
                <div class="form-group">
                    <label>Введите поисковый запрос</label>
                    <input type="search" name="q" value="<?= Security::escape($_GET['q'] ?? '') ?>" placeholder="Найти статью..." required>
                </div>
                <button type="submit" class="btn btn-primary">Поиск</button>
            </form>
        </div>

        <?php if (strlen(trim($_GET['q'] ?? '')) > 2): ?>
            <?php if (empty($posts)): ?>
                <div class="alert alert-info">
                    По запросу "<strong><?= Security::escape($_GET['q']) ?></strong>" ничего не найдено
                </div>
            <?php else: ?>
                <h2>Найдено <?= count($posts) ?> статей</h2>
                <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-top: 2rem;">
                    <?php foreach ($posts as $post): ?>
                        <article class="card">
                            <h3 style="margin-bottom: 0.5rem;">
                                <a href="/post/<?= Security::escape($post['slug']) ?>">
                                    <?= Security::escape($post['title']) ?>
                                </a>
                            </h3>
                            <div style="color: #64748b; font-size: 0.9rem; margin-bottom: 1rem;">
                                📅 <?= date('d.m.Y', strtotime($post['created_at'])) ?>
                                <?php if ($post['category_name']): ?>
                                    | <a href="/category/<?= Security::escape($post['category_slug']) ?>"><?= Security::escape($post['category_name']) ?></a>
                                <?php endif; ?>
                            </div>
                            <p style="color: #64748b; margin-bottom: 1rem;">
                                <?= Security::escape(substr(strip_tags($post['content']), 0, 300)) ?>...
                            </p>
                            <a href="/post/<?= Security::escape($post['slug']) ?>" class="btn btn-primary btn-sm">Читать</a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                Введите минимум 3 символа для поиска
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
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
