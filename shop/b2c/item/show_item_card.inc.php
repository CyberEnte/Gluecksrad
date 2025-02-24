<?php

$item = $GLOBALS["shop_item"] ?? [];

?>

<div class="container ms-5 me-5">
    <div class="row">
        <div class="col-md-5 col-sm-12">
            <img src="/userdata/noimage.png" class="img-fluid rounded" alt="<?= $item["title"] ?>">
        </div>
        <div class="col-md-7 col-sm-12 d-flex flex-column justify-content-between">
            <div>
                <span class="h2"><?= $item["title"] ?></span><br>
                <span class="h5"><?= $item["short_description"] ?></span>
            </div>

            <div class="card w-50">
                <div class="card-body">
                    <strong class="fs-2"><?= number_format($item["base_price"], 2, ",", ".") ?> €</strong>
                    <span class="text-success d-block mb-3">Verfügbar</span>

                    <form class="d-flex flex-row" action="?shop=user_basket&action=add_item" method="POST">
                        <input hidden name="item_id" value="<?= $item["id"] ?>">
                        <input type="number" value="1" class="form-control amount-input" aria-label="Anzahl" name="amount">
                        <button class="btn btn-primary w-100" type="submit">In den Warenkorb</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    if(!empty($item["long_description"])) {
    ?>
    <div class="mt-5">
        <span class="h4">Beschreibung</span>
        <p>
        <?= $item["long_description"] ?>
        </p>
    </div>
    <?php
    }
    ?>

</div>