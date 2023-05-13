<?php
require_once 'user.php';
$username = "";
$email = "";
$password = "";
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if(isset($_POST['email'])){

    $email = $_POST['email'];

}
if(isset($_POST['password'])){

    $password = $_POST['password'];

}
$myUser = new User();
if (!empty($username)&&!empty($email)&&!empty($password)) {
    $hashed_password = md5($password);
    $json_registration = $myUser->createNewRegisterUser($username, $email, $hashed_password);
    echo json_encode($json_registration);
}
if(empty($username) && !empty($password) && !empty($email)){

    $hashed_password = md5($password);

    $json_array = $myUser->loginUsers($email, $hashed_password);

    echo json_encode($json_array);
}