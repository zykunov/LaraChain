# Larachain

**Larachain** — это симуляция блокчейна на стеке Laravel 12 + Vue 3. Приложение реализует упрощённую структуру блокчейна с цепочками блоков, каждый из которых содержит хеши, метки времени и данные. Предоставляет веб-дашборд для просмотра и управления блокчейн-цепочками через REST API.

---

## Структура проекта

###  PHP Backend (`app/`)

#### Models (`app/Models/`)

| Файл | Описание |
|------|----------|
| `Block.php` | Модель отдельного блока в блокчейне. Содержит поля: `chain_id`, `data`, `timestamp`, `previous_hash`, `hash`. Связан с цепочкой через `belongsTo(Chain)`. Кастомные аксессоры для преобразования индекса, хеша и timestamp в Unix-формат. |
| `Chain.php` | Модель блокчейн-цепочки (коллекции блоков). Хранит данные блоков как JSON-массив в поле `chain`. Метод `updateBlocks()` для обновления блоков цепочки. |
| `User.php` | Стандартная модель аутентификации Laravel (имя, email, пароль). |

#### Controllers (`app/Http/Controllers/`)

| Файл | Описание |
|------|----------|
| `BlockchainController.php` | Основной API-контроллер для блокчейн-запросов. Внедряет `ChainService` и `BlockService`. Эндпоинты: `create()` — создание блока, `show()` — текущая цепочка, `allChains()` — все цепочки, `getBlocksByChainId()` — блоки конкретной цепочки, `addBlock()` — добавление блока с валидацией. |

#### Services (`app/Services/`)

##### Block (`app/Services/Block/`)

| Файл | Описание |
|------|----------|
| `BlockService.php` | Бизнес-логика операций с блоками. Создаёт новые блоки (`createNewBlock()`), получает блоки по chainId с кэшированием (60 сек), получает последний блок, инвалидирует кэш. |
| `BlockValidator.php` | Валидация целостности блокчейна между двумя последовательными блоками: проверка continuity хешей, последовательности индексов и корректности хеша. |
| `Hasher.php` | Генерация SHA-256 хешей для блоков. Вычисляет `sha256(timestamp . previous_hash)`. |

##### Chain (`app/Services/Chain/`)

| Файл | Описание |
|------|----------|
| `ChainService.php` | Управление цепочками на уровне цепочки. Получение всех цепочек с кэшированием (120 сек), проверка существования цепочки, инвалидация кэша. |
| `ChainValidator.php` | Валидация целостности всей цепочки. Итерируется по всем блокам и проверяет каждую пару через `BlockValidator`. |

###  Artisan-команды

| Команда | Описание |
|---------|----------|
| `php artisan generate:blockchain_with_genesis_block` | Создание новой блокчейн-цепочки с genesis-блоком. |




### ️ Роуты (`routes/`)

| Файл | Описание |
|------|----------|
| `api.php` | API-маршруты с префиксом `/api/blockchain/`. GET `/show` — текущая цепочка, POST `/create` — создание блока, GET `/chains` — все цепочки, GET `/chain/{id}` — блоки цепочки, POST `/blockAdd` — добавление блока. |
| `web.php` | Веб-маршруты для SPA-фронтенда. Catch-all `/{any}` возвращает blade-шаблон `app`. `/dashboard` — дашборд (auth). Дублирующие маршруты `/blockchain/show` и `/blockchain/create`. |
| `console.php` | Консольные маршруты. Содержит стандартную команду `inspire`. |

---


### Миграции (`database/migrations/`)

| Файл | Описание |
|------|----------|
| `2026_04_30_124156_chain.php` | Таблица `chains` (id + timestamps). Данные блоков хранятся как JSON в поле `chain`. |
| `2026_04_30_124301_block.php` | Таблица `blocks`: chain_id (FK), data (text), timestamp, previous_hash (64 chars), hash (64 chars, unique), timestamps. Индекс на chain_id. Основной источник данных блоков. |



### 🎨 Vue Фронтенд (`resources/js/`)


#### Router (`resources/js/router/`)

| Файл | Описание |
|------|----------|
| `index.js` | Vue Router с HTML5 history mode. Маршруты: `/dashboard` → Dashboard, `/chains` → ChainList, `/blocks` → Blocks, `/chain/:id` → ChainBlocksView (валидация числового ID + beforeEnter guard), `/` → редирект на `/dashboard`. |


#### Components (`resources/js/Сomponents/`)

> **Примечание:** Директория `Сomponents` содержит кириллическую букву "С" в названии.

| Файл | Описание                                                                                             |
|------|------------------------------------------------------------------------------------------------------|
| `Layout.vue` | Основной лейаут приложения: боковая навигация (sidebar), header, пункты меню. Стили на Tailwind CSS. |

#### Views (`resources/js/Views/`)

| Файл | Описание |
|------|----------|
| `ChainList.vue` | Отображает список всех блокчейн-цепочек. API: `GET /api/blockchain/chains`. Loading spinner, обработка ошибок, валидация ID цепочек (положительные целые числа), ссылки на `ChainBlocksView`. |
| `ChainBlocksView.vue` | Отображает все блоки в конкретной цепочке. API: `GET /api/blockchain/chain/{chainId}`. Props: `chainId` из route params. Loading, error handling с retry, детали блока (id, data, chain_id, timestamp, previous_hash, hash), форматирование дат в русской локали. |
| `Blocks.vue` | Шаблон карточки платежа/транзакции. Статичный layout: сумма, тип, дата, аватар, имя, progress bar. Без script logic — в разработке. |


## Архитектура

### Ключевые особенности:

1. **Хранение данных**: Таблица `blocks` — основной источник данных, блоки связаны с цепочками через `chain_id`.
2. **Кэширование**: Redis или database-backed кэш с коротким TTL (60–120 сек).
3. **Безопасность**: Laravel Sanctum для API-аутентификации.
4. **Фронтенд**: Vue 3 SPA с Vue Router, Tailwind CSS, Chart.js для графиков.
5. **Деплой**: Docker-контейнеризация (Nginx + PHP-FPM + MySQL + Redis).

---
