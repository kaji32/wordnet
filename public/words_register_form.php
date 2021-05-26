<?php
ini_set('display_errors', 'On');
session_start();
// session_destroy();
require_once('./phpQuery-onefile.php');
if(!empty($_SESSION['word'])){
    $count = 2 * count($_SESSION['word']);
}else{
    $count = 0;
}


if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!empty($_GET['word'])){
        $word = $_GET['word'];
    }else{
        $word = '';
    }
    
    if(!empty($word) && $_SESSION['lastword'] != $word){
        $html = file_get_contents("https://ejje.weblio.jp/content/".$word."?erl=true");
        $def = phpQuery::newDocument($html)->find("td.content-explanation")->text();
        $_SESSION['word'][] = '<input name="'.$count.'" value="'.$word.'" style="margin:15px"><input type="text" name="'.($count+1).'" value="'.$def.'" style="margin:15px" maxlength="100"><br>';
    }
    if(!empty($_SESSION['word'])){
        $word_array = array_reverse($_SESSION['word']);
    }

$_SESSION['lastword'] = $word;
}
require_once('../common/parts/header.php');
?>
</header>

<div class="center">
<nav></nav>
<main>
<h4>単語を検索</h4>
<form action="words_register_form.php" method="GET">
<input type="text" name="word">
<input type="submit" value="検索">
</form>


<div class="form">
<form action="words_register_conf.php" method="POST">
<h5>リスト名</h5>
    <input type="text" name="listName" class="word"><br>
    <h5>概要文</h5>
    <textarea name="expl" id="" cols="75" rows="5" placeholder="単語帳の説明を書いてね"></textarea><br>
<?php if(!empty($word_array)): ?>
<?php foreach($word_array as $words): ?>
<?php echo $words; ?>
<?php endforeach;?>
<?php endif; ?>
<input type="hidden" name="count" value="<?php echo $count; ?>">
<input type="submit" value="次へ">
</form>
</div>
</main>
<aside></aside>
</div>

<script src="../common/config/words.js"></script> 
<?php
require_once('../common/parts/footer.php');
?>