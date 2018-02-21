<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 08.02.18
 * Time: 08:08
 */



$optionsx = array();

foreach ($_POST['options'] as $v) {



    $k2 = mysqli_real_escape_string($dbc, $v['name']);
    $v2 = mysqli_real_escape_string($dbc, $v['value']);

    $optionsx[$k2] = $v2;

}


$result = array();

$a=0;

foreach ($optionsx as $k=>$v) {

    $q = 'update options set `value` = "'.$v.'" where `name` = "'.$k.'" ';
    $r = mysqli_query($dbc, $q);

}



$result['resultx'] = 'updated ';
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;


