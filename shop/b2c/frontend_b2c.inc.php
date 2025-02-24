<?php

$pageInclude = "/pages/landing_page.inc.php";

if($GLOBALS["shop_category"] !== null) {
    $pageInclude = "/category/show_category.inc.php";
}else if($GLOBALS["shop_item"] !== null) {
    $pageInclude = "/item/show_item_card.inc.php";
}else if(isset($_GET["shop"])) {
    switch ($_GET["shop"]) {
        case "user_basket":
            $pageInclude = "/pages/user_basket.inc.php";
            break;
        case "checkout":
            $pageInclude = "/pages/user_order.inc.php";
            break;
        case "confirm_order":
            $pageInclude = "/pages/confirm_order.inc.php";
            break;
        case "order_done":
            $pageInclude = "/pages/order_done.inc.php";
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $GLOBALS["shop_setup"]["title"] ?></title>

    <link rel="stylesheet" href="/layout/css/bootstrap.css">
    <link rel="stylesheet" href="/layout/css/b2c.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
</head>

<body>

    <?php

    // alert
    if(!empty($GLOBALS["shop_setup"]["alert"])) {
    ?>
    <div class="container-fluid news-alert w-100 text-center">
        <span><?= $GLOBALS["shop_setup"]["alert"] ?></span>
    </div>
    <?php
    }

    ?>

    <?php include __DIR__."/main_navigation.inc.php" ?>

    <main class="container-fluid mt-4">
    <?php include __DIR__."/".$pageInclude ?>
    </main>

    <?php include __DIR__."/footer.inc.php" ?>

    <?php show_toasts() ?>

</body>

</html>