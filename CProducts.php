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

    public function getTable ($filterString=null, $limit=15): ?array
    {
        $tableName = '`Products`';

        if ($filterString == null){
            $sth = $this->db->query('SELECT * FROM '.$tableName.' WHERE `is_hidden` = 0 ORDER BY `DATE_CREATE` DESC, `ID` DESC LIMIT '.$limit);
            return $sth ? $sth->fetchAll() : null;
        }

        $sth = $this->db->query('SELECT * FROM '.$tableName.' WHERE '.$filterString.' AND `is_hidden` = 0 ORDER BY `DATE_CREATE` DESC,`ID` DESC LIMIT '.$limit.';');
        return $sth->fetchAll();
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
        $this->db->query('UPDATE `products` SET `is_hidden` = 1 WHERE `id` = '.$id.';');
    }

    public function discloseHiddenProducts(){
        $this->db->query('UPDATE `products` SET `is_hidden` = 0 WHERE `is_hidden` = 1;');
    }

    public function changeValue($change, $id){
        if ($change === 'plus'){
            $change = '+';
        } else {
            $change = '-';
        }
        $this->db->query('UPDATE `products` SET `product_quantity` = `product_quantity`'.$change.'1 WHERE `id` = '. $id.';');
    }
}