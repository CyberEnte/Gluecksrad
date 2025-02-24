<?php

use DC\Shop\shop\classes\PDOWrapper;

function toast($title, $message, $type = "info")
{
    ob_start();
?>
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header text-<?=$type?>">
            <strong class="me-auto"><?= $title ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?= $message ?>
        </div>
    </div>
<?php
    $toastContent = ob_get_clean();
    $GLOBALS["toasts"] .= $toastContent;
}

function show_toasts()
{
?>
    <div class="toast-container bottom-fixed bottom-0 end-0 p-3">
        <?= $GLOBALS["toasts"] ?>
    </div>

    <script>
        $(document).ready(() => $('.toast').toast('show'));
    </script>
<?
}

function get_item_by_item_no($item_no) {
    return PDOWrapper::getInstance()->select("SELECT * FROM shop_item WHERE item_no = :itemNo", ["itemNo" => $item_no])[0] ?? null;
}

function get_new_order_no() {
    $suffix = date("Y");
    $latest = PDOWrapper::getInstance()->select("SELECT order_no FROM shop_sales_header WHERE order_no LIKE '%$suffix' ORDER BY order_no DESC")[0] ?? [];
    $latest = (int)substr($latest["order_no"] ?? "0$suffix", 0, strlen($latest["order_no"] ?? "0$suffix")-4);
    $orderNo = ($latest + 1) . $suffix;
    return $orderNo;
}