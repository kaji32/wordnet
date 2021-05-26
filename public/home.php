<?php
ini_set('display_erros', 'On');
require_once('../common/common.php');
session_start();

$_SESSION['error'] = array();

$dbh = dbConnect();
$sql ='SELECT 
        users.ID, users.userName, 
        word_list.id, word_list.list_name, word_list.user_id, word_list.explanation, word_list.date
    FROM 
        users, word_list
    WHERE users.ID = word_list.user_id
    ORDER BY word_list.date DESC';
try{
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo '接続エラー'.$e->getMessage();
}
// var_dump($res);

require_once('../common/parts/header.php');
?>
<ul>
<?php if(empty($_SESSION['login'])):?>
<li><a href="user_register_form.php">新規登録</a></li>
<li><a href="user_login_form.php">ログイン</a></li>
<?php else: ?>
<li><a href="words_register_form.php">新規作成</a></li>
<li><a href="user_logout.php">ログアウト</a></li>
<li><a href="mypage.php">マイページへ</a></li>
<?php endif; ?>
</ul>
</header>

<div class="center">
<nav></nav>

<main>
<?php if(empty($_SESSION['login'])):?>
<h1 class="fade">
    Welcome to the Word Net!
</h1>

<h3 class="fade">
    This is the site to improve your vocabulary.
</h3>

<?php else: ?>
<a href="words_register_form.php"><h3>Let's get it started !</h3></a>
<?php endif; ?>

<?php foreach($res as $re): ?>
<div class="tweet">
<a href="view_word_list.php?id=<?php echo $re['id']; ?>">
<h4><?php echo $re['list_name'];?></h4>
<h5><?php echo $re['userName']; ?></h5>
<h5><?php echo $re['explanation']; ?></h5>
<p><?php echo $re['date']; ?></p>
</a>
</div>
<?php endforeach; ?>
</main>

<aside>
<div class="fakeArea"></div>
<footer>
<!-- <h4><a href="../public/home.php">Word Net</a></h4> -->
</footer>
</aside>
</div>




<?php 
require_once('../common/parts/footer.php');
?>