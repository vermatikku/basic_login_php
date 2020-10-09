<?php
require_once "classes/Constant.php";
require_once "classes/Config.php";
require_once 'classes/CommonFunction.php';
require_once 'classes/Login.php';
$CommonFunc = new CommonFunctions();
$login = new Login();
if ($login->isUserLoggedIn() == true) {
    include 'home.php';
} else {
    if (isset($_GET['FORGOT_PAGE'])) {
        include 'recover_password.php';
    } else {
        include 'login.php';
    }
}
