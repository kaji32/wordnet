<?php
session_start();
if(empty($_SESSION['login'])){
    header('Location:user_login_form.php');
}
require_once('../common/common.php');


// var_dump($data);
require_once('../common/parts/header.php');
?>
</header>
<div class="center">

<nav></nav>

<main>
<table border="1">
    <tr>
        <th>単語帳ID</th>
        <th>単語帳名</th>
        <th>単語帳</th>
    </tr>
<?php 
$sql = 'SELECT * FROM word_list WHERE user_id=?';
$dbh = dbConnect();
try{
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $_SESSION['login']['id'];
    $stmt->execute($data);
    $num = 1;
    while(true){
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res==false){
            break;
        }

    print '<tr><td>'.$num.'</td>';
    print '<td>'.$res['list_name'].'</td>';
    print '<td>'.$res['explanation'].'</td>';
    // print '<td><a href="view_word_list.php?id='.$res['id'].'">暗記する</a></td>';
    print '<td><a href="view_word_list.php?id='.$res['id'].'">view</a></td>';
    print '<td><a href="word_list_delete.php?id='.$res['id'].'">delete</a></td>';
    print '<td><a href="word_list_download.php?id='.$res['id'].'">download</a></td>';
    print '<td><a href="word_list_test.php?id='.$res['id'].'">tests</a></td></tr>';
    $num++;

}


}catch(PDOException $e){
    echo '接続エラー'.$e->getMessage();
}

?>
</table>
</main>

<aside></aside>
</div>
<!-- <footer></footer> -->
<?php
require_once('../common/parts/footer.php');