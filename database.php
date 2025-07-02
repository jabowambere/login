<?php
$server="localhost";
$username="root";
$password= "";
$database= "register";
$connection=mysqli_connect($server, $username, $password, $database);
if(isset($_POST['submit'])){
    $Email=$_POST['email'];
    $Role=$_POST['roles'];
    $Pass=$_POST['pass'];
    $Password=password_hash($Pass, PASSWORD_DEFAULT);
    $query="INSERT INTO authentication (email, roles, pass)VALUES('$Email', '$Role', '$Password')";
    mysqli_query($connection, $query);
    header("location: register.html");
}
if(isset($_POST['login'])){
    $Email= $_POST ['email'];
    $Pass = $_POST['pass'];
    $q="SELECT * FROM authentication WHERE email='$Email'";
    $result=mysqli_query($connection, $q);
    if(mysqli_num_rows($result)==1){
        $user=mysqli_fetch_assoc($result);
        if(PASSWORD_VERIFY($Pass, $user['pass'])){
            SESSION_START();
            $_SESSION['id']=$user['id'];
            $_SESSION['email']=$user['email'];
            header("location: dashboard.php");
        }
    }
    else{
        echo "Not Found!";
    }
}


?>
