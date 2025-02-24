<?php

use DC\Shop\shop\classes\PDOWrapper;

function basket_add_item(&$basketHeader)
{
    $itemId = $_POST["item_id"] ?? null;
    $itemQuery = "SELECT * FROM shop_item WHERE id = :id AND active = 1 LIMIT 1";
    $itemParams = ["id" => $itemId];
    $itemResult = PDOWrapper::getInstance()->select($itemQuery, $itemParams);
    if (count($itemResult) !== 1) {
        toast("Nicht hinzugefügt", "Der Artikel existiert nicht", "danger");
    }
    $item = $itemResult[0];
    $amount = (int) $_POST["amount"];
    $price = $item["base_price"];

    // check if line for item already exists
    $basketLineQuery = "SELECT * FROM shop_user_basket_line WHERE header_id = :headerId AND item_no = :itemNo";
    $basketLineParams = [
        "headerId" => $basketHeader["id"],
        "itemNo" => $item["item_no"]
    ];
    $basketLine = PDOWrapper::getInstance()->select($basketLineQuery, $basketLineParams)[0] ?? null;

    if ($basketLine === null) {
        $insertQuery = "INSERT INTO shop_user_basket_line SET
                    header_id = :headerId,
                    item_no = :itemNo,
                    amount = :amount,
                    unit_price = :unitPrice,
                    total_price = :totalPrice";
        $insertParams = [
            "headerId" => $basketHeader["id"],
            "itemNo" => $item["item_no"],
            "amount" => $amount,
            "unitPrice" => $price,
            "totalPrice" => $price * $amount
        ];

        $insertResult = PDOWrapper::getInstance()->insert($insertQuery, $insertParams);
        if ($insertResult !== false) {
            toast("Artikel hinzugefügt", "Der Artikel {$item["item_no"]} wurde {$amount}x in den Warenkorb gelegt");
        } else {
            toast("Nicht hinzugefügt", "Datenbankfehler", "danger");
        }
    }else {
        $newAmount = $basketLine["amount"] + $amount;
        $newTotal = $basketLine["total_price"] + ($price * $amount);
        $updateQuery = "UPDATE shop_user_basket_line SET
                        amount = :amount,
                        total_price = :totalPrice
                        WHERE id = :id";
        $updateParams = [
            "id" => $basketLine["id"],
            "amount" => $newAmount,
            "totalPrice" => $newTotal
        ];
        $updateResult = PDOWrapper::getInstance()->update($updateQuery, $updateParams);
        if($updateResult) {
            toast("Artikel hinzugefügt", "Die Menge des Artikels {$item["item_no"]} wurde von {$basketLine["amount"]} auf {$newAmount} erhöht");
        }else {
            toast("Nicht hinzugefügt", "Datenbankfehler", "danger");
        }
    }

    basket_calculate_total($basketHeader);
}


function basket_update_item(&$basketHeader)
{
    $lineId = $_POST["line_id"] ?? null;
    $newAmount = (int) $_POST["amount"];

    // get line
    $basketLineQuery = "SELECT * FROM shop_user_basket_line WHERE id = :id";
    $basketLineParams = [
        "id" => $lineId
    ];
    $basketLine = PDOWrapper::getInstance()->select($basketLineQuery, $basketLineParams)[0] ?? null;

    if ($basketLine === null) {
        toast("Nicht gespeichert", "Datensatz nicht gefunden", "danger");
    }else {
        $newTotal = $basketLine["unit_price"] * $newAmount;
        $updateQuery = "UPDATE shop_user_basket_line SET
                        amount = :amount,
                        total_price = :totalPrice
                        WHERE id = :id";
        $updateParams = [
            "id" => $basketLine["id"],
            "amount" => $newAmount,
            "totalPrice" => $newTotal
        ];
        $updateResult = PDOWrapper::getInstance()->update($updateQuery, $updateParams);
        if($updateResult) {
            toast("Artikel gespeichert", "Die Menge des Artikels {$basketLine["item_no"]} wurde von {$basketLine["amount"]} auf {$newAmount} geändert");
        }else {
            toast("Nicht gespeichert", "Datenbankfehler", "danger");
        }
    }

    basket_calculate_total($basketHeader);
}

function basket_remove_item(&$basketHeader)
{
    $lineId = $_POST["line_id"] ?? null;
    
    $updateResult = PDOWrapper::getInstance()->update("DELETE FROM shop_user_basket_line WHERE id = :id", ["id" => $lineId]);
    if($updateResult) {
        toast("Artikel entfernt", "Der Artikel wurde aus dem Warenkorb entfernt");
    }else {
        toast("Nicht entfernt", "Datenbankfehler", "danger");
    }

    basket_calculate_total($basketHeader);
}

function basket_calculate_total(&$basketHeader)
{
    $updateQuery = "UPDATE shop_user_basket_header SET
                    total = COALESCE((
                        SELECT SUM(total_price) FROM shop_user_basket_line
                        WHERE header_id = :headerId
                    ), 0) WHERE id = :headerId";
    $updateParams = [
        "headerId" => $basketHeader["id"]
    ];
    PDOWrapper::getInstance()->update($updateQuery, $updateParams);
    $newTotal = PDOWrapper::getInstance()->select("SELECT total FROM shop_user_basket_header WHERE id = :id", ["id" => $basketHeader["id"]])[0]["total"];
    $basketHeader["total"] = $newTotal;
}
