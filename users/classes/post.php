<?php

require_once("/var/www/html/db/db.php");

/**
 * Post Class 
 */


class Post extends DB
{
	public $user_id;
	public $post_id;
	public $post_title;
	public $post_body;
	public $post_img;
	public $post_created;
	public $db;

	public $adminEmail = "1@gmail.com";

	
	function __construct()
	{
		$this->user_id;
		$this->post_id;
		$this->post_title;
		$this->post_body;
		$this->post_img;
		$this->post_created;

		$this->db = new DB;
	}

	private function findUserID()
	{
		if (!isset($_SESSION)) 
		{
			session_start();
		}

		$user_email = $_SESSION['loggedin'];
		$query = "SELECT * FROM users WHERE email='$user_email'";

		$result = $this->db->conn->query($query);

        if ($result)
        {
        	$rowEmail = $result->fetch_assoc();

        	if (is_array($rowEmail) && count($rowEmail)>0)
        	{
        		return $rowEmail['id'];
        		// echo $rowEmail['id'];
        	}
        }
	}

	public function fetch_users_posts( $offset = 0 )
	{



        $query = "SELECT * FROM users_posts ORDER BY `createdData` DESC limit $offset, 5";


	    $result = $this->db->conn->query($query);



	    foreach($result as $row)
	    {

			$user_post_id = $row['user_id'];
			$posted_id = $row['id'];


			$queryUserID = "SELECT * FROM users WHERE id='$user_post_id'";


			$resultUser = $this->db->conn->query($queryUserID);

	        if ($resultUser)
	        {
	        	foreach($resultUser as $rowUser)
		    	{	
	        		$user_firstname = $rowUser['firstname'];
	        		$user_id = $rowUser['id'];
	        		$user_img = $rowUser['img'];
	        	}
	        }

			$postedAt = date("d.m.Y | H:m",strtotime($row['createdData']));
			    echo "
			    <div class='post_block post_block_".$posted_id."'>

					<div class='col post'>
						<div class='row'>
							<div class='row'>";

			if ($user_img == "") 
			{
				echo "<div class='col'><img class='user_photo' src='users/includes/users/img/user_image.png' alt='".$user_img."' ' width='50' height='50'></div>";

			} else
			{
				echo "<div class='col'><img class='user_photo' src='users/includes/users/img/uploads/users/".$user_post_id."/".$user_img."' alt='".$user_img."' ' width='50' height='50'></div>";
			}


			echo "<div class='col'><p class='user_firstname'>".$user_firstname."</p></div>
				</div>
			</div>
			<div class='col posted_photo' style='text-align: center;'>";

			if ($row['img'] == "") 
			{
				echo "";

			} else
			{
				echo "<img src='users/includes/users/img/uploads/users/".$user_post_id."/posted_photos/".$row['img']."' alt='".$row['img']."' class='rounded-pill img-fluid img-fluid' style='height: 18rem;'>";
			}
				
			echo "</div>
			<div class='col title'><h4>".$row['title']."</h4></div>
			<div class='col text_body'><p>".$row['body']."</p></div>
			";


			if ($row['img'] == "") {

			$background_colors = array('#4be1ff', '#ffc1c1', '#dbffc1', '#d6c1ff', '#6cd998', '#ACC5ff');

			$rand_background = $background_colors[array_rand($background_colors)];
			echo "

			<style>


				.post_block_".$posted_id." {
					background: $rand_background;
				}

			</style>

			";
			}
			else 
			{
			echo "
			<style>

			.post_block_".$posted_id." 
			{
				background: url(users/includes/users/img/uploads/users/".$user_post_id."/posted_photos/".$row['img'].");
			}

			</style> ";
			}
		
	    
			if (!isset($_SESSION)) 
			{
				session_start();
			}

			$user_email = $_SESSION['loggedin'];

			if ($user_email == $this->adminEmail || $user_post_id == $_SESSION['user_id']) 
			{
				echo "

				<div class='col createdAt row' style='text-align: right; margin-top: 30px;'>
						<div class='col'>
							<form method='POST' action='users/includes/users/create_post.php' class='row'>
								<button type='submit' name='edit_post' class='col btn btn-info m-1' value='".$row['id']."' style='background: none;'>Edit</button>
							</form>
						</div>
						<div class='col'>
							<form method='POST' action='users/includes/users/create_post.php' class='row'>
								<button type='submit' name='delete_post' class='col btn btn-danger m-1' value='".$row['id']."' style='background: none;'>Delete</button>
							</form>
						</div>
						<div class='col'>
							<p style='color: white;'>".$postedAt."</p>			
						</div>
					</div>	
				</div>
			</div>";
			} else 
			{
				echo "
				<div class='col createdAt row' style='text-align: right; margin-top: 30px;'>
					<div class='col'>
						<p style='color: white;'>".$postedAt."</p>			
					</div>
				</div>


				</div>
				</div>";
			}
		
    	}
	    echo "</div></div>";

	    // $this->db->conn->close();
	}

	private function uploadUserPostPhoto($id)
	{
		$allow = array("jpg", "jpeg", "gif", "png");

		if (!file_exists('img/uploads/users/' . $id. '/posted_photos')) 
		{

			if (!mkdir('img/uploads/users/' . $id. '/posted_photos', 0777, true)) 
			{
			    die('Failed to create directories...');
			}
			
		}

		$todir = 'img/uploads/users/' . $id . '/posted_photos/';

		if ( !!$_FILES['img']['tmp_name'] ) // is the img uploaded yet?
		{
		    $info = explode('.', strtolower( $_FILES['img']['name']) ); // whats the extension of the img

		    if ( in_array( end($info), $allow) ) // is this img allowed
		    {
		        if ( move_uploaded_file( $_FILES['img']['tmp_name'], $todir . basename($_FILES['img']['name'] ) ) )
		        {
		            // the img has been moved correctly
		        }
		    }
		    else
		    {
		        // error this img ext is not allowed
		    }
		}
	}

	public function createdPost($post_title, $post_body, $post_img)
	{
		$this->user_id = $this->findUserID();
		$this->post_title = $post_title;
		$this->post_body = $post_body;
		$this->post_img = $post_img;

		$imgName = basename($post_img["name"]);
		$uploadOk = 1;

		$query = "INSERT INTO users_posts (user_id, title, body, img) VALUES ('$this->user_id', '$this->post_title', '$this->post_body', '$imgName')";

			$result = $this->db->conn->query($query);


	        if ($result)
	        {
	        	$this->uploadUserPostPhoto($this->user_id);
	        	header("Location: /?posts");
	        } else
	        {
	        	echo "<div class='alert alert-danger' role='alert'>Unsuccessfully post created!</div>";
	        }
		
	}

	public function deletePost($post_id)
	{
		$query = "DELETE FROM users_posts WHERE id='$post_id'";

	    $result = $this->db->conn->query($query);

	    if ($result) 
	    {


	        session_start();
	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Successfully deleted!</div>";
			// $this->deleteAll('img/uploads/users/' . $id);
	        header("Location: /?posts");
	    } 
	    else 
	    {
	        session_start();
	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Unsuccessfully deleted!</div>";
	        header("Location: /?posts");
	        echo "Error deleting record: " . $conn->error;
	    }

	    $conn->close();
	}

	public function editPost($post_id)
	{

		$query = "SELECT * FROM users_posts WHERE id='$post_id'";

	    $result = $this->db->conn->query($query);

	    if ($result) 
	    {
	        
	    	foreach($result as $row)
	    	{
	    		$old_post_title = $row['title'];
	    		$old_post_body = $row['body'];
	    		$posted_photo_name = $row['img'];
	    		$old_user_id = $row['user_id'];


	        	$_SESSION['old_post_title'] = $old_post_title;
	        	$_SESSION['old_post_body'] = $old_post_body;

	        	if (empty($posted_photo_name)) {
	        		$posted_photo_url = "users/includes/users/img/image-not-available.svg";
	        		$_SESSION["posted_photo_url"] = $posted_photo_url;
	        	} else {
	        		$_SESSION["posted_photo_name"] = $posted_photo_name;
	        		$posted_photo_url = "users/includes/users/img/uploads/users/".$old_user_id."/posted_photos/".$posted_photo_name."";
	        		$_SESSION["posted_photo_url"] = $posted_photo_url;
	        	}
	    	}
	    	
	    	header("Location: /?createPosts");


	    } 
	    else 
	    {
	        session_start();
	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Unsuccessfully updated!</div>";
	        header("Location: /?posts");
	        echo "Error updating record: " . $conn->error;
	    }

	    // $conn->close();
	}

	public function updatePost($post_id, $post_title, $post_body, $post_img)
	{

		$post_img=$post_img['name'];

		if (!empty($post_img)) {
			
			$query = "UPDATE users_posts SET title='$post_title', body='$post_body', img='$post_img' WHERE id='$post_id'";
		} else {
			
			$query = "UPDATE users_posts SET title='$post_title', body='$post_body' WHERE id='$post_id'";

		}
		


	    $result = $this->db->conn->query($query);

	    if ($result) 
	    {

	    	$query = "SELECT * FROM users_posts WHERE id='$post_id'";


	    	$result = $this->db->conn->query($query);

	    	foreach($result as $row)
	    	{

	    		$this->uploadUserPostPhoto($row['user_id']);
	    	}

	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Successfully updated!</div>";
			// $this->deleteAll('img/uploads/users/' . $id);
	        header("Location: /?posts");
	        unset($_SESSION["old_post_title"]);
	        unset($_SESSION["old_post_body"]);
	        unset($_SESSION["posted_photo_url"]);
	        unset($_SESSION["posted_photo_name"]);
	        unset($_SESSION["post_id"]);
    	} 
	    else 
	    {

	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Unsuccessfully updated!</div>";
	        header("Location: /?posts");
	        echo "Error updating record: " . $conn->error;
	    }
	}

	public function test($i=0)

	{

		$query = "SELECT * FROM users_posts ORDER BY `createdData` DESC ";

	    $result = $this->db->conn->query($query);

	    if ($result) 
	    {
	    	echo "
			<div class='container' style='text-align: center; margin-top: 30px; margin-bottom: 30px;'>
				<div class='row'>
	    	";
	    	$num_rows = mysqli_num_rows($result);
	    	$pages=round($num_rows / 5)+1;

	    	if (isset($_POST['show_more']))
	    	{

	    		$current_page = $_POST['show_more'];
		    	echo "

				<style>
	  
				  .show_more_$current_page {
				    font-weight: 900;
				  }
				</style>

				";
	    	}



	    	while ($i < $pages) 
	    	{
	    		echo "
					
					    <form method='POST' action='?posts&show_more' class='col'>
					      <button type='submit' name='show_more' class='show_more show_more_$i' class='col-2 btn btn-info m-1' value='$i' style='background: none;
							    color: #4444ff;
							    border: none;
								padding: 10%;
							    text-align: center;'>".$i + 1 ."</button>
					    </form>



					";
				$i++;
	    	}

		echo " </div></div>";

	    }

	}


}