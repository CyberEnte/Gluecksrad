<?php

use DC\Shop\shop\classes\PDOWrapper;


// get basket
$basketHeaderQuery = "SELECT * FROM shop_user_basket_header WHERE session_id = :sessionId LIMIT 1";
$basketHeaderParams = [
    "sessionId" => session_id()
];
$basketHeader = PDOWrapper::getInstance()->select($basketHeaderQuery, $basketHeaderParams)[0] ?? null;
$basketLines = PDOWrapper::getInstance()->select("SELECT * FROM shop_user_basket_line WHERE header_id = :headerId", ["headerId" => $basketHeader["id"]]);

$total = $basketHeader["total"];
$total += $GLOBALS["shop_setup"]["shipping_cost"];

$orderNo = get_new_order_no();

$salesHeaderQuery = "INSERT INTO shop_sales_header SET
                     shop = :shop,
                     order_no = :orderNo,
                     total = :total,
                     salutation = :salutation,
                     first_name = :firstName,
                     last_name = :lastName,
                     address = :address,
                     post_code = :postCode,
                     city = :city,
                     email = :email,
                     phone_no = :phoneNo,
                     shipping_option = :shippingOption,
                     payment_option = :paymentOption,
                     order_date = CURRENT_TIMESTAMP(),
                     success = 1,
                     update_insert = 1";
$salesHeaderParams = [
    "shop" => $GLOBALS["shop_setup"]["id"],
    "orderNo" => $orderNo,
    "total" => $total,
    "salutation" => $_POST["salutation"],
    "firstName" => $_POST["firstName"],
    "lastName" => $_POST["lastName"],
    "address" => $_POST["address"],
    "postCode" => $_POST["postCode"],
    "city" => $_POST["city"],
    "email" => $_POST["email"] ?? "",
    "phoneNo" => $_POST["phoneNo"] ?? "",
    "shippingOption" => $_POST["shippingOption"] ?? "",
    "paymentOption" => $_POST["paymentOption"] ?? ""
];

$salesHeaderId = PDOWrapper::getInstance()->insert($salesHeaderQuery, $salesHeaderParams);

// insert sales lines
foreach($basketLines as $basketLine) {
    $salesLineQuery = "INSERT INTO shop_sales_line SET
                       header_id = :headerId,
                       item_no = :itemNo,
                       amount = :amount,
                       unit_price = :unitPrice,
                       total_price = :totalPrice,
                       update_insert = 1";
    $salesLineParams = [
        "headerId" => $salesHeaderId,
        "itemNo" => $basketLine["item_no"],
        "amount" => $basketLine["amount"],
        "unitPrice" => $basketLine["unit_price"],
        "totalPrice" => $basketLine["total_price"]
    ];
    PDOWrapper::getInstance()->insert($salesLineQuery, $salesLineParams);
}

// reset basket
PDOWrapper::getInstance()->update("DELETE FROM shop_user_basket_line WHERE header_id = :headerId", ["headerId" => $basketHeader["id"]]);
PDOWrapper::getInstance()->update("DELETE FROM shop_user_basket_header WHERE id = :id", ["id" => $basketHeader["id"]]);

?>

<script>
    window.location.replace("/?shop=order_done&order_no=<?= $orderNo ?>");
</script>