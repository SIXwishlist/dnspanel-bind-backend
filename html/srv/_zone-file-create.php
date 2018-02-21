<?php


$zoneFile = str_replace('%domain%',$dv['domena'],$zoneFile);
$zoneFile = str_replace('%soaPrimary%',$dv['soaPrimary'],$zoneFile);
$zoneFile = str_replace('%soaEmail%',$dv['soaEmail'],$zoneFile);
$zoneFile = str_replace('%soaSerial%',$dv['soaSerial'],$zoneFile);
$zoneFile = str_replace('%soaRefresh%',$dv['soaRefresh'],$zoneFile);
$zoneFile = str_replace('%soaRetry%',$dv['soaRetry'],$zoneFile);
$zoneFile = str_replace('%soaExpire%',$dv['soaExpire'],$zoneFile);
$zoneFile = str_replace('%soaTTL%',$dv['soaTTL'],$zoneFile);

$zoneFile .= "\n";

$ns = explode(';',$dv['rekordNS']);

foreach ($ns as $nsk=>$nsv) {
    if(trim($nsv)!='') {
        $zoneFile .= "\n\t\t" . 'NS' . "\t" . trim($nsv);
    }
}


if(intval($dv['onCNAME'])==1) {

    if(trim($dv['rekordCNAME'])!='') {
        $zoneFile .= "\n\t\t" . 'CNAME' . "\t" . trim($dv['rekordCNAME']);
    }


}
else {

    if(trim($dv['rekordA'])!='') {
        $zoneFile .= "\n\t\t" . 'A' . "\t" . trim($dv['rekordA']);
    }

    $mx = explode(';',$dv['rekordMX']);

    foreach ($mx as $msk=>$msv) {
        if(trim($msv)!='') {
            $zoneFile .= "\n\t\t" . 'MX ' . "\t" . trim($msv);
        }

    }


}




$zoneFile .= "\n";



if(isset($dv['subdomains'])) {


    foreach ($dv['subdomains'] as $sk => $sv) {

        $zoneFile .= "\n" .$sv['nazwa'] . "\t" . " " . $sv['typ']."\t\t".trim($sv['wartosc']);


    }
}


$zoneFile .= "\n";