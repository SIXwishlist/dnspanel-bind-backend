<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 16.01.18
 * Time: 20:01
 */

$result = array();

$a=0;
$q = 'update domain set ';
foreach ($_POST['domena'] as $k=>$v) {

    if($k=='id') continue;
    if($k=='subdomeny') continue;

    if($k=='rekordMX' || $k=='rekordNS') {

        $ab=0;
        $vz = '';
        foreach ($v as $kk=>$vv) {
            $ab++;
            if($ab>1) $vz .= ';';
            $vz .= $vv;
        }
        $v = $vz;

    }

    $a++;
    if($a>1) {
        $q .= ', ';
    }
    $q.= mysqli_real_escape_string($dbc, $k) . ' = ';
    $q.= '"' . mysqli_real_escape_string($dbc, $v) . '" ';

}


$q.= ' where id = ' . intval($_POST['domena']['id']);
$r = mysqli_query($dbc, $q);


$q = 'delete from subdomain where domainID = '. intval($_POST['domena']['id']);
$r = mysqli_query($dbc, $q);

$domena = intval($_POST['domena']['id']);
foreach ($_POST['domena']['subdomeny'] as $k=>$v) {

    $nazwa = mysqli_real_escape_string($dbc, $v['nazwa']);
    $typ = mysqli_real_escape_string($dbc, $v['typ']);
    $wartosc = mysqli_real_escape_string($dbc, $v['wartosc']);

    $q = 'insert into subdomain (id, domainID, nazwa, typ, wartosc) VALUES ( NULL , '.intval($domena)

        . ', "'. $nazwa .'" '
        . ', "'. $typ .'" '
        . ', "'. $wartosc .'" '


        .')';
    $r = mysqli_query($dbc, $q);


}





// $result['q'] = $q;
$result['domena'] = $_POST['domena'];
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;






