<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/config_db.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/scr/MarketDevelopModel.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/scr/userFunc.php';
use scr\BaseModel;
if(!empty($_POST['date'])){
    $te = (new MarketDevelopModel)->setProductId(1)->setDate('2021-01-01')->supplyIsSet()->getArrSupply();
    $date = $_POST['date'];
    $products = (new BaseModel)->selectQuery("products");
    $margin = 0.3;
    $completedOrders = 0;
    foreach ($products as $key=>$product){
        if($product['ID'] == 3) 
        $completedOrders = orderLeftsock(dayAmout('2021-01-14', $date));
        $prod = (new MarketDevelopModel)->setParams($product['ID'], $date, $completedOrders , $margin)->supplyIsSet();
        $remains = $prod->ProductOnDepot();
        $price = $prod->PricingProduct();
        $result[$key]['id'] = $product["ID"];
        $result[$key]['product'] = $product["Name"];
        $result[$key]['price'] = round($price , 2);
        $result[$key]['remains'] = $remains;
        $result[$key]['orders'] = $completedOrders;
    }
}
$_POST = null;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
	<header>
	<h1 class="text-3xl text-white bg-blue-300 px-4 ">"Расчет цен товара"</h1>
	</header>

    <div>
    <form method="POST">
        <div> 
            <input name="date" class="font-bold py-2 px-4 rounded"  type="date" placeholder="">
            <button name="getCell" type="submit">
                расчитать
            </button>
        </div>
        <hr>
    </form>
    </div>
<?php if(!empty($result)){ ?>
    <div class="bg-white   container mx-auto flex flex-wrap items-centerd">
        <table class ="text-2  border-2 rounded-mg">
            <tr class="">
                <th>id</th>
                <th>Наименование</th>
                <th>цена/последняя цена</th>
                <th>На складе</th>
                <th>Предварительные заказы шт.</th>
            </tr>
            <?php foreach ($result as $value): ?>
            <tr>
                <td><?= $value['id']; ?></td>
                <td><?= $value['product']; ?></td>
                <td><?= $value['price']?></td>
                <td><?= $value['remains']?></td>
                <td><?= $value['orders']?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php } ?>
</body>
</html>
