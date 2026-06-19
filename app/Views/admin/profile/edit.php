<?php
AuthMiddleware::checkAuth();

$pageTitle = 'Мой профиль';
$user = (new User())->findById($_SESSION['user_id']);
$errors = $errors ?? [];

ob_start();
?>

<h1>👤 Мой профиль</h1>

<div class="card" style="max-width: 600px;">
    <form method="POST" action="/admin/profile">
        <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">

        <!-- ИМЯ -->
        <div style="margin-bottom: 1.5rem;">
            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Имя *</label>
            <input type="text" id="name" name="name" required 
                   value="<?= Security::escape($_POST['name'] ?? $user['name']) ?>"
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
            <?php if (!empty($errors['name'])): ?>
                <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">
                    <?= Security::escape($errors['name'][0]) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- EMAIL -->
        <div style="margin-bottom: 1.5rem;">
            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email *</label>
            <input type="email" id="email" name="email" required 
                   value="<?= Security::escape($_POST['email'] ?? $user['email']) ?>"
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
            <?php if (!empty($errors['email'])): ?>
                <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">
                    <?= Security::escape($errors['email'][0]) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- РАЗДЕЛИТЕЛЬ -->
        <hr style="margin: 2rem 0; border: none; border-top: 1px solid var(--border);">

        <!-- СМЕНА ПАРОЛЯ -->
        <h3 style="margin-bottom: 1rem;">🔒 Изменить пароль</h3>

        <div style="margin-bottom: 1.5rem;">
            <label for="current_password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Текущий пароль</label>
            <input type="password" id="current_password" name="current_password"
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
            <?php if (!empty($errors['current_password'])): ?>
                <div style="color: var(--danger); font-size: 0.875rem; margin-top: 0.25rem;">
                    <?= Security::escape($errors['current_password'][0]) ?>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="password" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Новый пароль</label>
            <input type="password" id="password" name="password"
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Подтвердите пароль</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
        </div>

        <!-- КНОПКИ -->
        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">💾 Сохранить</button>
            <a href="/admin/dashboard" class="btn btn-secondary">↩️ Отмена</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="/admin/dashboard" class="btn">Отмена</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
