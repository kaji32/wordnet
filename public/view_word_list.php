<?php
ini_set('display_errors', 'On');
session_start();
require_once('../common/common.php');
if(empty($_GET['id'])){
    header('Location:mypage.php');
}
$list_id = $_GET['id'];

$dbh = dbConnect();
try{
$sql = 'SELECT * FROM word_list JOIN users ON word_list.user_id = users.ID WHERE word_list.id = ?';
$stmt = $dbh->prepare($sql);
$data = [];
$data[] = $list_id;
$stmt->execute($data);
$res1 = $stmt->fetch(PDO::FETCH_ASSOC);
$sql = 'SELECT * FROM words WHERE word_list_id = ?';
$stmt = $dbh->prepare($sql);
$data = [];
$data[] = $list_id;
$stmt->execute($data);
$n = 1;
$table = '';
while(true){
    
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    if($res==false){
        break;
    }
    $table .= '<tr><td>'.$n.'</td><td>'.$res['word'].'</td><td>'.$res['def'].'</td></tr>';
    $n++;
}

}catch(PDOException $e){
echo '接続に問題があります。'.$e->getMessage();
}

require_once('../common/parts/header.php');
?>
</header>

<h3><?php echo $res1['list_name']?></h3>
<p><?php echo $res1['userName']?></p>
<p><?php echo $res1['explanation']?></p>
<table border="10">
<tr><th>No.</th><th>単語</th><th>意味</th></tr>
<?php echo $table; ?>
</table>
<a href="word_list_test.php?id=<?php echo $list_id; ?>">テストする</a>
<p><?php echo $res1['date']; ?></p>