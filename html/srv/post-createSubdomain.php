<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 06.02.18
 * Time: 14:47
 */


$domena = intval(trim($_GET['domenaID']));


$wartosc = '';
$typ = '';
$nazwa = '';


$q = 'insert into subdomain (id, domainID, nazwa, typ, wartosc) VALUES ( NULL , '.intval($domena)

    . ', "'. $nazwa .'" '
    . ', "'. $typ .'" '
    . ', "'. $wartosc .'" '


    .')';
$r = mysqli_query($dbc, $q);


$wynik = 'ok-created';









$result['resultx'] = $wynik;
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;





