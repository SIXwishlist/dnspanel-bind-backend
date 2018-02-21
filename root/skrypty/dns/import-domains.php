<?php

$domains = array();
$cdir = '/etc/bind/M2/';
$cfile = '/etc/bind/named.conf';

$db = mysqli_connect('localhost','user','password','databasename');
mysqli_query($db,'set names utf8');

//exit;

$fx = file($cfile);

$nazwa = "";
$a=0;
$nextzone=0;
foreach ($fx as $k=>$v) {



    $v = trim ($v);
    if(substr($v,0,2) == '//') continue;
    if(substr($v,0,4)=='zone') {
        $nazwa = substr($v,strpos($v,'"')+1);
        $nazwa = substr($nazwa,0,strpos($nazwa,'"'));
        if(substr($nazwa,-1)=='.') $nazwa = substr($nazwa,0,-1);

        if(substr($nazwa,-5)=='.arpa' or $nazwa=='localhost' or $nazwa == 'localhost2') {
            $nextzone=1;
            $nazwa="";
            continue;
        }

        $nextzone=0;

        $domains[$nazwa] = array();
        $domains[$nazwa]['nazwa'] = $nazwa;
        $domains[$nazwa]['lp'] = $a;
        $domains[$nazwa]['masters'] = "";
        $a++;
    }
    else if($nextzone==1) {
        continue;
    }

    if($nazwa=='') {
        $nextzone=1;
        continue;
    }



    if (substr($v,0,4)=='type') {
        $typ = substr($v,4);
        $typ = trim ( str_replace(';','',$typ));
        $domains[$nazwa]['typ'] = $typ;
    }

    if (substr($v,0,4)=='file') {
        $file = substr($v,4);
        $file = trim ( str_replace(';','',$file));
        $file = trim ( str_replace('"','',$file));
        $domains[$nazwa]['file'] = $file;
    }

    if (substr($v,0,7)=='masters') {
        $masters = substr($v,7);
        $masters = trim ( str_replace('"','',$masters));
        $masters = trim ( str_replace('{','',$masters));
        $masters = trim ( str_replace('}','',$masters));
        $domains[$nazwa]['masters'] = $masters;
    }




}

foreach ($domains as $k=>$v) {
    if($v['masters']!='') continue;
    $ddd = file($v['file']);

    $origin = '';
    $soaStart = 0;
    $soaNum = 0;
    foreach ($ddd as $kk=>$vv) {

        $vv2 = $vv;
        $vv = trim($vv);
        if(substr($vv,0,7)=='$ORIGIN') {
            $origin = substr($vv,7);
            $pos = strpos($ttl,';');
            if($pos!==false) {
                $origin = substr($origin,0,$pos);
            }
            $origin = trim($origin);

        }


        else if(substr($vv,0,4)=='$TTL') {
            $ttl = substr($vv,4);
            $pos = strpos($ttl,';');
            if($pos!==false) {
                $ttl = substr($ttl,0,$pos);
            }
            $ttl = trim($ttl);
            $domains[$k]['ttl'] = $ttl;
        }

        else {

            if (trim ($vv)=='') continue;

            $pos = strpos($vv,';');
            if($pos!==false) {
                $vv = substr($vv,0,$pos);
            }

            $vv = trim($vv);

            $parts = preg_split('/\s+/', $vv);
            $domainx = $parts[0] . $origin;

            if($parts[1]=='IN' && $parts[2]=='SOA') {
                $domains[$k]['soaPrimary'] = $parts[3];
                $domains[$k]['soaEmail'] = $parts[4];
                $soaStart = 1;
            }
            else if($soaStart==1) {
                if($parts[0]==')') {
                    $soaStart=0;
                    $soaNum=0;
                } else {
                    $soaname = 'soa' . $soaNum;
                    $domains[$k][$soaname] = $parts[0];
                    $soaNum++;
                }
            }
            else {


                $pos = strpos($vv2,';');
                if($pos!==false) {
                    $vv2 = substr($vv2,0,$pos);
                }
                $parts = preg_split('/\s+/', $vv2,3);

                if($parts[0]=='') {
                    if($parts[1]=='NS') {
                        $domains[$k]['NS'][] = $parts[2];
                    }
                    else if($parts[1]=='A') {
                        $domains[$k]['A'] = $parts[2];
                    }
                    else if($parts[1]=='MX') {
                        $domains[$k]['MX'][] = $parts[2].' '.$parts[3];
                    }
                    else {
                        $domains[$k][trim($parts[1])] = $parts[2].' '.$parts[3];
                    }

                }
                else {

                    $subdomain = $parts[0] . '.' . $origin;
                    if($parts[1]=='MX') {
                        $domains[$k]['subdomains'][$subdomain]['MX'][] = $parts[2] . ' ' . $parts[3];
                    }

                    else if($parts[1]=='CNAME') {
                        $domains[$k]['subdomains'][$subdomain]['CNAME'] = $parts[2];
                    }


                    else {
                        $domains[$k]['subdomains'][$subdomain][$parts[1]] = $parts[2];
                    }


                }

            }

            //$domains[$k]['records'] = $vv;

        }



    }



}

foreach ($domains as $k=>$v) {

    $mx = "";
    $a=0;
    foreach ($v['MX'] as $vv) {
        $a++;
        if($a>1) $mx .= ';';
        $mx .= $vv;
    }

    $ns = "";
    $a=0;
    foreach ($v['NS'] as $vv) {
        $a++;
        if($a>1) $ns .= ';';
        $ns .= $vv;
    }

    $q = 'insert into domain (id, domena, klientID, dataUtworzenia, dataWygasniecia, aktywna, type, masters,
    rekordA, rekordMX, rekordNS, rekordCNAME,onCNAME,soaPrimary, soaEmail,soaSerial,soaRefresh,soaRetry,
    soaExpire, soaTTL
    ) values (NULL
    
    ,"'.$v['nazwa'].'"
    ,"0"
    ,"'.date('Y-m-d H:i:s').'"
    ,"'.date('0000-00-00').'"
    ,"1"
    ,"'.$v['typ'].'"
    ,"'.$v['masters'].'"
    ,"'.$v['A'].'"
    ,"'.$mx.'"
    ,"'.$ns.'"
    ,"",0
    ,"'.$v['soaPrimary'].'"
    ,"'.$v['soaEmail'].'"
    ,"'.$v['soa0'].'"
    ,"'.$v['soa1'].'"
    ,"'.$v['soa2'].'"
    ,"'.$v['soa3'].'"
    ,"'.$v['soa4'].'"

    )';

    $r = mysqli_query($db,$q);
    $lastid = mysqli_insert_id($db);

    foreach ($v['subdomains'] as $kk=>$vv) {

        foreach ($vv as $kx => $vx) {

            $q = 'insert into subdomain (id,domainID,nazwa,typ,wartosc) values(NULL
            ,"'.$lastid.'"
            ,"'.$kk.'"
            ,"'.$kx.'"
            ,"'.$vx.'"
            
            )';
            $r = mysqli_query($db,$q);


        }

    }


}


print_r($domains);

