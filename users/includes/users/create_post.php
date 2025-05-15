<?php 

include "../../classes/post.php";



$method = $_SERVER['REQUEST_METHOD'];

$post = new Post;


if ($method == 'POST')

{

  if (isset($_POST['create_post'])) 
  {


    $post->createdPost($_POST['post_title'], $_POST['post_body'], $_FILES["img"]);

  }

  if (isset($_POST['delete_post'])) 
  {

    $post->deletePost($_POST['delete_post']);

  }

  if (isset($_POST['edit_post'])) 
  {

    session_start();
    $_SESSION['post_id'] = $_POST['edit_post'];  
    $post->editPost($_SESSION['post_id']);

  }

  if (isset($_POST['update_post'])) 
  {

    session_start(); 
    $post->updatePost($_SESSION['post_id'], $_POST['post_title'], $_POST['post_body'], $_FILES['img']);

  }


}