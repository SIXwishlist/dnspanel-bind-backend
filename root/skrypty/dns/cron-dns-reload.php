<?php


$sdir = '/root/skrypty/dns/';


chdir($sdir);


$serverVar = 'dnsRestartF10';


$db = mysqli_connect('localhost','user','password','databasename');
mysqli_query($db,'set names utf8');

$status = '';

$q = 'select `value` from `options` where `name` = "'.$serverVar.'" ';
$r = mysqli_query($db, $q);
while ($u = mysqli_fetch_assoc($r)) {

    $status = $u['value'];

}

if($status == 'pending') {

    include_once 'create-bind-files-from-db.php';

    $q = 'update `options` set `value` = "'. date('Y-m-d H:i:s') .'" where `name` = "'.$serverVar.'" ';
    $r = mysqli_query($db, $q);

}

echo 'ok';








