<?php

use DC\Shop\shop\classes\PDOWrapper;

require_once __DIR__ . "/../item/show_item_list.inc.php";
require_once __DIR__ . "/../basket_functions.inc.php";

// get basket header for session
$basketHeaderQuery = "SELECT * FROM shop_user_basket_header WHERE session_id = :sessionId LIMIT 1";
$basketHeaderParams = [
    "sessionId" => session_id()
];
$basketHeader = PDOWrapper::getInstance()->select($basketHeaderQuery, $basketHeaderParams)[0] ?? null;
if ($basketHeader === null) {
    // create new basket header
    $basketHeaderInsertQuery = "INSERT INTO shop_user_basket_header SET session_id = :sessionId, total = 0";
    $newId = PDOWrapper::getInstance()->insert($basketHeaderInsertQuery, $basketHeaderParams);
    $basketHeader = PDOWrapper::getInstance()->select("SELECT * FROM shop_user_basket_header WHERE id = :id LIMIT 1", ["id" => $newId])[0];
}

// handle basket actions
switch ($_GET["action"] ?? "") {
    case "add_item":
        basket_add_item($basketHeader);
        break;
    case "update":
        basket_update_item($basketHeader);
        break;
    case "remove":
        basket_remove_item($basketHeader);
        break;
}

// load basket
$basketLines = PDOWrapper::getInstance()->select("SELECT * FROM shop_user_basket_line WHERE header_id = :headerId", ["headerId" => $basketHeader["id"]]);

?>

<div class="container">
    <span class="d-block h2 mb-4">Dein Warenkorb</span>

    <?php
    if (empty($basketLines)) {
    ?>
        <div class="alert alert-info" role="alert">
            <strong>Dein Warenkorb ist noch leer!</strong><br>
            Artikel, die du in den Warenkorb legst, werden hier angezeigt.
        </div>
    <?php
    } else {
        show_item_list($basketLines, 2);
    ?>

        <div class="d-flex flex-row justify-content-end mt-2">
            <div class="card">
                <div class="card-body text-end">
                    <table class="mb-3">
                        <tr>
                            <td class="pe-4"><strong>Warenwert:</strong></td>
                            <td><?= number_format($basketHeader["total"], 2, ",", ".") ?> €</td>
                        </tr>
                        <tr class="border-bottom">
                            <td class="pe-4">Versandkosten:</td>
                            <td><?= number_format($GLOBALS["shop_setup"]["shipping_cost"], 2, ",", ".") ?> €</td>
                        </tr>                        
                        <tr>
                            <td class="pe-4"><strong>Summe:</strong></td>
                            <td><strong><?= number_format($basketHeader["total"] + $GLOBALS["shop_setup"]["shipping_cost"], 2, ",", ".") ?> €</strong></td>
                        </tr>
                    </table>
                    <a class="btn btn-primary" href="?shop=checkout">Zur Kasse</a>
                </div>
            </div>
        </div>

    <?php
    }
    ?>

</div>