<?php

require __DIR__ . '/../vendor/autoload.php';
MercadoPago\SDK:: setAccessToken('APP_USR-1969609096585871-110110-c92e7e04539d841305e3b9b96f45732b-2959473413');

$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->id =  '0001';
$item->title = 'servicio';
$item->quantity = 1;
$item->unit_price = 150.00;
$item->currency_id = 'ARS';

$preference->items = array($item);
$preference->save();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://sdk.mercadopago.com/js/v2"></script>


</head>
<body>
    <h3>Mercado pago</h3>

    <div class='check-btn'></div>

    <script>
        const mp = new MercadoPago('APP_USR-b9d13c45-1ba3-47b5-9da2-383e3c6b988c',{
            locale: 'ar-AR'
        })

        mp.checkout({
            preference: {
                id: '<?php   echo $preference->id   ?>'
            },
            render:{
                container: '.check-btn',
                label: 'pagar con mp'
            }
        })

    </script>
    
    
</body>
</html>