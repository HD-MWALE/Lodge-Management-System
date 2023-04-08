<?php 
    session_start();
    include 'header.php';
    include 'topbar.php'; 
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    if(!file_exists($page.".php")){
        header('location: 404.html');
    }else{
        include $page.'.php';
    }
    include 'footer.php'; 
?>