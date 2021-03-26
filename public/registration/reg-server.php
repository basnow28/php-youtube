<?php 
session_start();

//initializing variables
$email = "";
$errors = array();

//connect to the database

$db = mysqli_connect('localhost', 'root', 'root', 'yt_users', '3330');

//registering the user
if (isset($_POST['reg_user'])) {
    $email = mysqli_real_escape_string($db, $POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

    //form validation
    if(empty($email)){
        array_push($errors, 'Email is required');
    }
    if(empty($password_1)){
        array_push($errors, 'Password is required');
    }
    if($password_1 != $password_2) {
        array_push($errors, 'Two passwords do not match');
    }

    //checking if the user already exists in the database
    $user_check_query = "SELECT * FROM users where email = '$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if($user){
        if($user['email'] == $email){
            array_push($errors, "The user with a given email already exists");
        }
    }

    //Register the user if there are no errors in the form
    if(count($errors) == 0){
        $password = md5($password_1); //encrypt the password
        $reg_query = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
        mysqli_query($db, $reg_query);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}