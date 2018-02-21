<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 02.02.18
 * Time: 09:35
 */


$domena = mysqli_real_escape_string($dbc, trim($_GET['domena']));

$jest = 0;
$q = 'select id from domain where domena = "'.$domena.'"  ';
$r = mysqli_query($dbc, $q);
while ($u = mysqli_fetch_assoc($r)) {

    $jest = 1;
    $wynik = 'error-exist';

}


if ( $jest == 0 ) {

    $q = ' insert into domain (id,domena,klientID,dataUtworzenia,dataWygasniecia, aktywna,`type`,masters, rekordA,
          rekordMX, rekordNS, rekordCNAME, onCNAME, soaPrimary, soaEmail, soaSerial, soaRefresh, soaRetry, soaExpire,
          soaTTL, checkResult ) values ( NULL '

        . ', "'.$domena.'" '
        . ', "'.$cfgDomena['klientID'].'" '
        . ', "'.$cfgDomena['dataUtworzenia'].'" '
        . ', "'.$cfgDomena['dataWygasniecia'].'" '
        . ', '.$cfgDomena['aktywna'].' '
        . ', "'.$cfgDomena['type'].'" '
        . ', "'.$cfgDomena['masters'].'" '
        . ', "'.$cfgDomena['rekordA'].'" '
        . ', "'.$cfgDomena['rekordMX'].'" '
        . ', "'.$cfgDomena['rekordNS'].'" '
        . ', "'.$cfgDomena['rekordCNAME'].'" '
        . ', "'.$cfgDomena['onCNAME'].'" '
        . ', "'.$cfgDomena['soaPrimary'].'" '
        . ', "'.$cfgDomena['soaEmail'].'" '
        . ', "'.$cfgDomena['soaSerial'].'" '
        . ', "'.$cfgDomena['soaRefresh'].'" '
        . ', "'.$cfgDomena['soaRetry'].'" '
        . ', "'.$cfgDomena['soaExpire'].'" '
        . ', "'.$cfgDomena['soaTTL'].'" '
        . ', "'.$cfgDomena['checkResult'].'" '

        .' )';

    $r = mysqli_query($dbc, $q) or $err = mysqli_error($dbc);
    $err = $err . '<br><br>'.$q;

    $newID = mysqli_insert_id($dbc);
    $newID = intval($newID);

    if($newID!=0) {

        foreach ($cfgSubdomeny as $k=>$v) {

            $nazwa = mysqli_real_escape_string($dbc, $v['nazwa'] . '.' . $domena . '.' );

            $q = 'insert into subdomain (id, domainID, nazwa, typ, wartosc) VALUES ( NULL , '.intval($newID)

                . ', "'. $nazwa .'" '
                . ', "'. $v['typ'] .'" '
                . ', "'. $v['wartosc'] .'" '


                .')';
            $r = mysqli_query($dbc, $q);

        }

        $wynik = 'ok-created';

    } else {
        $wynik = $err;
    }




}




$result['resultx'] = $wynik;
$result['response'] = 'ok';



$json = json_encode($result);
echo $json;
exit;










