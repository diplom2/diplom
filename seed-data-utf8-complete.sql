-- === ПОЛНЫЙ СКРИПТ ИСПРАВЛЕНИЯ UTF-8 И ВСТАВКИ ДАННЫХ ===
-- Выполните в phpMyAdmin (вкладка SQL) для вашей базы данных (обычно cms_bd)

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
START TRANSACTION;

-- 1) Преобразуем базу и таблицы в UTF-8
ALTER DATABASE `cms_bd` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE `users` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `categories` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `posts` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `media` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `comments` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE `settings` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2) Очищаем старые данные (кроме админа)
DELETE FROM comments;
DELETE FROM posts;
DELETE FROM categories;
DELETE FROM users WHERE email != 'admin@example.com';

-- 3) Вставляем автора
INSERT INTO users (name, email, password, role, status, created_at, updated_at)
VALUES ('Главный автор', 'author@example.com', '$2y$12$k263Wzc2DLFow9ecuF1gc.1e2fbaMw7wGAw5TWKe1RI/gFtFh6gXq', 'editor', 'active', NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- 4) Вставляем категории
INSERT INTO categories (name, slug, description, parent_id, created_at, updated_at) VALUES
('Технологии', 'technology', 'Статьи о веб-разработке, инструментах и новых технологиях', NULL, NOW(), NOW()),
('Бизнес', 'business', 'Стратегии развития, маркетинг и управление проектами', NULL, NOW(), NOW()),
('Полезные советы', 'tips', 'Практические советы по повышению продуктивности', NULL, NOW(), NOW()),
('Новости', 'news', 'Последние новости индустрии и обновления', NULL, NOW(), NOW()),
('Обучение', 'tutorials', 'Пошаговые уроки и руководства', NULL, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();

-- 5) Вставляем посты (19 штук)
INSERT INTO posts (title, slug, content, excerpt, category_id, author_id, status, published_at, created_at, updated_at) VALUES

('Как начать работать с современными фреймворками', 'kak-nachat-s-frameworkami', 
'<p>В современной веб-разработке фреймворки стали неотъемлемой частью процесса создания приложений. Они предоставляют готовые решения для большинства задач, что значительно ускоряет разработку.</p><h3>Выбор правильного фреймворка</h3><p>При выборе фреймворка необходимо учитывать: размер и сложность проекта, опыт команды, производительность, экосистема и сообщество.</p>',
'Руководство для начинающих разработчиков по выбору и использованию фреймворков.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Стратегии масштабирования бизнеса в 2026 году', 'strategii-masshtabirovaniya-biznesa',
'<p>Масштабирование бизнеса — это ключевой момент в развитии компании. Правильная стратегия может увеличить доход и расширить рынок. Перед масштабированием необходимо провести тщательный анализ рынка: изучить конкурентов, определить целевую аудиторию, оценить спрос на услугу.</p>',
'Рассмотрим основные стратегии и методы успешного масштабирования компании.',
(SELECT id FROM categories WHERE slug = 'business'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('10 полезных советов для повышения продуктивности', '10-sovetov-produktivnosti',
'<p>Продуктивность — это искусство максимально эффективно использовать своё время. Вот несколько проверенных советов: Планирование, Техника Pomodoro, Устраняйте отвлечения, Делегируйте, Отдыхайте.</p>',
'Практические советы для увеличения продуктивности и эффективности работы.',
(SELECT id FROM categories WHERE slug = 'tips'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Последние тренды в веб-дизайне 2026', 'trendy-veb-dizajna-2026',
'<p>Веб-дизайн постоянно эволюционирует. Рассмотрим основные тренды, которые доминируют в 2026 году: Минимализм, Темная тема, Микро-взаимодействия, Адаптивный дизайн.</p>',
'Обзор самых актуальных трендов в веб-дизайне и их применение.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Как защитить свои данные в интернете', 'kak-zashitit-dannie-internet',
'<p>Безопасность в интернете — это критически важный аспект жизни в 2026 году. Вот основные принципы защиты: Сильные пароли, Двухфакторная аутентификация, Своевременные обновления, Антивирус и VPN.</p>',
'Практические советы для защиты ваших личных данных и конфиденциальности.',
(SELECT id FROM categories WHERE slug = 'tutorials'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Путеводитель по инструментам веб-разработчика', 'putevoditel-instrumenty-web',
'<p>Современный веб-разработчик использует множество инструментов. Выберите инструмент, который повышает вашу продуктивность — VS Code, PhpStorm или другие. Важны и утилиты командной строки, системы контроля версий, инструменты тестирования.</p>',
'Обзор полезных инструментов и советов для веб-разработчиков.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Планирование контент-стратегии для блога', 'planirovanie-kontent-strategii',
'<p>Контент-стратегия помогает систематизировать публикации и привлекать аудиторию. Разберём ключевые этапы планирования и примеры календаря публикаций.</p>',
'Как спланировать контент для блога: темы, частота, метрики.',
(SELECT id FROM categories WHERE slug = 'business'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Основы SEO: как сделать сайт заметным в поиске', 'osnovy-seo-sdelat-sajt-zametnym',
'<p>Понимание основ SEO критично для привлечения органического трафика. Важные факторы: метатеги, структура заголовков, оптимизация контента, внутренние ссылки, мобильная оптимизация.</p>',
'Краткое руководство по базовой SEO-оптимизации сайта.',
(SELECT id FROM categories WHERE slug = 'business'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Ускорение сайта: практики оптимизации производительности', 'uskorenie-sajta-optimizaciya-proizvoditelnosti',
'<p>Пошаговые рекомендации по сокращению времени загрузки: сжатие, кэширование, оптимизация изображений, lazy-load, минификация CSS/JS, CDN.</p>',
'Методы ускорения веб-страниц и улучшения UX.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Доступность веб-контента: почему это важно', 'dostupnost-veb-kontenta',
'<p>Доступность помогает сделать контент доступным для всех пользователей — обсуждаем ARIA, семантическую разметку и клавиатурную навигацию.</p>',
'Ключевые практики веб-доступности для разработчиков и авторов.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Тестирование сайта: от юнитов до E2E', 'testirovanie-sajta-unit-e2e',
'<p>Обзор подходов к тестированию веб-приложений: юнит-тесты, интеграционные и end-to-end тесты с практическими примерами.</p>',
'Как построить стратегию тестирования для надёжного сайта.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Резервное копирование и восстановление данных для небольшого сайта', 'rezervnoe-kopirovanie-vosstanovlenie-dannyh',
'<p>Простые и эффективные стратегии резервного копирования: куда сохранять бэкапы, частота, автоматизация и тест восстановления.</p>',
'Практическое руководство по защите данных сайта.',
(SELECT id FROM categories WHERE slug = 'tutorials'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Как настроить CI/CD для PHP-проекта', 'nastrojka-ci-cd-dlya-php',
'<p>Интеграция CI/CD повышает качество релизов. Разберём примеры конфигураций для GitHub Actions и простую пайплайн-логику для тестов и деплоя.</p>',
'Быстрый старт с CI/CD для PHP-проектов.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Кэширование: CDN, HTTP и серверные техники', 'keshirovanie-cdn-http-server',
'<p>Различные уровни кэширования и примеры их применения: CDN, заголовки HTTP, серверный кеш и инвалидация.</p>',
'Как правильно кэшировать ресурсы для скорости и масштаба.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Защита от SQL-инъекций и безопасные запросы', 'zashchita-ot-sql-injekcij',
'<p>Почему SQL-инъекции опасны и как им противостоять: подготовленные выражения, валидация и минимизация прав доступа.</p>',
'Базовые и продвинутые техники защиты БД.',
(SELECT id FROM categories WHERE slug = 'tutorials'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Оптимизация изображений для веба', 'optimizaciya-izobrazhenij-dlya-veba',
'<p>Форматы, сжатие и выбор размеров изображений — как снизить трафик и ускорить загрузку без потери качества.</p>',
'Практические советы по работе с изображениями на сайте.',
(SELECT id FROM categories WHERE slug = 'technology'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Аналитика сайта: какие метрики отслеживать', 'analitika-kakie-metriki-otslezhivat',
'<p>Список важных метрик: посещаемость, вовлечённость, источники трафика и конверсии. Как правильно интерпретировать данные.</p>',
'Ключевые метрики для оценки эффективности блога.',
(SELECT id FROM categories WHERE slug = 'business'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW()),

('Работа в команде: git-воркфлоу для контент-проектов', 'git-workflow-dlya-kontent-proektov',
'<p>Организация совместной работы над контентом и кодом: ветвление, ревью и автоматические проверки перед мерджем.</p>',
'Практики git-воркфлоу для команд редакции и разработчиков.',
(SELECT id FROM categories WHERE slug = 'business'), (SELECT id FROM users WHERE email = 'author@example.com'), 'published', NOW(), NOW(), NOW())

ON DUPLICATE KEY UPDATE 
  content = VALUES(content), 
  excerpt = VALUES(excerpt), 
  updated_at = NOW();

COMMIT;

-- Проверяем результаты
SELECT 'Пользователи:' as 'Проверка';
SELECT COUNT(*) as total, email FROM users GROUP BY email;

SELECT 'Категории:' as 'Проверка';
SELECT COUNT(*) as total FROM categories;

SELECT 'Посты:' as 'Проверка';
SELECT COUNT(*) as total FROM posts;
