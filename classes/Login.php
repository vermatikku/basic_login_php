<?php

class Login
{
    private $db_connection = null;
    private $user_id = null;
    private $user_is_logged_in = false;
    public $errors = array();
    public $messages = array();
    public function __construct()
    {
        session_start();
        $now = time();
        if (isset($_GET["logout"])) {
            $this->doLogout();
        } elseif (!empty($_SESSION['user_id'])) {
            $this->loginWithSessionData();
        } elseif (isset($_POST["login"])) {
            $this->loginWithPostData($_POST['user_id'], $_POST['password']);
        }
    }
    private function loginWithSessionData()
    {
        $this->user_id = $_SESSION['user_id'];
        $this->user_is_logged_in = true;
    }
    private function logOutWithSessionData()
    {
        $_SESSION = array();
        session_destroy();
        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;
    }
    private function loginWithPostData($user_id, $password)
    {
        if (empty($user_id)) {
            $this->errors[] = MESSAGE_USEREMAIL_EMPTY;
        } else if (empty($password)) {
            $this->errors[] = MESSAGE_PASSWORD_EMPTY;
        } else {
            $CommFunc = new CommonFunctions();
            $result = $CommFunc->loginFunction($user_id, $password);
            if (!isset($result->user_id)) {
                $this->errors[] = MESSAGE_LOGIN_FAILED;
            } else {
                $_SESSION['user_id'] = $result->user_id;
                $this->user_is_logged_in = true;
            }
        }
    }
    public function doLogout()
    {
        $_SESSION = array();
        session_destroy();
        $this->user_is_logged_in = false;
        $this->messages[] = MESSAGE_LOGGED_OUT;
    }
    public function isUserLoggedIn()
    {
        return $this->user_is_logged_in;
    }
}
