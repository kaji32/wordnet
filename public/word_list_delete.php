<?php
require_once('../common/common.php');
$id = $_GET['id'];

$dbh = dbConnect();
try{
    $sql = 'delete FROM words WHERE word_list_id = ?';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $id;
    $stmt->execute($data);
    $sql = 'delete FROM word_list WHERE id = ?';
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $id;
    $stmt->execute($data);
    echo '削除しました。';
}catch(PDOException $e){
    echo '接続失敗'.$e->getMessage();
}

?>