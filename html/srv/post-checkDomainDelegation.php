<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 05.02.18
 * Time: 14:31
 */



$domena = array();

$q = 'select * from domain where id = ' . intval($_GET['id']).' limit 0,1';
$r = mysqli_query($dbc, $q);
while ($u = mysqli_fetch_assoc($r)) {
    $domena = $u;
}


$cmd = 'dig '.$domena['domena'].' +trace';

$wynik = `$cmd`;


$result['resultx'] = $wynik;
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;

