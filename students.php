<h1>STUDENTS</h1>

<?php
print_r($_SESSION['idStudent']);
print_r($_SESSION['nameStudent']);
print_r($_SESSION['classStudent']);




    echo "<br>Hi ".$_SESSION['nameStudent'][0]."<br>";

for($i=0;$i<sizeof($_SESSION['classStudent']);$i++){
    $posts = showAll($_SESSION['classStudent'][$i]);
    ?>
    <?php foreach ($posts as $post): ?>
        <h4><?php echo $post->title; ?></h4>
        <div>
            <u> Written by Class: <?php echo $post->class; ?></u>
        </div>
        <p style="border:1px black solid"><?php echo $post->body; ?></p>
        <form method="post">
            POST ID <input type = "text" name="thePost"  value="<?php echo $post->id; ?>"><br>
            Class <input type = "text" name="theClass"  value="<?php echo $post->class; ?>"><br>
            SUBMISSION <input type="text" name="theSubmission"><br>
            <input type="submit" name="submission" value="Submit" >
        </form>

    <?php endforeach; ?>
    <?php
}


if(isset($_POST['submission'])){
    echo "POST ID: ".$_POST['thePost']." CLASS: ".$_POST['theClass']." SUBMISSION: ".$_POST['theSubmission'];
    insertSubmission($_POST['thePost'],$_SESSION['nameStudent'][0],$_POST['theClass'],$_POST['theSubmission']);
}



?>








<?php
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


function insertSubmission($PostID,$student,$class,$submission){
    $pdo=createPdo();

    $sql = 'INSERT INTO submissions (PostID, student, class, submission) VALUES(:PostID, :student, :class, :submission)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['PostID' => $PostID,'student'=>$student ,'class' => $class, 'submission' => $submission]);


    $pdo=null;
}
