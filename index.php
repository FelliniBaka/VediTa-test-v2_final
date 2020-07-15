<?php

// Разово созданём таблицу посредством php
//

  $sql = 'CREATE TABLE IF NOT EXISTS `Products` (
    `id` INT(6) NOT NULL Primary KEY AUTO_INCREMENT,
    `product_id` INT(6) NOT NULL,
    `product_name` VARCHAR(40) NOT NULL,
    `product_price` NUMERIC(8),
    `product_article` VARCHAR(15),
    `product_quantity` INT(8) DEFAULT 0,
    `date_create` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `is_hidden` TINYINT(1) DEFAULT 0)
        ENGINE=InnoDB DEFAULT CHARSET=utf8;';

$db = new \PDO('mysql:host=localhost;dbname=vedita_test_v2',
    'root',
    '');
$db->exec($sql);

// Заполняем данными для теста

/*$db = new \PDO('mysql:host=localhost;dbname=vedita_test_v2',
    'root',
    '');
for ($z = 1; $z < 15 ; $z++){
    $sql = 'INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_quantity`) VALUES ('.$z.', "productName'.$z.'" ,'.$z.'000 ,'.$z.');';
    $db->exec($sql);
}*/

// Имплементирована в классе CProducts

/*function getWholeTable ($filterString=null, $limit=15, $tableName='`Products`'): ?array
{
    $db = new \PDO('mysql:host=localhost;dbname=vedita_test_v2',
        'root',
        '');
    if ($filterString == null){
        $sth = $db->query('SELECT * FROM '.$tableName.'ORDER BY `DATE_CREATE` DESC, `ID` DESC LIMIT '.$limit);
        return $sth ? $sth->fetchAll() : null;
    }
    $sth = $db->query('SELECT * FROM '.$tableName.' WHERE '.$filterString.' ORDER BY `DATE_CREATE` DESC,`ID` DESC LIMIT '.$limit.';');
    return $sth->fetchAll();
}*/
spl_autoload_register(
        function($class) {
            include ($class . '.php');
        }
);
$products = new Cproducts();

$productsTable = $products->getTable();
$productsTableFiltered = $products->getTable('`id`>6 AND `product_price`<10000');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test task</title>
    <link rel="stylesheet" href="style.css">
    <script src="myscript.js"></script>
</head>
<body>
    <div class="mainConteiner">
        <table class="mainTable">
            <tr>
                <td colspan="7">
                    <h2>Whole table</h2>
                </td>
            </tr>
                <?php $products->createHeaderRow() ?>
                <?php foreach ($productsTable as $product): ?>
            <tr data-productId="<?= $product['id'] ?>" class="productRow">
                <?php for ($i = 0; $i < 5; $i++): ?>
            <td class="productColumn"><?= $product[$i] ?></td> <!-- x6 -->
                <?php endfor ?>
                <td class="productColumn">
                    <button class="minus">-</button>
                    <span><?= $product['product_quantity'] ?></span>
                    <button class="plus">+</button>
                </td>
                <td class="productColumn">
                    <?= $product['date_create'] ?>
                    <br>
                    <button class="hideButton">Скрыть</button>
                </td>
            </tr>
                <?php endforeach ?>
        </table>
        <table class="mainTable">
            <tr>
                <td colspan="7">
                    <h2>Filtered table</h2>
                </td>
            </tr>
            <?php $products->createHeaderRow() ?>
            <?php foreach ($productsTableFiltered as $product): ?>
                <tr data-productId="<?= $product['id'] ?>" class="productRow">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <td class="productColumn"><?= $product[$i] ?></td> <!-- x6 -->
                    <?php endfor ?>
                    <td class="productColumn">
                        <button class="minus">-</button>
                        <span><?= $product['product_quantity'] ?></span>
                        <button class="plus">+</button>
                    </td>
                    <td class="productColumn">
                        <?= $product['date_create'] ?>
                        <br>
                        <button class="hideButton">Скрыть</button>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <button id="revealAllButton">Reveal hidden</button>
</body>
</html>