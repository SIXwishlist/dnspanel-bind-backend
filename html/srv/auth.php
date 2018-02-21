<?php
/**
 * Created by PhpStorm.
 * User: win10
 * Date: 19.01.18
 * Time: 07:47
 */

$auth = array();
$auth['logged'] = 0;
$auth['admin'] = 0;



if ($_POST['sh'] == 'sprawdzlogowanie') {

    $ok = 0;
    if ( isset($_SESSION['auth']['logged'])) {
        if($_SESSION['auth']['logged']>0) {
            $ok = 1;
        }
    }

    if ($ok==0) {
        $result['wynik'] = 'false';
    }
    else {
        $result['wynik'] = 'ok';
    }


    $result['auth'] = [];
    $result['comment'] = 'logout success';
    $json = json_encode($result);
    echo $json;
    exit;


}


if($_POST['sh'] == 'wyloguj') {

    $_SESSION = array();
    session_destroy();

    $result['wynik'] = 'ok';
    $result['auth'] = [];
    $result['comment'] = 'logout success';
    $json = json_encode($result);
    echo $json;
    exit;

}


if ( $_POST['sh'] == 'zaloguj' ) {

    $ok=0;

    $username = mysqli_real_escape_string($dbc, $_POST['username']);
    $password = mysqli_real_escape_string($dbc, $_POST['password']);

    $q = 'select * from user where 
          `username` = "'.$username.'" 
          and `password` = "'.$password.'" 
          limit 0,1 ';
    $r = mysqli_query($dbc, $q);
    while ($u = mysqli_fetch_assoc($r)) {

        $auth['logged'] = $u['id'];
        $auth['admin'] = $u['isadmin'];

        $_SESSION['auth'] = $auth;

        $ok=1;

    }

    if($ok==1) {

        $result['wynik'] = 'ok';
        $result['auth'] = $auth;
        $result['comment'] = '-';
        $json = json_encode($result);
        echo $json;
        exit;

    }
    else {

        $result['wynik'] = 'error';
        $result['auth'] = array();
        $result['comment'] = $q;
        $json = json_encode($result);
        echo $json;
        exit;
    }


}
else {

    $auth = $_SESSION['auth'];

}