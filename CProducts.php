<?php


class CProducts
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=localhost;dbname=vedita_test_v2',
            'root',
            '');
    }

    public function getTable ($minPrice=null, $limit=null): ?array
    {
        $tableName = '`Products`';

        if (null === $minPrice && null === $limit){
            $sth = $this->db->query('SELECT * FROM '.$tableName.' WHERE `is_hidden` = 0 ORDER BY `DATE_CREATE` DESC, `ID` DESC;');
            return $sth ? $sth->fetchAll() : null;
        }
        $minPrice = $minPrice ? : 0;
        $limit = $limit ? " LIMIT ".$limit.';' : ";" ;
        $sth = $this->db->query('SELECT * FROM '.$tableName.' WHERE `product_price`>'.$minPrice.' AND `is_hidden` = 0 ORDER BY `DATE_CREATE` DESC,`ID` DESC'.$limit);
        return $sth ? $sth->fetchAll() : null;
    }

    public function createHeaderRow(){
        $columns = [
            'ID',
            'Product ID',
            'Name',
            'Price',
            'Article',
            'Quantity',
            'Added to DB'
        ];
        echo "<tr class=\"tableHeaderRow\">";
        foreach ($columns as $column){
            echo '<th class="columnHeader">'.$column.'</th>';
        }
        echo "</tr>";
    }

    public function hideProduct($id){
        $this->db->exec('UPDATE `products` SET `is_hidden` = 1 WHERE `id` = '.$id.';');
    }

    public function discloseHiddenProducts(){
        $this->db->exec('UPDATE `products` SET `is_hidden` = 0 WHERE `is_hidden` = 1;');
    }

    public function changeValue($change, $id){
        if ($change === 'plus'){
            $change = '+';
        } else {
            $change = '-';
        }
        $this->db->exec('UPDATE `products` SET `product_quantity` = `product_quantity`'.$change.'1 WHERE `id` = '. $id.';');
    }
}