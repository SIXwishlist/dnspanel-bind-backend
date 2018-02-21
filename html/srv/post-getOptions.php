<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 08.02.18
 * Time: 09:19
 */



$err = '';
$options = array();

$q = 'select * from `options` ';
$r = mysqli_query($dbc, $q) or $err = mysqli_error($dbc);
while ($u = mysqli_fetch_assoc($r)) {


    $options[] = $u;

}

$result = array();
$result['agioptions'] = $options;
$result['resultx'] = 'ok' . ' '.$err;

$json = json_encode($result);
echo $json;
exit;
