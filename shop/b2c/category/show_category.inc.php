<?php

use DC\Shop\shop\classes\PDOWrapper;

require_once __DIR__."/../item/show_item_list.inc.php";

?>

<div class="row">
    <div class="col-md-2 col-sm-12">
        <?php include __DIR__."/../side_navigation.inc.php" ?>
    </div>
    <div class="col-md-10 col-sm-12">
        <span class="h2"><?= $GLOBALS["shop_category"]["title"] ?></span>
        <p>
            <?= $GLOBALS["shop_category"]["short_description"] ?>
        </p>

        <?php
        // Get items
        
        $itemsQuery = "SELECT shop_item.* FROM shop_item
                       INNER JOIN shop_item_category 
                       ON shop_item_category.shop_item = shop_item.id
                       AND shop_item_category.shop_category = :category
                       WHERE shop_item.active = 1";
        $itemsParams = [
            "category" => $GLOBALS["shop_category"]["id"]
        ];
        $itemsResult = PDOWrapper::getInstance()->select($itemsQuery, $itemsParams);

        show_item_list($itemsResult, 1);

        ?>

    </div>
</div>