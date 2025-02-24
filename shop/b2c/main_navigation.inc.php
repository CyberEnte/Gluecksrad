<?php

use DC\Shop\shop\classes\PDOWrapper;

$basketActive = "";
if($_GET["shop"] ?? "" === "user_basket") {
    $basketActive = "active";
}

?>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><img src="/userdata/logo.svg"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <?php
                // Categories
                $categories = PDOWrapper::getInstance()->select("SELECT * FROM shop_category WHERE shop = :shop AND active = 1", ["shop" => $GLOBALS["shop_setup"]["id"]]);
                foreach($categories as $category) {
                    $active = "";
                    if($GLOBALS["shop_category"] !== null && $category["id"] === $GLOBALS["shop_category"]["id"]) {
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
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= $basketActive ?>" href="?shop=user_basket">Warenkorb</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-sm-2" type="search" placeholder="Suche" name="search">
                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Suche</button>
            </form>
        </div>
    </div>
</nav>