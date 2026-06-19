-- UTF-8 Seed Script for phpMyAdmin (без ALTER DATABASE - для ограниченных прав)
-- Установка UTF-8 на уровне сессии (работает с ограниченными правами)
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;
SET CHARACTER_SET_CONNECTION = utf8mb4;
SET COLLATION_CONNECTION = utf8mb4_unicode_ci;

-- Очистка старых данных (сохраняем админа)
DELETE FROM posts;
DELETE FROM comments;
DELETE FROM media;
DELETE FROM categories;
DELETE FROM users WHERE email != 'admin@example.com';

-- Добавляем автора
INSERT INTO users (name, email, password, role, created_at) VALUES 
('Автор Сайта', 'author@example.com', '$2y$12$k263Wzc2DLFow9ecuF1gc.1e2fbaMw7wGAw5TWKe1RI/gFtFh6gXq', 'author', NOW())
ON DUPLICATE KEY UPDATE role='author';

-- Добавляем категории с русскими названиями
INSERT INTO categories (name, slug, created_at) VALUES 
('Технологии', 'tekhnologii', NOW()),
('Бизнес', 'biznes', NOW()),
('Полезные советы', 'poleznye-sovety', NOW()),
('Новости', 'novosti', NOW()),
('Обучение', 'obuchenie', NOW());

-- Добавляем посты (19 штук) с правильной кодировкой UTF-8
INSERT INTO posts (title, slug, excerpt, content, author_id, category_id, featured_image, status, views, created_at, updated_at) VALUES 
('Как начать с фреймворками: полное руководство для новичков', 'kak-nachat-s-frameworkami', 'Узнайте основы использования популярных PHP фреймворков', 'Полное руководство по выбору и использованию фреймворков в веб-разработке.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Стратегии масштабирования бизнеса в цифровую эпоху', 'strategii-masshtabirovaniya-biznesa', 'Как правильно расти, не потеряв качество', 'Стратегические подходы к масштабированию онлайн-бизнеса для устойчивого роста.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='biznes'), NULL, 'published', 0, NOW(), NOW()),
('10 советов для повышения продуктивности разработчика', '10-sovetov-produktivnosti', 'Практические методы улучшения эффективности работы', 'Проверенные приёмы для оптимизации рабочего процесса и достижения большего за меньшее время.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='poleznye-sovety'), NULL, 'published', 0, NOW(), NOW()),
('Тренды веб-дизайна в 2026 году', 'trendy-veb-dizajna-2026', 'Самые актуальные направления в дизайне', 'Обзор ключевых трендов в веб-дизайне: минимализм, микровзаимодействия, переходы между приложениями.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Как защитить данные в интернете: практические советы', 'kak-zashitit-dannie-internet', 'Основные методы защиты вашей конфиденциальности', 'Полезные рекомендации по защите личных данных и конфиденциальности при работе в интернете.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='poleznye-sovety'), NULL, 'published', 0, NOW(), NOW()),
('Путеводитель по инструментам веб-разработки', 'putevoditel-instrumenty-web', 'Выбор правильных инструментов для проекта', 'Всё, что нужно знать о современных инструментах для эффективной веб-разработки.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='obuchenie'), NULL, 'published', 0, NOW(), NOW()),
('Планирование контент-стратегии: от идеи к публикации', 'planirovanie-kontent-strategii', 'Как создавать контент, который работает', 'Стратегический подход к созданию и распространению контента для успеха вашего проекта.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='biznes'), NULL, 'published', 0, NOW(), NOW()),
('Основы SEO: сделайте ваш сайт заметным', 'osnovy-seo-sdelat-sajt-zametnym', 'Как повысить видимость в поисковых системах', 'Практические советы по оптимизации сайта для улучшения рейтинга в Google и других поисковиках.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Ускорение сайта: оптимизация производительности', 'uskorenie-sajta-optimizaciya-proizvoditelnosti', 'Техники для повышения скорости загрузки', 'Методы оптимизации скорости сайта для улучшения пользовательского опыта и рейтинга SEO.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Доступность веб-контента для всех пользователей', 'dostupnost-veb-kontenta', 'WCAG стандарты и практическое применение', 'Как сделать ваш сайт доступным для людей с различными ограничениями возможностей.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='obuchenie'), NULL, 'published', 0, NOW(), NOW()),
('Тестирование сайта: unit, интеграционные и e2e тесты', 'testirovanie-sajta-unit-e2e', 'Построение надёжной системы тестирования', 'Полный обзор видов тестирования для обеспечения качества веб-приложений.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='obuchenie'), NULL, 'published', 0, NOW(), NOW()),
('Резервное копирование и восстановление данных', 'rezervnoe-kopirovanie-vosstanovlenie-dannyh', 'Защита от потери критичной информации', 'Стратегии резервного копирования и планы восстановления для минимизации рисков потери данных.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Настройка CI/CD для PHP проектов', 'nastrojka-ci-cd-dlya-php', 'Автоматизация развёртывания и тестирования', 'Полное руководство по внедрению непрерывной интеграции и развёртывания для PHP приложений.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Кеширование и CDN: ускорение доставки контента', 'keshirovanie-cdn-http-server', 'Глобальная оптимизация доставки контента', 'Использование кеширования и CDN для молниеносной доставки контента во всём мире.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Защита от SQL-инъекций: безопасность БД', 'zashchita-ot-sql-injekcij', 'Предотвращение атак на базу данных', 'Практические методы защиты от SQL-инъекций и других уязвимостей базы данных.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='poleznye-sovety'), NULL, 'published', 0, NOW(), NOW()),
('Оптимизация изображений для веба', 'optimizaciya-izobrazhenij-dlya-veba', 'WebP, AVIF и адаптивные изображения', 'Как оптимизировать изображения для быстрой загрузки и лучшей производительности.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW()),
('Аналитика: какие метрики отслеживать', 'analitika-kakie-metriki-otslezhivat', 'Google Analytics и пользовательское поведение', 'Ключевые метрики для мониторинга успеха вашего сайта и понимания поведения пользователей.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='biznes'), NULL, 'published', 0, NOW(), NOW()),
('Git workflow для контент-проектов', 'git-workflow-dlya-kontent-proektov', 'Управление версиями и совместная работа', 'Best practices для использования Git в командной разработке и управлении контентом.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='obuchenie'), NULL, 'published', 0, NOW(), NOW()),
('Микросервисная архитектура: масштабирование приложений', 'mikroservisnaya-arhitektura-masshtabirovanie', 'Переход от монолита к микросервисам', 'Концепции, практики и инструменты для построения масштабируемых микросервисных архитектур.', (SELECT id FROM users WHERE email='author@example.com'), (SELECT id FROM categories WHERE slug='tekhnologii'), NULL, 'published', 0, NOW(), NOW());
