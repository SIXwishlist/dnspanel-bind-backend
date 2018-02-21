<?php


$domains = array();
$cdir = '/etc/bind/M2/';
$cfile = '/etc/bind/named.conf';

$tdir = '/root/skrypty/dns/bind-files/';
$sdir = '/root/skrypty/dns/';


chdir($sdir);

$db = mysqli_connect('localhost','user','password','databasename');
mysqli_query($db,'set names utf8');


mysqli_query($db, 'UPDATE `domain` SET `soaSerial` = `soaSerial` + 1') or die (mysqli_error($db));


$domains = array();

$q = 'select * from domain where aktywna=1 order by domena';
$r = mysqli_query($db, $q);
while ($u = mysqli_fetch_assoc($r)) {

    $domains[$u['id']] = $u;

}

$namedConf = file_get_contents('named.conf.tpl');

$q = 'select * from subdomain order by nazwa';
$r = mysqli_query($db, $q);
while ($u = mysqli_fetch_assoc($r)) {


    if(isset($domains[$u['domainID']])) {
        $domains[$u['domainID']]['subdomains'][$u['id']] = $u;
    }


}



$a=0;
foreach ($domains as $dk => $dv) {

    if(trim($dv['domena']) == '') continue;
    if(trim($dv['aktywna']) == 0) continue;

    $a++;
    print $a . ' | ' . $dk .  ' | domena ' . $dv['domena']. ":\n";

    // named.conf file configuration

    $ddd = file_get_contents('named.domain.conf.tpl');
    $ddd = str_replace('%domain%',$dv['domena'],$ddd);

    $namedConf .= $ddd;



    // domain zone files generation

    $domainDot = $dv['domena'] . '.';


    
    include '_zone-file-create.php';


    $fp = fopen('./bind-files/domains/'.trim($dv['domena']),'w');
    fwrite($fp,$zoneFile);
    fclose($fp);



}
echo "\n\n".'exit'."\n\n";
$fp = fopen('./bind-files/named.conf','w');
fwrite($fp,$namedConf);
fclose($fp);


$z = `cp /root/skrypty/dns/bind-files/named.conf /etc/bind/named.conf`;
$z = `rm -rf /etc/bind/auto`;
$z = `cp -r /root/skrypty/dns/bind-files/domains /etc/bind/auto `;
$z = `chown -R root:bind /etc/bind`;


$z = `cp /root/skrypty/dns/bind-files/named.conf /home/betweenservers/f10/plain/dns/named.conf`;
$z = `rm -rf /home/betweenservers/f10/plain/dns/auto`;
$z = `cp -r /root/skrypty/dns/bind-files/domains /home/betweenservers/f10/plain/dns/auto `;
$z = `chown -R betweenservers:users /home/betweenservers/f10`;

$z = `tar -cPzf /home/betweenservers/f10/packed/dns.tar.gz /home/betweenservers/f10/plain/dns/`;
$z = `chown -R betweenservers:users /home/betweenservers/f10`;

$z = `/etc/init.d/bind9 restart`;






















