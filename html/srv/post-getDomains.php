<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 15.01.18
 * Time: 10:18
 */


$domeny = array();

$q = 'select * from domain order by domena';
$r = mysqli_query($dbc, $q);
while ($u = mysqli_fetch_assoc($r)) {

    $u['aktywna'] = intval($u['aktywna']);
    $u['onCNAME'] = intval($u['onCNAME']);
    $u['checkResult'] = intval($u['checkResult']);
    $u['id'] = intval($u['id']);

    $domeny[] = $u;

}

$result = array();
$result= $domeny;

$json = json_encode($result);
echo $json;
exit;
