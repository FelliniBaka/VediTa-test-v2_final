<?php

spl_autoload_register(
    function($class) {
        include ($class . '.php');
    }
);

$products = new Cproducts();

if (isset($_POST['ajax_id'])) {
    if ((isset($_POST['change']))) {
        $products->changeValue($_POST['change'], $_POST['ajax_id']);
    } else {
        $products->hideProduct($_POST['ajax_id']);
    }
}

if (isset($_POST['revealAll'])){
    $products->discloseHiddenProducts();
}