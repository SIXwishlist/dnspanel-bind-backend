<?php

$domains = array();
$cdir = '/etc/bind/M2/';
$cfile = '/etc/bind/named.conf';

$db = mysqli_connect('localhost','user','password','databasename');
mysqli_query($db,'set names utf8');

$domains = array();

$q = 'select * from domain where aktywna<>1999 order by domena';
$r = mysqli_query($db, $q);
while ($u = mysqli_fetch_assoc($r)) {


    $cmd = 'dig +trace ' . $u['domena'];
    $qqqq = `$cmd`;
    $pos = strpos($qqqq,'host.com');
    if($pos === false) {
        $pos = strpos($qqqq,'another.host.com');
    }

    $pos = intval($pos);
    if($pos!=0) $pos=1;

    echo $pos . ' - ' . $u['domena']. "\n";

    $domains[$u['id']] = $pos;

}

foreach ($domains as $k=>$v) {

    if($v==0) {
        $q = 'update domain set aktywna = 0, checkResult=0 where id = '.intval($k);
        $r = mysqli_query($db,$q);
    }
    else {
        $q = 'update domain set aktywna = 1, checkResult=1 where id = '.intval($k);
        $r = mysqli_query($db,$q);
    }


}