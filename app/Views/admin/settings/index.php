<?php
AuthMiddleware::checkAuth();

$pageTitle = 'Настройки';
$settingsModel = new Settings();
$settings = $settingsModel->getAll() ?? [];

ob_start();
?>

<h1>⚙️ Настройки системы</h1>

<div class="card" style="max-width: 800px;">
    <form method="POST" action="/admin/settings">
        <input type="hidden" name="csrf_token" value="<?= Security::generateCSRFToken() ?>">

        <fieldset style="border: none; padding: 0; margin-bottom: 2rem;">
            <legend style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">📌 Основные настройки</legend>

            <div style="margin-bottom: 1.5rem;">
                <label for="site_title" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Название сайта</label>
                <input type="text" id="site_title" name="site_title" 
                       value="<?= Security::escape($settings['site_title'] ?? 'CMS') ?>"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="site_description" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Описание сайта</label>
                <textarea id="site_description" name="site_description" rows="4"
                          style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);"><?= Security::escape($settings['site_description'] ?? '') ?></textarea>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="site_keywords" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Ключевые слова (через запятую)</label>
                <input type="text" id="site_keywords" name="site_keywords" 
                       value="<?= Security::escape($settings['site_keywords'] ?? '') ?>"
                       style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md);">
            </div>
        </fieldset>

        <fieldset style="border: none; padding: 0; margin-bottom: 2rem;">
            <legend style="font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem;">💬 Комментарии</legend>

            <div style="margin-bottom: 1rem;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="enable_comments" value="1"
                        <?= (isset($settings['enable_comments']) && $settings['enable_comments']) ? 'checked' : '' ?>
                        style="margin-right: 0.5rem;">
                    <span>Включить комментарии на сайте</span>
                </label>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: flex; align-items: center; cursor: pointer;">
                    <input type="checkbox" name="comments_moderation" value="1"
                        <?= (isset($settings['comments_moderation']) && $settings['comments_moderation']) ? 'checked' : '' ?>
                        style="margin-right: 0.5rem;">
                    <span>Требовать модерацию комментариев</span>
                </label>
            </div>
        </fieldset>

        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <button type="submit" class="btn btn-primary">💾 Сохранить настройки</button>
            <a href="/admin/dashboard" class="btn btn-secondary">↩️ Отмена</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
        </fieldset>

        <fieldset>
            <legend>Пагинация</legend>

            <div class="form-group">
                <label for="posts_per_page">Постов на странице:</label>
                <input type="number" id="posts_per_page" name="posts_per_page" min="1" 
                       value="<?php echo Security::escape($settings['posts_per_page'] ?? 10); ?>">
            </div>
        </fieldset>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </form>

    <hr>

    <div class="backup-section">
        <h3>Резервное копирование</h3>
        <p>Создайте резервную копию базы данных</p>
        <a href="/admin/settings/backup" class="btn btn-secondary">Скачать резервную копию</a>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../../layouts/admin.php';
?>
