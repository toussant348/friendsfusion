<?php
$connection_string = "mysql:host=localhost; dbname=test_friendsfusion_db";
$user ="toussant348";
$password = "pinkpanther348"; 
$connection = null;
$user_details = NULL;

function connectionTester(){
    global $connection_string, $user, $password, $connection;
    try{
        $connection = new PDO($connection_string, $user, $password);
    }catch(PDOException $err){
        return $err->getCode();
    }    
    return 0;
}

function createDatabaseStructure(){  
    global $user, $password, $connection;
    $sql= "CREATE DATABASE test_friendsfusion_db;";
    $sql_user_accounts = "CREATE TABLE USER_ACCOUNTS(
                            user_username VARCHAR(20) NOT NULL,
                            user_password VARCHAR(15) NOT NULL,
                            user_first_name VARCHAR(20) NOT NULL,
                            user_last_name VARCHAR(20) NOT NULL,
                            user_email VARCHAR(20) NOT NULL,
                            user_dob_d INT NOT NULL,
                            user_dob_m INT NOT NULL,
                            user_dob_y INT NOT NULL,
                            PRIMARY KEY(user_username));";
    $sql_blogs = "CREATE TABLE BLOGS(
                            blog_id VARCHAR(200) NOT NULL,
                            blog_caption VARCHAR(200) NOT NULL,
                            blog_pic_location VARCHAR(200),
                            PRIMARY KEY(blog_id));";
    $sql_blog_comments = "CREATE TABLE BLOG_COMMENTS(
                            comment_blog_id VARCHAR(200) NOT NULL,
                            comment_text VARCHAR(200) NOT NULL,
                            comment_user_who_posted VARCHAR(200),
                            PRIMARY KEY(comment_blog_id));";
    $sql_pictures = "CREATE TABLE PICTURES(
                        pictures_id VARCHAR(200) NOT NULL,
                        picture_location VARCHAR(500) NOT NULL,
                        PRIMARY KEY(pictures_id));";
    $connection_string = "mysql:host=localhost;";
    //Just Connect to the database without linking it to a database
    try{ 
        $connection = new PDO($connection_string, $user, $password);
        $connection->exec($sql);
        //Test Back the connection for the database
        connectionTester();
    }catch(PDOException $err){ 
        include('C:\xampp\htdocs\FriendsFusion\Data\html\fail_database_connection.html');
        die("Fatal Error while attempting Fix");
    }
    $connection->exec($sql_user_accounts);
    $connection->exec($sql_blogs);
    $connection->exec($sql_blog_comments);
    $connection->exec($sql_pictures);
} 

function databaseErrorHandler($errorCode){  
    if($errorCode == 2002){
        include('C:\xampp\htdocs\FriendsFusion\Data\html\fail_database_connection.html');
        die();
    } else if($errorCode == 1049){
        createDatabaseStructure();
    }
}

function queryUserVerification(){
    global $connection, $user_details;
    $sql = "SELECT *
            FROM USER_ACCOUNTS 
            WHERE user_username = :username AND user_password = :password";
    $result = $connection->prepare($sql);
    $result->execute(array(':username' => $_POST['username'], ':password' => $_POST['password']));
    $user_details = $result->fetchAll(PDO::FETCH_CLASS);
    if(!$user_details){
        /*************Develope a different page to test login**************/
        print("<h1> User Not Present </h1>");
        /******************************************************************/
    }
}

function userPage(){
    
}

// Apply the neccesary Fix to the connection
databaseErrorHandler(connectionTester());
queryUserVerification();
userPage();
$connection = null; 
?>
