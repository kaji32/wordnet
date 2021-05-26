<?php
session_start();
$_SESSION['error'] = array();

require_once('../common/common.php');
setToken();

$email = h($_POST['user_email']);



if(empty($email)){
    $_SESSION['error']['email'] = 'メールアドレスが記入されていません。';
}

if(!empty($_SESSION['error'])){
    header('Location:user_login_form.php');
}

require_once('../common/parts/header.php');
?>
</header>

<div class="form">
        <h4>パスワードを入力してください。</h4>
                
        メールアドレス：<?=$email; ?></br>
    <form action="user_login_done.php" method="post">
        <input type="password" name="password">
        <input type="hidden" name="user_email" value="<?=$email; ?>">
        <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>"><br>
        <input type="submit" value="ログイン">
    </form>

</div>


<?php


require_once('../common/parts/footer.php');
?>