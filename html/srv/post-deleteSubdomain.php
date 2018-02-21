<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 06.02.18
 * Time: 14:22
 */




$domena = intval(trim($_GET['domenaID']));

$jest = 0;
$q = 'delete from subdomain where id = '.$domena.'  ';
$r = mysqli_query($dbc, $q);


$wynik = 'ok-deleted: '. $q;

$result['resultx'] = $wynik;
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;

