<?php

use DC\Shop\shop\classes\PDOWrapper;

?>

<ul class="nav nav-pills flex-column">
    <?php
    // Categories
    $categories = PDOWrapper::getInstance()->select("SELECT * FROM shop_category WHERE shop = :shop AND active = 1", ["shop" => $GLOBALS["shop_setup"]["id"]]);
    foreach ($categories as $category) {
        $active = "";
        if ($GLOBALS["shop_category"] !== null && $category["id"] === $GLOBALS["shop_category"]["id"]) {
            $active = "active";
        }
        ?>
        <li class="nav-item">
            <a class="nav-link <?= $active ?>" href="?category=<?= $category["id"] ?>"><?= $category["title"] ?></a>
        </li>
    <?php
    }
    ?>
</ul>