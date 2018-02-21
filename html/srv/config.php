<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 14.01.18
 * Time: 21:02
 */


$cfg['dbUser']          = '';
$cfg['dbHost']          = '';
$cfg['dbPass']          = '';
$cfg['dbName']          = '';

$cfg['serverPath']      = '/root/skrypty/dns';


$cfgDomena = array(

    "klientID"              => 0,
    "dataUtworzenia"        => date("Y-m-d H:i:s"),
    "dataWygasniecia"       => '0000-00-00',
    "aktywna"               => 1,
    "type"                  => 'master',
    "masters"               => '',
    "rekordA"               => '1.2.3.4',
    "rekordMX"              => '0 mail.host.com.',
    'rekordNS'              => 'ns1.host.com;ns2.host.com',
    'rekordCNAME'           => '',
    'onCNAME'               => 0,
    'soaPrimary'            => 'ns1.host.com.',
    'soaEmail'              => 'admin.host.com.',
    'soaSerial'             => '2001010101',
    'soaRefresh'            => '7200',
    'soaRetry'              => '3600',
    'soaExpire'             =>  '604800',
    'soaTTL'                =>  '26400',
    'checkResult'           => 1

);


$cfgSubdomeny = array (

    "0" => array(
        'nazwa'         => 'www',
        'typ'           => 'A',
        'wartosc'       => $cfgDomena['rekordA']
    ),

    "1" => array(
        'nazwa'         => 'localhost',
        'typ'           => 'A',
        'wartosc'       => '127.0.0.1'
    ),

    "2" => array(
        'nazwa'         => 'pop3',
        'typ'           => 'CNAME',
        'wartosc'       => 'mail.host.com.'
    ),

    "3" => array(
        'nazwa'         => 'smtp',
        'typ'           => 'CNAME',
        'wartosc'       => 'mail.host.com.'
    ),

);

