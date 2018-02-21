<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 24.01.18
 * Time: 11:26
 */


$domena = array();

$q = 'select * from domain where id = ' . intval($_GET['id']).' limit 0,1';
$r = mysqli_query($dbc, $q);
while ($u = mysqli_fetch_assoc($r)) {
    $domena = $u;
}


$cmd = 'host '.$domena['domena'].' ns1.studiofx.biz';

$wynik = `$cmd`;


$result['resultx'] = $wynik;
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;