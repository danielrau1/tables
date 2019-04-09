<h1>POSTS</h1>

<?php

echo "ID: ".$_SESSION['id']." PASSWORD: ".$_SESSION['password']." CLASS: ".$_SESSION['class'];
?>

<form method="post">
    TITLE <input type="text" name="title"><br>
    BODY<textarea name="body"></textarea>
    <input type="submit" name="bt2">
</form>


<?php





if(isset($_POST["bt2"])) insertPost($_POST['title'],$_SESSION['class'],$_POST['body']);
if(isset($_SESSION['id']) or isset($_POST['bt2'])) {

 $posts=showAll($_SESSION['class']);

    ?>

    <?php foreach ($posts as $post): ?>
        <h4><?php echo $post->title; ?></h4>
        <div>
            <u> Written by Class: <?php echo $post->class; ?></u>
        </div>
        <p style="border:1px black solid"><?php echo $post->body; ?></p>


    <?php endforeach; ?>


    <?php
}
function showAll($class){
    $pdo=createPdo();
    $sql = 'SELECT * FROM posts WHERE (class=:class)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['class'=>$class]);
    $posts = $stmt->fetchAll();
    foreach($posts as $post){
        echo $post->id.' '.$post->title.'<br>';
    }
    $pdo=null;
    return $posts;
}


function insertPost($title,$class,$body){
    $pdo=createPdo();

    $sql = 'INSERT INTO posts(title,class,body) VALUES(:title, :class, :body)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title, 'class' => $class, 'body' => $body]);


    $pdo=null;
}
