<?php
// ini_set('display_errors','On');
session_start();
require_once('../common/parts/header.php');
?>

<div class="form">

    <form action="user_register_conf.php" method="post">
    <h4>新規登録画面</h4>

    <?php if(isset($_SESSION['error']['token'])){
            echo '<p class="err_msg">有効なトークンが切れました。</p>';
            echo '<p class="err_msg">もう一度初めから登録を行ってください。</p>';
        }
    ?>

        ユーザー名：<input type="text" name="user_name"></br>
        <?php if(isset($_SESSION['error']['name'])){
            echo '<p class="err_msg">名前が未入力です。</p>';
        }
            ?>
        メールアドレス：<input type="email" name="user_email"></br>
        <?php if(isset($_SESSION['error']['email'])){
            echo '<p class="err_msg">メールアドレスが未入力です。</p>';
        }
            ?>
        パスワード：<input type="password" name="user_password"></br>
        <?php if(isset($_SESSION['error']['password'])){
            echo '<p class="err_msg">パスワードが未入力です。</p>';
        }
            ?>
        <input type="submit" value="次へ">
    </form>
</div>
<script src="user_form.js"></script>
<?php 
require_once('../common/parts/footer.php');
?>