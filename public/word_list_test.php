<?php
ini_set('display', 'On');
require_once('../common/common.php');
$id = $_GET['id'];
$dbh = dbConnect();
$sql ='SELECT * FROM words WHERE word_list_id = ?';
try{
    $stmt = $dbh->prepare($sql);
    $data = [];
    $data[] = $id;
    $stmt->execute($data);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e){
    echo '接続エラー'.$e->getMessage();
}
$json = json_encode($res, JSON_UNESCAPED_UNICODE);

require_once('../common/parts/header.php');
?>
</header>
<div id="js-question"></div>

    <input type="text" id="answer">
    <button id="btn">回答</button>






<script src="test.js"></script>
<script type="text/javascript">
let json= <?php echo $json; ?>;
words=[];
json.forEach(j=>words.push({word:j['word'], question: j['def']}));

const wordsLength = words.length;

shuffle = (words)=>{
    for(let i=wordsLength-1;i>0;i--){
        var k = Math.floor(Math.random() * (i+1));
        var shuffled = words[i];
        words[i] = words[k];
        words[k] = shuffled;
    }
    return words;
}
words = shuffle(words);
console.log(words);
var wordIndex = 0;

setUpWord = ()=>{
    document.getElementById('js-question').textContent= words[wordIndex]['question'];
    document.getElementById('answer').value = '';
}
setUpWord();
let score = 0;
document.getElementById('btn').addEventListener('click', ()=>{
    let answerValue = document.getElementById('answer').value;
    
    if(answerValue === words[wordIndex]['word']){
        window.alert('正解！');
        score++;
    }else{
        window.alert('不正解！');
    }
    wordIndex++;

    if(wordIndex < wordsLength){
        setUpWord();
    }else{
         window.alert('finish!');
         document.getElementById('js-question').textContent ='あなたのスコアは'+score+'/'+wordsLength+'です！' ;
     }
    
})
</script>
