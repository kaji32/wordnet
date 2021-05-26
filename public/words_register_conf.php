<?php

// ini_set('display_errors', 'On');
session_start();
if(empty($_SESSION['login'])){
    header('Location:user_login_form.php');
}
$_SESSION['word'] = [];
require_once('../common/common.php');
$count = $_POST['count'];
$listName = $_POST['listName'];
$expl = $_POST['expl'];

$words =[];
for($i=0;$i<=$count;$i+=2){
    if(empty($_POST[$i])||empty($_POST[$i+1])){
        continue;
    }
    $words[$i]['word'] = $_POST[$i];
    $words[$i]['def'] = $_POST[$i+1];
}

$dbh = dbConnect();
$dbh->beginTransaction();
try{
    $sql = 'LOCK TABLES word_list WRITE, words WRITE';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $sql = 'INSERT INTO word_list(list_name, user_id, explanation) values(?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $listName;
    $data[] = $_SESSION['login']['id'];
    $data[] = $expl;
    $stmt->execute($data);
    
    $sql = 'SELECT LAST_INSERT_ID()';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $list_code = $res['LAST_INSERT_ID()'];

foreach($words as $wor){
    $sql = 'INSERT INTO words(word_list_id, word, def) VALUES(?, ?, ?)';
    $stmt = $dbh->prepare($sql);
    $data=[];
    $data[] = $list_code;
    $data[] = $wor['word'];
    $data[] = $wor['def'];
    $stmt->execute($data);
}

$sql = 'UNLOCK TABLES';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$dbh->commit();
$dbh = null;
}catch(PDOException $e){
echo 'error!'.$e->getMessage();
$dbh->rollBack();
}

require_once('../common/parts/header.php');
?>

<h4>単語帳登録完了しました。</h4>