<?php
session_start();

require_once('../common/common.php');

require_once('../common/parts/header.php');
?>
</header>
<div class="form">

    <form action="user_login_conf.php" method="post">
    <h4>ログイン画面</h4>

    <?php if(!empty($_SESSION['error']['login'])){
        echo '<p class="err_msg">'.$_SESSION['error']['login'].'</p>';
    }?>

    <?php if(isset($_SESSION['error']['token'])){
            echo '<p class="err_msg">有効なトークンが切れました。</p>';
            echo '<p class="err_msg">もう一度初めから登録を行ってください。</p>';
        }
    ?>
        メールアドレス：<input type="email" name="user_email"></br>
        <?php if(isset($_SESSION['error']['email'])){
            echo '<p class="err_msg">メールアドレスが未入力です。</p>';
        }
            ?>

        <input type="submit" value="次へ">
    </form>
</div>