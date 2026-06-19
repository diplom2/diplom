<?php
AuthMiddleware::checkAuth();

$pageTitle = 'Управление комментариями';
$commentModel = new Comment();
$comments = $commentModel->getPending() ?? [];

ob_start();
?>

<h1>💬 Управление комментариями</h1>

<?php if (empty($comments)): ?>
    <div class="card" style="text-align: center; padding: 3rem;">
        <p style="color: var(--text-light); font-size: 1.1rem;">✅ Нет комментариев на модерации</p>
    </div>
<?php else: ?>
    <div style="display: grid; gap: 1rem;">
        <?php foreach ($comments as $comment): ?>
            <div class="card" style="padding: 1.5rem; border-left: 4px solid var(--primary);">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                    <div>
                        <strong style="font-size: 1.1rem;"><?= Security::escape($comment['author_name']) ?></strong>
                        <br/>
                        <small style="color: var(--text-light);">
                            📅 <?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?>
                        </small>
                    </div>
                    <small style="color: var(--text-light);">
                        <strong>В посте:</strong> <em><?= Security::escape($comment['post_title'] ?? 'N/A') ?></em>
                    </small>
                </div>
                
                <div style="margin-bottom: 1.5rem; padding: 1rem; background: var(--light); border-radius: var(--radius-md);">
                    <p style="margin: 0; line-height: 1.6;">
                        <?= nl2br(Security::escape($comment['content'])) ?>
                    </p>
                </div>
                
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <a href="/admin/comments/<?= $comment['id'] ?>/approve" class="btn btn-success btn-sm">✅ Одобрить</a>
                    <a href="/admin/comments/<?= $comment['id'] ?>/reject" class="btn btn-warning btn-sm">❌ Отклонить</a>
                    <a href="/admin/comments/<?= $comment['id'] ?>/delete" class="btn btn-danger btn-sm" onclick="return confirm('Удалить?');">🗑️ Удалить</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
