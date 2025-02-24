<?php

function show_item_list($itemArray, $type)
{

    switch ($type) {
        case 1:
            show_item_list_1($itemArray);
            break;
        case 2:
            show_item_list_2($itemArray);
            break;
    }
}

function show_item_list_1($itemArray)
{

?>
    <div class="item_list_1">
        <?php

        foreach ($itemArray as $item) {
        ?>
            <div class="card item_1" style="width: 18rem;">
                <a href="?item=<?= $item["id"] ?>"><img src="/userdata/noimage.png" class="card-img-top" alt="<?= $item["title"] ?>"></a>
                <div class="card-body d-flex flex-column justify-content-between">
                    <a href="?item=<?= $item["id"] ?>">
                        <h5 class="card-title"><?= $item["title"] ?></h5>
                        <p class="card-text"><?= $item["short_description"] ?></p>
                    </a>
                    <div>
                        <p class="card-text text-primary fs-4 mb-1">
                            <strong><?= number_format($item["base_price"], 2, ",", ".") ?> €</strong>
                        </p>
                        <form class="input-group" action="?shop=user_basket&action=add_item" method="POST">

                            <input hidden name="item_id" value="<?= $item["id"] ?>">
                            <input type="number" value="1" class="form-control" aria-label="Anzahl" name="amount">
                            <button class="btn btn-primary" type="submit">In den Warenkorb</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php
        }

        ?>
    </div>
<?php

}

function show_item_list_2($itemArray)
{

?>
    <div class="list-group item_list_2 mb-2">
        <li class="list-group-item p-2 d-flex flex-row align-items-center justify-content-between">
            <div class="d-flex flex-row align-items-center">
                <img src="/userdata/noimage.png" class="rounded me-2" alt="Artikelbild" style="visibility: hidden;">
                <span>
                    <strong>Artikel</strong><br>
                    <small>Artikelnummer</small>
                </span>
            </div>
            <div class="d-flex flex-row align-items-center" action="" method="POST">

                <span style="width: 6rem;">Stückpreis</span>
                <span class="amount-input">Anzahl</span>
                <strong style="width: 7rem;">Summe</strong>
                <button class="btn btn-secondary ms-4" style="visibility: hidden;" type="button" onclick="
                    $(this).parent('form').attr('action', '?shop=user_basket&action=update'); 
                    $(this).parent('form').submit()
                    ">Speichern</button>
                <button class="btn btn-danger ms-1" style="visibility: hidden;" type="button" onclick="
                    $(this).parent('form').attr('action', '?shop=user_basket&action=remove'); 
                    $(this).parent('form').submit()
                    ">Entfernen</button>
            </div>
        </li>
    </div>
    <div class="list-group item_list_2">
        <?php

        foreach ($itemArray as $basketLine) {
            $item = get_item_by_item_no($basketLine["item_no"]);
        ?>
            <li class="list-group-item p-2 d-flex flex-row align-items-center justify-content-between">
                <a href="?item=<?= $item["id"] ?>" class="d-flex flex-row align-items-center">
                    <img src="/userdata/noimage.png" class="rounded me-2" alt="<?= $item["title"] ?>">
                    <span>
                        <strong><?= $item["title"] ?></strong><br>
                        <small><?= $item["item_no"] ?></small>
                    </span>
                </a>
                <form class="d-flex flex-row align-items-center" action="" method="POST">
                    <input hidden name="line_id" value="<?= $basketLine["id"] ?>">

                    <span style="width: 6rem;"><?= number_format($basketLine["unit_price"], 2, ",", ".") ?> €</span>
                    <input type="number" value="<?= $basketLine["amount"] ?>" class="form-control amount-input" aria-label="Anzahl" name="amount">
                    <strong style="width: 7rem;"><?= number_format($basketLine["total_price"], 2, ",", ".") ?> €</strong>
                    <button class="btn btn-secondary ms-4" type="button" onclick="
                    $(this).parent('form').attr('action', '?shop=user_basket&action=update'); 
                    $(this).parent('form').submit()
                    ">Speichern</button>
                    <button class="btn btn-danger ms-1" type="button" onclick="
                    $(this).parent('form').attr('action', '?shop=user_basket&action=remove'); 
                    $(this).parent('form').submit()
                    ">Entfernen</button>
                </form>
            </li>
        <?php
        }

        ?>
    </div>
<?php

}
