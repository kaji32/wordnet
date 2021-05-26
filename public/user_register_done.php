<?php
ini_set('display_errors', 'on');
require_once('../common/common.php');
session_start();
$_SESSION['error'] = array();

$name = h($_POST['user_name']);
$email = h($_POST['user_email']);
$password = h($_POST['user_password']);
$token = h($_POST['token']);

if(empty($name)){
    $_SESSION['error']['name'] = '名前が記入されていません。';
}
if(empty($email)){
    $_SESSION['error']['email'] = 'メールアドレスが記入されていません。';
}
if(empty($password)){
    $_SESSION['error']['password'] = 'パスワードが記入されていません。';
}

if(empty($token)){
    $_SESSION['error']['token'] = '不正なアクセスがありました。';
}
if(empty($_SESSION['token'])){
    $_SESSION['error']['token'] = '不正なアクセスがありました。';
}
if($token != $_SESSION['token']){
    $_SESSION['error']['token'] = '不正なアクセスがありました。';
}

if(!empty($_SESSION['error'])){
    header('Location:user_register_form.php');
}

userRegister($name, $email, $password);

require_once('../common/parts/header.php');

?>

<h2>登録完了しました。</h2>


<?php
require_once('../common/parts/footer.php');
?>