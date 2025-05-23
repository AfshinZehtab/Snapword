<?php

require("/var/www/html/db/db.php");

/**
 * User Class 
 */

class User extends DB
{
	// protected $conn;

	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $img;
	public $db;

	public $adminEmail = "1@gmail.com";

	
	function __construct()
	{
		$this->firstname;
		$this->lastname;
		$this->email;
		$this->password;
		$this->img;

		$this->db = new DB;
	}

	public function isAdmin($email)
	{
		if ($email === $this->adminEmail)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function isEmailExists($email)
	{
	    // SQL Statement
	    $sql = "SELECT * FROM users WHERE email='$email'";

	    $result = $this->db->conn->query($sql);

	    if ($result)
	    {

    	  	// Fetch Associative array
		    $row = $result->fetch_assoc();

		    // Check if there is a result and response to  1 if email is existing
		    return (is_array($row) && count($row)>0);
	    }
	    else 
	    {
	        session_start();
	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Unsuccessfully! Please Try Again!</div>";
	        header("Location: login.php");
	        echo "Error deleting record: " . $this->db->conn->error;
	    }

   		$this->db->conn->close();

	}

	public function loginUser($email, $password)
	{
		// Check if Email exists

		$isEmailExists = $this->isEmailExists($email);

	    if ($isEmailExists > 0 )
	    {
			$query = "SELECT * FROM users WHERE email='$email'";

			$result = $this->db->conn->query($query);

	        if ($result)
	        {
	        	$rowEmail = $result->fetch_assoc();

	        	if (is_array($rowEmail) && count($rowEmail)>0)
	        	{

	        		$hashed_password = $rowEmail['password'];
	        		if(password_verify($password, $hashed_password)) 

	        		{

		        		session_start();


	                    if ($this->adminEmail == $rowEmail['email'])
	                    {
	                    	$_SESSION['firstname'] =  $rowEmail['firstname'];
	                    	$_SESSION['lastname'] =  $rowEmail['lastname'];
	                    	$_SESSION['loggedin'] = $rowEmail['email'];
	                    	$_SESSION['user_id'] = $rowEmail['id'];
				            $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Successfully loged in!</div>";
				            // header("Location: admin.php");
				            header("Location: ../../../");
				            exit();

	                    } else
	                    {
	                    	$_SESSION['firstname'] =  $rowEmail['firstname'];
	                   		$_SESSION['lastname'] =  $rowEmail['lastname'];
	                        $_SESSION['loggedin'] = $rowEmail['email'];
	                        $_SESSION['user_id'] = $rowEmail['id'];
	                        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Successfully loged in!</div>";
	                        header("Location: ../../../");
	                        exit();

	                    }
	        		
	                } else
                    {
						session_start();
                    	$_SESSION['status'] = "<div class='alert alert-info' role='alert'>Your password is wrong, Please try again!</div>";
                        // setcookie('status', "<div class='alert alert-danger' role='alert'>Your password is wrong, Please try again!</div>", time()+3);
                        
                        header("Location: ../../login.php");

                    }

	        	}
		            
	        }

	        $this->db->conn->close();


	    } else
	    {
	    	session_start();
	    	$_SESSION['status'] = "<div class='alert alert-danger' role='alert'>Unsuccessfully loged in! There is no Account with this Email.</div>";

	        // setcookie('status', "<div class='alert alert-danger' role='alert'>There is no account with this Email<br> Please Create an account!</div>", time()+3);

	        header("Location: ../../login.php");

	    }
	}

	public function logoutUser()
	{
	    session_start();
	    session_destroy() ;
	    header('Location: ../../login.php');
	}

	public function fetch_users_data()
	{

	    $query = "SELECT * FROM users";

	    $result = $this->db->conn->query($query);

	    echo "
	    <div class='table-responsive mt-4'><table class='table table-striped table-bordered'>
		  <thead>
		    <tr>
		      <th scope='col-auto'>Photo</th>
		      <th scope='col-auto'>Firstname</th>
		      <th scope='col-auto'>Lastname</th>
		      <th scope='col-auto'>Email</th>
		      <th scope='col-auto'>Action</th>
		    </tr>
		  </thead>
		  <tbody>"; 


	    foreach($result as $row)
	    {

	        $output [] = array(
	            'img'    =>  $row['img'],
	            'firstname' =>  $row['firstname'],
	            'lastname'  =>  $row['lastname'],
	            'email' =>  $row['email'],
	            'password' =>  $row['password'],
	            // 'createdDate'   =>  $row['createdDate']
	        );

	        if (empty($row['img']))
	        {
	        	$user_profile_pic_url = "users/includes/users/img/user_image.png";
	        } else
	        {
	        	$user_profile_pic_url = "users/includes/users/img/uploads/users/".$row['id']."/".$row['img'].""; 
	        }

        	

	        echo "
	        <tr class='mt-1 pt-3 pb-3'>
	            <th scope='row' style='text-align: center;'><img src='".$user_profile_pic_url."' class='rounded-pill img-fluid img-thumbnail' alt='Profile Pic from ".$row['firstname']."' style='width: 8rem; height: 8rem; border-radius: 80%;'></th>
	            <th>".$row['firstname']."</th>
	            <th>".$row['lastname']."</th>
	            <th>".$row['email']."</th>
	            <th>
	                <form method='POST' action='users/includes/users/fetch_userData.php' class='row'>

	                    <button type='submit' name='delete_user' class='col btn btn-danger m-1' value='".$row['id']."'>Delete</button>

	                </form>
	            </th>

	        </tr>";

	    }
	    echo "</tbody></table></div>";

	    $this->db->conn->close();
	    // return json_encode($output);
	    // echo json_encode($output);

	}

	private function uploadImage($id)
	{
		$allow = array("jpg", "jpeg", "gif", "png");

		if (!file_exists('img/uploads/users/' . $id)) 
		{

			if (!mkdir('img/uploads/users/' . $id, 0777, true)) 
			{
			    die('Failed to create directories...');
			}
			
		}

		$todir = 'img/uploads/users/' . $id . '/';

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

	public function createUser($firstname, $lastname, $email, $password, $img)
	{
		// Check if Email exists

		$isEmailExists = $this->isEmailExists($this->email);

	    if ($isEmailExists > 0 )
	    {

	        session_start();

	        $_SESSION['status'] = "<div class='alert alert-danger' role='alert'>There is an account with this Email! <br> Please use <a href='http://localhost/src/users/login.php'>login</a> page!</div>";

	        header("Location: admin.php");


	    } else
	    {

			$imgName = basename($img["name"]);
			$uploadOk = 1;


			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			$query = "INSERT INTO users (firstname, lastname, email, password, img) VALUES ('$firstname', '$lastname', '$email', '$hashed_password', '$imgName')";

			$result = $this->db->conn->query($query);


	        if ($result)
	        {
	            session_start();
	            $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Successfully created! <br> Please use <a href='http://localhost/src/users/login.php'>login</a> page!</div>";

				$queryID = "SELECT id FROM users WHERE email='$email'";

            	$resultID = $this->db->conn->query($queryID);

            	if ($resultID)
		        {
		        	$newUser = $resultID->fetch_assoc();
		            $this->uploadImage($newUser['id']);
		        }
	            header("Location: /?admins");
	        } 
	        else 
	        {
	            session_start();
	            $_SESSION['status'] = "<div class='alert alert-danger' role='alert'>There is an account with this Email! <br> Please use <a href='http://localhost/src/users/login.php'>login</a> page!</div>";
	            header("Location: admin.php");
	            echo "Error created record: " . $this->db->conn->error;
	        }

	        $this->db->conn->close();
	    }
	}

	// delete all files and sub-folders from a folder
	private function deleteAll($dir) 
	{
		foreach(glob($dir . '/*') as $file) 
		{
			if(is_dir($file))

				deleteAll($file);

			else

				unlink($file);
		}

		rmdir($dir);
	}

	public function removeUser($id) 
	{


	    $query = "DELETE FROM users WHERE id='$id'";

	    $result = $this->db->conn->query($query);

	    if ($result) 
	    {


	        session_start();
	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Successfully deleted!</div>";
			$this->deleteAll('img/uploads/users/' . $id);
	        header("Location: /?admins");
	    } 
	    else 
	    {
	        session_start();
	        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Unsuccessfully deleted!</div>";
	        header("Location: admin.php");
	        echo "Error deleting record: " . $conn->error;
	    }

	    $conn->close();

	}


	public function updateUser($user_id, $user_firstname, $user_lastname, $user_email, $user_password, $user_img)
	{		



		$query = "SELECT * FROM users WHERE id='$user_id'";

	    $result = $this->db->conn->query($query);

	    if ($result) 
	    {

	    	foreach($result as $row)
	    	{
	    		$old_user_firstname = $row['firstname'];
	    		$old_user_lastname = $row['lastname'];
	    		$old_user_email = $row['email'];
	    		$old_user_password = $row['password'];
	    		$user_photo_name = $row['img'];



				$imgName = basename($user_img["name"]);
				$uploadOk = 1;

    			$this->uploadImage($user_id);

	    		if($user_password== $old_user_password)

	    		{
	    			$user_password == $old_user_password;
	    		}
	    		else
	    		{

	        		$user_password = password_hash($rowEmail['password'], PASSWORD_DEFAULT);
	    			
	    		}

	    		$query = "UPDATE users SET firstname='$user_firstname', lastname='$user_lastname', email='$user_email', password='$user_password', img='$imgName' WHERE id='$user_id'";

	    		$result = $this->db->conn->query($query);

	    		if ($result) 
	    		{
	    			header("Location: /?admin-panel");
	    		} else {
	    			session_start();
			        $_SESSION['status'] = "<div class='alert alert-success' role='alert'>Unsuccessfully updated!</div>";
			        header("Location: /?posts");
			        echo "Error updating record: " . $conn->error;

	    		}

	    	}


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


	public function userPosts()
	{
		$table_name = "myapp_post_table";

		echo "<strong class='h1 p-2'>$table_name</strong><br>";

		$response = mysqli_query($this->db->conn, "SELECT * FROM $table_name");

		while ($i = mysqli_fetch_assoc($response))
		{
			echo "<div class='row'><div class='col'>". $i['body'] . "</div></div><br>";
		}

	}
}