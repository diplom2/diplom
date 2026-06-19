<?php
$pageTitle = isset($post) ? Security::escape($post['title']) : 'Статья';
ob_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - CMS</title>
    <link rel="stylesheet" href="/css/modern.css">
</head>
<body>
    <!-- НАВИГАЦИЯ -->
    <nav class="navbar">
        <div class="container">
            <div class="navbar-content">
                <a href="/" class="navbar-brand">📝 CMS Blog</a>
                <ul class="navbar-nav">
                    <li><a href="/">Главная</a></li>
                    <li><a href="/?page=1">Все посты</a></li>
                    <li><a href="/search">Поиск</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="/admin/dashboard">Панель</a></li>
                        <li><a href="/logout">Выход</a></li>
                    <?php else: ?>
                        <li><a href="/login">Вход</a></li>
                        <li><a href="/register">Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ОСНОВНОЙ КОНТЕНТ -->
    <div class="container" style="margin: 3rem auto;">
        <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem;">
            <!-- СТАТЬЯ -->
            <main>
                <article class="card">
                    <!-- ЗАГОЛОВОК -->
                    <div class="card-header">
                        <h1><?= Security::escape($post['title']) ?></h1>
                        <div style="display: flex; gap: 1.5rem; margin-top: 1rem; color: #64748b; font-size: 0.95rem;">
                            <span>✍️ <?= Security::escape($post['author_name'] ?? 'Автор') ?></span>
                            <span>📅 <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></span>
                            <?php if ($post['category_name']): ?>
                                <span><a href="/category/<?= Security::escape($post['category_slug']) ?>" style="color: #2563eb;"><?= Security::escape($post['category_name']) ?></a></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- ИЗОБРАЖЕНИЕ -->
                    <?php if ($post['featured_image_id']): ?>
                        <div style="margin: 1.5rem 0; text-align: center;">
                            <div style="background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); height: 400px; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">
                                🖼️
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- СОДЕРЖАНИЕ -->
                    <div style="font-size: 1.05rem; line-height: 1.8; margin: 2rem 0; color: #334155;">
                        <?= $post['content'] ?>
                    </div>
                </article>

                <!-- НАВИГАЦИЯ -->
                <div style="margin-top: 2rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <a href="/" class="btn btn-secondary btn-lg" style="justify-content: center;">← Назад</a>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <a href="/admin/posts/<?= $post['id'] ?>/edit" class="btn btn-primary btn-lg" style="justify-content: center;">Редактировать</a>
                    <?php endif; ?>
                </div>

                <!-- КОММЕНТАРИИ -->
                <div class="card" style="margin-top: 2rem;">
                    <h3>💬 Комментарии</h3>
                    
                    <?php if (!empty($_SESSION['comment_success'])): ?>
                        <div class="alert alert-success">
                            <?= Security::escape($_SESSION['comment_success']) ?>
                        </div>
                        <?php unset($_SESSION['comment_success']); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION['comment_errors'])): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <?php foreach ($_SESSION['comment_errors'] as $field => $msgs): ?>
                                    <?php foreach ($msgs as $msg): ?>
                                        <li><?= Security::escape($msg) ?></li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php unset($_SESSION['comment_errors']); ?>
                    <?php endif; ?>

                    <!-- ФОРМА КОММЕНТАРИЯ -->
                    <form method="post" style="background: #f8fafc; padding: 1.5rem; border-radius: 0.75rem; margin: 1rem 0;">
                        <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                            <div class="form-group">
                                <label>Имя</label>
                                <input type="text" name="author_name" required placeholder="Ваше имя">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="author_email" required placeholder="your@email.com">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Комментарий</label>
                            <textarea name="content" required placeholder="Ваш комментарий..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Отправить комментарий</button>
                    </form>

                    <!-- СПИСОК КОММЕНТАРИЕВ -->
                    <?php if (!empty($comments)): ?>
                        <div style="margin-top: 2rem;">
                            <?php foreach ($comments as $comment): ?>
                                <div style="border-left: 3px solid #2563eb; padding-left: 1rem; margin-bottom: 1.5rem; padding: 1rem;">
                                    <strong><?= Security::escape($comment['author_name']) ?></strong>
                                    <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 0.5rem;">
                                        <?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?>
                                    </div>
                                    <p><?= Security::escape($comment['content']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color: #64748b; margin-top: 1rem;">Комментариев ещё нет. Будьте первым!</p>
                    <?php endif; ?>
                </div>
            </main>

            <!-- САЙДБАР -->
            <aside>
                <!-- ПОХОЖИЕ СТАТЬИ -->
                <div class="card" style="margin-bottom: 1.5rem;">
                    <h5 style="margin-bottom: 1rem;">📚 Похожие статьи</h5>
                    <ul style="list-style: none;">
                        <?php 
                        $relatedPosts = isset($relatedPosts) ? $relatedPosts : [];
                        if (empty($relatedPosts)): 
                        ?>
                            <li style="color: #64748b;">Других статей нет</li>
                        <?php else: ?>
                            <?php foreach ($relatedPosts as $related): ?>
                                <li style="margin-bottom: 1rem;">
                                    <a href="/post/<?= Security::escape($related['slug']) ?>" style="color: #2563eb; font-weight: 500;">
                                        <?= Security::escape($related['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- ИНФОРМАЦИЯ ОБ АВТОРЕ -->
                <div class="card" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            ✍️
                        </div>
                        <h5><?= Security::escape($post['author_name'] ?? 'Автор') ?></h5>
                    </div>
                    <p style="text-align: center; font-size: 0.9rem; color: #64748b;">
                        Автор этой статьи пишет интересные и полезные материалы.
                    </p>
                </div>
            </aside>
        </div>
    </div>

    <!-- ФУТЕР -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h5>О сайте</h5>
                    <ul>
                        <li><a href="/">Главная</a></li>
                        <li><a href="/?page=1">Все статьи</a></li>
                        <li><a href="/search">Поиск</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Категории</h5>
                    <ul>
                        <li><a href="/category/tech">Технология</a></li>
                        <li><a href="/category/business">Бизнес</a></li>
                        <li><a href="/category/tips">Советы</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Контакты</h5>
                    <ul>
                        <li>Email: info@cms.local</li>
                        <li>Телефон: +7 (999) 999-99-99</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 CMS Blog. Все права защищены.</p>
            </div>
        </div>
    </footer>
</body>
</html>

<?php
$content = ob_get_clean();
echo $content;
?>
