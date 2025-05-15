<?php 

include "../../classes/user.php";





$method = $_SERVER['REQUEST_METHOD'];

$user = new User;



if ($method == 'POST')

{

	if (isset($_POST['login'])) 
	{

	  	$user->loginUser($_POST['email'], $_POST['password']);

	}

	if (isset($_POST['logout'])) 
	{

	  	$user->logoutUser();

	}

	if (isset($_POST['add_user'])) 
	{

		$user->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_FILES["img"]);
	}

	if (isset($_POST['delete_user'])) 
	{
	  $user->removeUser($_POST['delete_user']);
	}


	if (isset($_POST['uploadUser'])) 
	{

		// var_dump($_FILES['user_photo']);
	  $user->updateUser($_POST['user_id'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password'], $_FILES["img"]);

	}


}


