<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 15.01.18
 * Time: 10:18
 */


$domeny = array();

$q = 'select * from domain where id = ' . intval($_GET['id']);
$r = mysqli_query($dbc, $q);
while ($u = mysqli_fetch_assoc($r)) {

    $u['aktywna'] = intval($u['aktywna']);
    $u['onCNAME'] = intval($u['onCNAME']);
    $u['checkResult'] = intval($u['checkResult']);


    $u['rekordMX'] = explode(';', $u['rekordMX']);
    $u['rekordNS'] = explode(';', $u['rekordNS']);


    $domeny = $u;

}

$domeny['subdomeny'] = array();

$q = 'select * from subdomain where domainID = ' . intval($domeny['id']).' order by nazwa';
$r = mysqli_query($dbc, $q);
while ($u = mysqli_fetch_assoc($r)) {

    $domeny['subdomeny'][] = $u;

}


$result = array();
$result= $domeny;

$json = json_encode($result);
echo $json;
exit;
