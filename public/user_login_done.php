<?php
ini_set('display_errors', 'on');
require_once('../common/common.php');
session_start();
$_SESSION['error'] = array();


$email = h($_POST['user_email']);
$password = h($_POST['password']);
$token = h($_POST['token']);



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
    header('Location:user_login_form.php');
}

loginUser($email, $password);

require_once('../common/parts/header.php');


?>

</header>

<h2>ログイン完了しました。</h2>


<?php
require_once('../common/parts/footer.php');
?>