<?php

use DC\Shop\shop\classes\PDOWrapper;

require_once __DIR__ . "/../basket_functions.inc.php";

// get basket header for session
$basketHeaderQuery = "SELECT * FROM shop_user_basket_header WHERE session_id = :sessionId LIMIT 1";
$basketHeaderParams = [
    "sessionId" => session_id()
];
$basketHeader = PDOWrapper::getInstance()->select($basketHeaderQuery, $basketHeaderParams)[0] ?? null;

?>
<div class="container">
    <span class="d-block h2 mb-4">Kasse</span>

    <form class="row" action="?shop=confirm_order" method="POST">
        <div class="col-md-6 col-sm-12">
            <div class="card h-100">
                <div class="card-body">
                    <span class="d-block h4">Adresse</span>
                    <div class="mb-3">
                        <label for="salutation" class="form-label">Anrede</label>
                        <select class="form-select" id="salutation" name="salutation">
                            <option value="1">Frau</option>
                            <option value="2">Herr</option>
                            <option value="2">Person</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstName" class="form-label">Vorname *</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Nachname *</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Straße, Hausnummer *</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="postCode" class="form-label">Postleitzahl *</label>
                        <input type="text" class="form-control" id="postCode" name="postCode" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Ort *</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-Mail Adresse</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="phoneNo" class="form-label">Telefonnummer</label>
                        <input type="phone" class="form-control" id="phoneNo" name="phoneNo">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <span class="d-block h4">Versand</span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="shippingOption" id="shippingOption" value="default" checked>
                        <label class="form-check-label" for="shippingOption">
                            Standardversand (<?= number_format($GLOBALS["shop_setup"]["shipping_cost"], 2, ",", ".") ?> €)
                        </label>
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <span class="d-block h4">Zahlung</span>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentOption" id="paymentOption" value="invoice" checked>
                        <label class="form-check-label" for="paymentOption">
                            Rechnung
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentOption" id="paymentOption" value="paypal">
                        <label class="form-check-label" for="paymentOption">
                            PayPal
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="paymentOption" id="paymentOption" value="creditcard">
                        <label class="form-check-label" for="paymentOption">
                            Kreditkarte
                        </label>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
                <div class="card-body">
                    <strong class="d-block">Bestellsumme: <span class="text-primary"><?= number_format($basketHeader["total"] + $GLOBALS["shop_setup"]["shipping_cost"], 2, ",", ".") ?> €</span></strong>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="agb" required>
                        <label class="form-check-label" for="agb">
                            Ich habe die AGB und Datenschutzbestimmungen gelesen und stimme diesen zu. Durch sofortigen Versand der Waren verzichte ich auch mein 14-Tägiges Widerrufsrecht.
                        </label>
                    </div>
                    <button type="submit" class="btn btn-checkout w-100 mt-3">Bestellung kostenpflichtig abschließen</button>
                </div>
            </div>
        </div>
    </form>
</div>