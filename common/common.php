<?php

function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function setToken(){
    if(!isset($_SESSION['token'])){
        $token = bin2hex(random_bytes(32));
        return $_SESSION['token'] = $token;
        
    }
}

function dbConnect(){
    $dsn="mysql:host=localhost;dbname=;utf-8";
    $user="";
    $pass="";

    try{
        $dbh = new PDO($dsn, $user, $pass,[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }catch(PDOException $e){
        echo '接続エラー'.$e->getMessage();
        exit();
    }
    return $dbh;
}

function userRegister($name, $email, $password){
    $dbh = dbConnect();
    $sql = "INSERT INTO users(userName, email, password) VALUES(?, ?, ?)";
    $dbh->beginTransaction();
    try{
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $name;
    $data[] = $email;
    $data[] = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute($data);
    $dbh->commit();
    $_SESSION['error'] = $array();
    // echo '登録完了しました。';
    }catch(PDOException $e){
    echo '接続エラー'.$e->getMessage();
    $dbh->rollBack();
    exit();
    }
}

function loginUser($email, $password){
    $dbh = dbConnect();
    $sql = "SELECT * FROM users WHERE email=?";
    $dbh->beginTransaction();
    try{
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $email;
    $stmt->execute($data);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $dbh->commit();
    // var_dump(password_hash($password, PASSWORD_DEFAULT));
    if(password_verify($password, $user['password'])){
        $_SESSION['login']['name'] = $user['userName'];
        $_SESSION['login']['id'] = $user['ID'];
        $_SESSION['error'] = array();
        return;
    }else{
        $_SESSION['error']['login'] = 'メールアドレスもしくはパスワードが正しくありません。';
        header('Location:../public/user_login_form.php');
    }
    
    }catch(PDOException $e){
    echo '接続エラー'.$e->getMessage();
    $dbh->rollBack();
    exit();
 
    }
}

?>
