<?php
    // HTTP - Apache_2.4-PHP_7.0-7.1   PHP - PHP_7.1   MySQL/MariaDB - MySQL-9.0
    echo "Создание базы данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "CREATE DATABASE knizhnik_db";
	//mysqli_query($link, $sql);
    if (mysqli_query($link, $sql)) {
        echo "<br>База данных успешно создана";
    } else {
        echo "<br>Ошибка при создании базы данных: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы workers (работники) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE workers ( 
		    worker_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
		    login VARCHAR(50) NOT NULL,
            password VARCHAR(32) NOT NULL,
            worker_name VARCHAR(100) NOT NULL,
            role VARCHAR(100) NOT NULL
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записи пользователей в таблице workers в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $password = md5('admin'."lfy8d3sq1");
    $password1 = md5('12345'."lfy8d3sq1");
    $password2 = md5('12345'."lfy8d3sq1");
    $sql = "INSERT IGNORE INTO `workers` (`worker_id`, `login`, `password`, `worker_name`, `role`) VALUES ('1', 'admin', '$password', 'Анисимов Максим Андреевич', 'Администратор'), ('2', 'login1', '$password2', 'Александров Егор Владиславович', 'Кладовщик'), ('3', 'login2', '$password2', 'Зайцев Андрей Дмитриевич', 'Продавец')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы publishers (издатели) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE publishers ( 
		    publisher_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
		    publisher_name VARCHAR(100) NOT NULL
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей издателей в таблице publishers в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `publishers` (`publisher_id`, `publisher_name`) VALUES ('1', 'ACT'), ('2', 'Махаон'), ('3', 'Питер СПб'), ('4', 'Андрей Ельков'), ('5', 'Иностранка'), ('6', 'Лениздат')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы products (товары) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE products ( 
            product_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
		    code VARCHAR(32) NOT NULL,
            barcode VARCHAR(12) NOT NULL,
            product_name VARCHAR(100) NOT NULL,
            publisher_id INT(10) UNSIGNED,
            year_of_publishing YEAR,
            sell_price DECIMAL(8,2)  UNSIGNED,
            FOREIGN KEY (publisher_id) REFERENCES publishers(publisher_id)
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записи товаров в таблице products в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `products` (`product_id`, `code`, `barcode`, `product_name`, `publisher_id`, `year_of_publishing`, `sell_price`) VALUES ('1', 'B653367', '967207876242', '1984', '1', '2021', '349,00'), ('2', 'B522996', '612704162917', 'Билли Саммерс', '1', '2022', '865,00'), ('3', 'B492887', '387150242016', 'Гарри Поттер и Кубок Огня', '2', '2015', '819,00'), ('4', 'B219895', '365435535815', 'Чистый код: создание, анализ и рефакторинг', '3', '2018', '823,00'), ('5', 'B565757', '535815420680', 'Учебник Эндшпиля', '4', '2019', '1073,00'), ('6', 'B803960', '654509343028', 'Ужас Данвича', '1', '2020', '745,00'), ('7', 'B943432', '427668473770', 'Зелёная миля', '1', '2020', '359,00'), ('8', 'B535911', '428699706285', 'Унесенные ветром', '5', '2020', '741,00'), ('9', 'B143771', '408422302919', 'Шерлок Холмс', '6', '2019', '2249,00'), ('10', 'C05012218', '779285583926', 'Скетчбук А5 60л SKETCHBOOK. «Shine белый офсет», 120г/м2, софт.тач., евроспираль', NULL, NULL, '223,00'), ('11', 'C0951037', '609352248773', 'Ручка гелевая черная «Птичка», 0,5 мм', NULL, NULL, '29,00'), ('12', 'C0956107', '904020437162', 'Ручка шариковая авт. синяя «DoubleBlack» 0,7мм, Berlingo', NULL, NULL, '67,00'), ('13', 'C0921110', '651293783873', 'Карандаш ч/гр «Shine» черн. дерево, трехгранный', NULL, NULL, '50,00'), ('14', 'C093022', '564851355327', 'Корректор 20мл «Белая полоса» спирт.основа', NULL, NULL, '35,00'), ('15', 'C102097', '125155835265', 'Ластик сменный «SPECIAL» KAWECO', NULL, NULL, '90,00')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы stock (склад) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE stock (
            stock_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
		    product_id INT(10) UNSIGNED NOT NULL,
            stock_quantity INT(10) UNSIGNED,
            FOREIGN KEY (product_id) REFERENCES products(product_id)
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей в таблице stock в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `stock` (`stock_id`, `product_id`, `stock_quantity`) VALUES ('1', '1', '48'), ('2', '2', '53'), ('3', '3', '35'), ('4', '4', '65'), ('5', '5', '27'), ('6', '6', '64'), ('7', '7', '26'), ('8', '8', '63'), ('9', '9', '45') , ('10', '10', '22') , ('11','11', '95') , ('12', '12', '56') , ('13', '13', '134') , ('14', '14', '9') , ('15', '15', '19')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы consumption (Расход) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE consumption ( 
		    consumption_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            worker_id INT(10) UNSIGNED,
		    product_id INT(10) UNSIGNED,
            quantity INT(10) UNSIGNED,
            consumption_type VARCHAR(10) NOT NULL,
            consumption_date DATETIME,
            FOREIGN KEY (worker_id) REFERENCES workers(worker_id),
            FOREIGN KEY (product_id) REFERENCES products(product_id)
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы orders (заказы) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE orders ( 
		    order_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            order_number INT(10) UNSIGNED NOT NULL,
		    product_id INT(10) UNSIGNED NOT NULL,
            quantity INT(10) UNSIGNED NOT NULL,
            FOREIGN KEY (product_id) REFERENCES products(product_id)
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей в таблице orders в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `orders` (`order_id`, `order_number`, `product_id`, `quantity`) VALUES ('1', '500321', '2', '1'), ('2', '500321', '7', '1'), ('3', '500321', '13', '2'), ('4', '500321', '15', '1'), ('5', '174824', '9', '1'), ('6', '174824', '11', '2'), ('7', '400932', '3', '1'), ('8', '400932', '12', '3'), ('9', '400932', '13', '2'), ('10', '400932', '14', '1'), ('11', '400932', '15', '1')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы suppliers (поставщики) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE suppliers ( 
		    supplier_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
		    supplier_name VARCHAR(100) NOT NULL
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы supplies (поставки) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE supplies ( 
		    supply_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
            supplier_id INT(10) UNSIGNED NOT NULL,
		    product_id INT(10) UNSIGNED NOT NULL,
            buy_price DECIMAL(8,2)  UNSIGNED,
            supplie_quantity INT(10) UNSIGNED,
            supply_date DATETIME,
            FOREIGN KEY (supplier_id) REFERENCES suppliers(supplier_id),
            FOREIGN KEY (product_id) REFERENCES products(product_id)
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы authors (авторы) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE authors ( 
		    author_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
		    author_name VARCHAR(100) NOT NULL
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей авторов в таблице authors в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `authors` (`author_id`, `author_name`) VALUES ('1', 'Джордж Оруэлл'), ('2', 'Стивен Кинг'), ('3', 'Дж. К. Роулинг'), ('4', 'Роберт Мартин'), ('5', 'Марк Дворецкий'), ('6', 'Говард Филлипс Лавкрафт'), ('7', 'Маргарет Митчелл'), ('8', 'Артур Конан Дойл')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы products_authors (товары-авторы) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE products_authors (
            products_authors_id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            product_id INT(10) UNSIGNED NOT NULL,
		    author_id INT(10) UNSIGNED NOT NULL,		    
            PRIMARY KEY (products_authors_id, author_id, product_id),
            FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
            FOREIGN KEY (author_id) REFERENCES authors(author_id) ON DELETE CASCADE
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей в таблице products_authors в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `products_authors` (`products_authors_id`, `product_id`, `author_id`) VALUES ('1', '1', '1'), ('2', '2', '2'), ('3', '3', '3'), ('4', '4', '4'), ('5', '5', '5'), ('6', '6', '6'), ('7', '7', '2'), ('8', '8', '7'), ('9', '9', '8')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы genres (жанры) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE genres ( 
		    genre_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
		    genre_name VARCHAR(100) NOT NULL
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей жанров в таблице genres в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `genres` ( `genre_id`, `genre_name`) VALUES ('1', 'Роман'), ('2', 'Любовный роман'), ('3', 'Приключенческий роман'), ('4', 'Исторический роман'), ('5', 'Криминальный роман'), ('6', 'Детектив'), ('7', 'Боевик'), ('8', 'Приключения'), ('9', 'Мистика'), ('10', 'Триллер'), ('11', 'Научная фантастика'), ('12', 'Фэнтези'), ('13', 'Комиксы'), ('14', 'Детская книга'), ('15', 'Хобби и досуг'), ('16', 'Кулинария'), ('17', 'Учебная'), ('18', 'Научная'), ('19', 'Справочная'), ('20', 'Психология'), ('21', 'Техника'), ('22', 'Документальный'), ('23', 'Биография'), ('24', 'Деловая литература'), ('25', 'Религиозная литература'), ('26', 'Зарубежная литература'), ('27', 'Русская литература'), ('28', 'Юмор'), ('29', 'Фольклор'), ('30', 'Поэзия и проза')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }

    echo "<br><br>Создание таблицы products_genres (товары-жанры) в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
	$sql = "
        CREATE TABLE products_genres ( 
            products_genres_id INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            product_id INT(10) UNSIGNED NOT NULL,
            genre_id INT(10) UNSIGNED NOT NULL,
            PRIMARY KEY (products_genres_id, genre_id, product_id),
            FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
            FOREIGN KEY (genre_id) REFERENCES genres(genre_id) ON DELETE CASCADE
	    )";
    if (mysqli_query($link, $sql)) {
        echo "<br>Таблица успешно создана";
    } else {
        echo "<br>Ошибка при создании таблицы: " . mysqli_error($link);
    }

    echo "<br><br>Создание записей в таблице products_genres в базе данных knizhnik_db";
    $link = new mysqli("localhost", "root", "root", "knizhnik_db");
    if (!$link) {
        echo '<br>Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
        exit;
    }
    $sql = "INSERT IGNORE INTO `products_genres` (`products_genres_id`, `product_id`, `genre_id`) VALUES ('1', '1', '11'), ('2', '1', '26'), ('3', '2', '10'), ('4', '2', '5'), ('5', '2', '26'), ('6', '3', '12'), ('7', '3', '8'), ('8', '3', '14'), ('9', '3', '26'), ('10', '4', '17'), ('11', '4', '18'), ('12', '4', '21'), ('13', '4', '26'), ('14', '5', '15'), ('15', '5', '17'), ('16', '5', '27'), ('17', '6', '9'), ('18', '6', '12'), ('19', '6', '26'), ('20', '7', '12'), ('21', '7', '9'), ('22', '7', '26'), ('23', '8', '1'), ('24', '8', '4'), ('25', '8', '26'), ('26', '9', '6'), ('27', '9', '4'), ('28', '9', '26')";
    if (mysqli_query($link, $sql)) {
        echo "<br>Запись успешно создана";
    } else {
        echo "<br>Ошибка при создании записи: " . mysqli_error($link);
    }
?>