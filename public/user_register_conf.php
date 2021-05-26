<?php
session_start();
$_SESSION['error'] = array();

require_once('../common/common.php');
setToken();
$name = h($_POST['user_name']);
$email = h($_POST['user_email']);
$password = h($_POST['user_password']);

if(empty($name)){
    $_SESSION['error']['name'] = '名前が記入されていません。';
}
if(empty($email)){
    $_SESSION['error']['email'] = 'メールアドレスが記入されていません。';
}
if(empty($password)){
    $_SESSION['error']['password'] = 'パスワードが記入されていません。';
}

if(!empty($_SESSION['error'])){
    header('Location:user_register_form.php');
}

require_once('../common/parts/header.php');
?>

<div class="center">
        <h4>こちらの登録内容でお間違いありませんか？</h4>
        ユーザーID：<?=$name; ?></br>
        メールアドレス：<?=$email; ?></br>
        パスワード：<?=$password; ?></br>
</div>
    <form action="user_register_done.php" method="post">
        <input type="hidden" name="user_name" value="<?=$name; ?>">
        <input type="hidden" name="user_email" value="<?=$email; ?>">
        <input type="hidden" name="user_password" value="<?=$password; ?>">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        <input type="submit" value="登録">
    </form>

<?php


require_once('../common/parts/footer.php');
?>