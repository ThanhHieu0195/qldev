<?php 
require_once "../models/trahang.php";
require_once "../models/motataikhoan.php";
require_once "../models/finance_reference.php";
require_once "../models/finance_product.php";
require_once "../models/finance_category.php";

$model_th = new trahang();
$arr_return_payment_list = $model_th->return_payment_list();


$detail_tk = new detail_tk();
$detail_tk = $detail_tk->detail_tk();

$finance_reference = new finance_reference();
$finance_reference = $finance_reference->get_list();
$finance_product = new finance_product();
$finance_product = $finance_product->get_list();
$finance_category = new finance_category();
$finance_category = $finance_category->get_list();
 ?>