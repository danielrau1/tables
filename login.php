<h1>TEACHER LOGIN</h1>
<form method="post">
    ID<input type="text" name="id"><br>
    Password<input type="text" name="password"><br>
    <input type="submit" name="bt1" value="LogIn Teacher">
    <input type="submit" name="b1" value="LogOut Teacher">
</form>


<h1>STUDENT LOGIN</h1>
<form method="post">
   Student ID <input type="text" name="idS"><br>

    <input type="submit" name="bt1S" value="LogIn Student">
    <input type="submit" name="b1S" value="LogOut Student">
</form>



<?php
if(isset($_SESSION['id'])) echo "ID: ".$_SESSION['id']." PASSWORD: ".$_SESSION['password']." CLASS: ".$_SESSION['class'];
if(isset($_POST['bt1'])) findTeacher($_POST['id'],$_POST['password']);
if(isset($_POST['bt1S'])) findStudent($_POST['idS']);


// *************************** BACK BUTTONS ********************* //
if(isset($_POST['b1'])){
    unset($_SESSION['id']);
    unset($_SESSION['password']);
    unset($_SESSION['class']);
    session_destroy();
    header('location: http://localhost/tables/welcome.php');

}
if(isset($_POST['b1S'])){
    unset($_SESSION['idStudent']);
    unset($_SESSION['nameStudent']);
    unset($_SESSION['classStudent']);
    session_destroy();
    header('location: http://localhost/tables/welcome.php');

}
/***************************************************************/



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

function findStudent($id){
    $pdo=createPdo();

    $sql = 'SELECT * FROM students WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id'=>$id]);
    $found = $stmt->fetchAll();
    if(sizeof($found)>=1){

        $_SESSION['idStudent'] =[];
        $_SESSION['nameStudent'] =[];
        $_SESSION['classStudent'] =[];


        foreach($found as $post){
            array_push($_SESSION['idStudent'],$post->id);
            array_push($_SESSION['nameStudent'],$post->name);
            array_push($_SESSION['classStudent'],$post->class);
        }

    }
    $pdo=null;
}


/************* WHEN LOGGED IN REDIRECT *****************/

if(isset($_SESSION['id'])) require('posts.php');
if(isset($_SESSION['idStudent'])) require('students.php');

/***********************************************************/
