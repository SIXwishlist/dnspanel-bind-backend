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

$templatefile = $cfg['serverPath'] . '/named.conf.tpl';
$namedConf = file_get_contents( $templatefile);

$qx = 'select * from subdomain where domainID = '.intval($domena['id']).' order by nazwa';
$r = mysqli_query($dbc, $qx);
while ($u = mysqli_fetch_assoc($r)) {

    $domena['subdomains'][$u['id']] = $u;

}


$dv = $domena;
$zonePath = 'named.domain.zone.tpl';
$zoneFile = file_get_contents($zonePath);
include '_zone-file-create.php';


$fp = fopen('./tmp/zone.conf','w');
fwrite($fp,$zoneFile);
fclose($fp);


$rpath = realpath('./tmp/zone.conf');

$cmd = '/usr/sbin/named-checkzone -o - '.$domena['domena'].' '.$rpath.' 2>&1 ';
$wynik = `$cmd`;


$result['resultx'] = $wynik;
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;