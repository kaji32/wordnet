<?php
ini_set('display_errors', 'On');
require_once('../common/common.php');
if(empty($_GET['id'])){
    header('Location:mypage.php');
}
$id = $_GET['id'];

$sql = 'SELECT * FROM words WHERE word_list_id=?';
$dbh = dbConnect();
try{
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $id;
    $stmt->execute($data);
    $num = 1;
    $csv = 'No.,単語,意味';
    $csv .= "\n";
    while(true){
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res==false){
            break;
        }

        $csv .= $num;
        $csv .= ',';
        $csv .= $res['word'];
        $csv .= ',';
        $csv .= $res['def'];
        $csv .= "\n";
        $num++;
    }

    $file = fopen('./words.csv', 'w');
    $csv = mb_convert_encoding($csv, 'SJIS', 'UTF-8');
    fputs($file, $csv);
    fclose($file);
}catch(PDOException $e){
    echo '接続エラー'.$e->getMessage();
}


?>

<a href="words.csv">単語帳をダウンロード</a>