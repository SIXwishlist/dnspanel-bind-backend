<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 14.01.18
 * Time: 21:02
 */

session_start();

$_POST = json_decode(file_get_contents("php://input"),true);

require_once 'config.php';
$dbc = mysqli_connect($cfg['dbHost'],$cfg['dbUser'],$cfg['dbPass'],$cfg['dbName']);
mysqli_query($dbc,'set names utf8');
require_once 'auth.php';


if($auth['logged']==0) {

    $result = array();
    $result['wynik'] = 'error-auth';

    $json = json_encode($result);
    echo $json;
    exit;


}






if(isset($_POST['sh'])) {

    $sh = preg_replace('/[^a-zA-Z0-9]+/','',$_POST['sh']);

} else {

    $sh = preg_replace('/[^a-zA-Z0-9]+/','',$_GET['sh']);

}



include_once 'post-'.$sh.'.php';


$result = array();
$result['get'] = array();
foreach($_GET as $k=>$v) {
    $result['get'][$k] = $v;
}
$result['wynik'] = 'ok';

$json = json_encode($result);
echo $json;
exit;


