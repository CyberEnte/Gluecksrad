<?php

use DC\Shop\shop\classes\PDOWrapper;
use Dotenv\Dotenv;

require_once __DIR__."/../vendor/autoload.php";

$dotenv = Dotenv::createImmutable(__DIR__."/../config");
$dotenv->load();
foreach($_ENV as $k=>$v) putenv("$k=$v");

session_start();

$GLOBALS["toasts"] = "";

require_once __DIR__."/shop_functions.inc.php";

// Load shop setup
$GLOBALS["shop_setup"] = PDOWrapper::getInstance()->select("SELECT * FROM shop_setup WHERE shop_code = :shop_code", ["shop_code" => "b2c"])[0];

// Get category
$categoryId = $_GET["category"] ?? 0;
$categoryQuery = "SELECT * FROM shop_category 
                  WHERE shop = :shop 
                  AND id = :id
                  AND active = 1
                  LIMIT 1";
$categoryParams = [
    "shop" => $GLOBALS["shop_setup"]["id"],
    "id" => $categoryId
];
$categoryResult = PDOWrapper::getInstance()->select($categoryQuery, $categoryParams);
$GLOBALS["shop_category"] = null;
if(count($categoryResult) === 1) {
    $GLOBALS["shop_category"] = $categoryResult[0];
}

// Get item
$itemId = $_GET["item"] ?? 0;
$itemQuery = "SELECT * FROM shop_item 
                  WHERE shop = :shop 
                  AND id = :id
                  AND active = 1
                  LIMIT 1";
$itemParams = [
    "shop" => $GLOBALS["shop_setup"]["id"],
    "id" => $itemId
];
$itemResult = PDOWrapper::getInstance()->select($itemQuery, $itemParams);
$GLOBALS["shop_item"] = null;
if(count($itemResult) === 1) {
    $GLOBALS["shop_item"] = $itemResult[0];
}