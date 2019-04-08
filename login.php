<h1>TEACHER LOGIN</h1>
<form method="post">
    ID<input type="text" name="id"><br>
    Password<input type="text" name="password"><br>
    <input type="submit" name="bt1" value="LogIn">
    <input type="submit" name="b1" value="LogOut">
</form>


<?php
echo "ID: ".$_SESSION['id']." PASSWORD: ".$_SESSION['password']." CLASS: ".$_SESSION['class'];
if(isset($_POST['bt1'])) findTeacher($_POST['id'],$_POST['password']);

if(isset($_POST['b1'])){
    unset($_SESSION['id']);
    unset($_SESSION['password']);
    unset($_SESSION['class']);
    session_destroy();
    header('location: http://localhost/tables/welcome.php');

}



function createPdo()
{
    $host = 'localhost:81';
    $user = 'root';
    $password = '';
    $dbname = 'test';
    // Set DSN
    $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    return $pdo;
}

function findTeacher($id,$password){
    $pdo=createPdo();

    $sql = 'SELECT * FROM teachers WHERE (id=:id AND password=:password)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=>$id, 'password'=>$password]);
    $found = $stmt->fetchAll();
 if(sizeof($found)==1){
     print_r($found);
     foreach($found as $post){
         $_SESSION['id'] =$post->id;
         $_SESSION['password'] =$post->password;
         $_SESSION['class'] =$post->class;
     }

 }
    $pdo=null;
}

if(isset($_SESSION['id'])) require('posts.php');
