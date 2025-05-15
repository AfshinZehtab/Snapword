

<h1>Admin Panel</h1>
<?php 



class UserProfile extends DB
{
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
		$this->id;
		$this->firstname;
		$this->lastname;
		$this->email;
		$this->password;
		$this->img;

		$this->db = new DB;
	}

	public function getUserData($user_id='')
	{
		$query = "SELECT * FROM users WHERE id='$user_id'";

		$result = $this->db->conn->query($query);

    if ($result)
    {
    	$rowEmail = $result->fetch_assoc();

    	if (is_array($rowEmail) && count($rowEmail)>0)
    	{

    		$user_id = $rowEmail['id'];
    		$user_firstname = $rowEmail['firstname'];
    		$user_lastname = $rowEmail['lastname'];
    		$user_email = $rowEmail['email'];
    		$user_password = $rowEmail['password'];


				if (empty($rowEmail['img'])) {
					$rowEmail['img'] = "user_image.png";
					$usrImgPath = "/users/includes/users/img/".$rowEmail['img']."";
				}
				else 
				{
					$usrImgPath = "/users/includes/users/img/uploads/users/".$user_id."/".$rowEmail['img']."";
				}
      		 

		  	echo "

		  	<form class='row g-3' enctype='multipart/form-data' a method='post' action='/users/includes/users/fetch_userData.php' id='updateUser'>
		  		<input type='text' style='display: none;' name='user_id' value='".$user_id."'>
		  		<div class='col-4 input-group mb-3'>
		  			<img src='".$usrImgPath."' id='user_photo' name='img' class='img-fluid' alt='Photo from ".$user_firstname."'>
	  			</div>

	  			<div class='input-group mb-3'>
		          	<input type='file' name='img' class='form-control' value='' onchange='readURL(this);'>
		      	</div>
			
			  	<div class='input-group mb-3'>
					<span class='input-group-text' id='inputGroup-sizing-default'>Firstname</span>
					<input type='text' name='firstname' value='' class='firstname form-control' aria-label='' aria-describedby='inputGroup-sizing-lg' >
				</div>

				<div class='input-group mb-3'>
					<span class='input-group-text' id='inputGroup-sizing-default'>Lastname</span>
					<input type='text' name='lastname' value='' class='lastname form-control' aria-label='' aria-describedby='inputGroup-sizing-lg'>
				</div>

				<div class='input-group mb-3'>
					<span class='input-group-text' id='inputGroup-sizing-default'>Email</span>
					<input type='email' name='email' value='' onchange='' class='email form-control' aria-label='' aria-describedby='inputGroup-sizing-lg'>
				</div>

				<div class='input-group mb-3'>
					<span class='input-group-text' id='inputGroup-sizing-default'>Password</span>
					<input type='password' name='password' value='' class='password form-control' aria-label='' aria-describedby='inputGroup-sizing-lg'>
				</div>


				<div class='col-auto' style='padding-left: 0;'>
					<button type='submit' name='uploadUser' class='btn btn-success mb-3'>Save</button>
				</div>

			</form>";

				echo 
					"<script type='text/javascript'>
        				jQuery(document).ready(function(){ 
  
			            $('form#updateUser .firstname').val('".$user_firstname."');
			            $('form#updateUser .lastname').val('".$user_lastname."');
			            $('form#updateUser .email').val('".$user_email."');
			            $('form#updateUser .password').val('".$user_password."');
								
			 						

			            });

					    function readURL(input) {
					        if (input.files && input.files[0]) {
					            var reader = new FileReader();

					            reader.onload = function (e) {
					                $('#user_photo').attr('src', e.target.result);
					            }

					            reader.readAsDataURL(input.files[0]);
					        }
					    }


			        </script>";


    	}

    }

	}

}

$UserProfile = new UserProfile;
echo $UserProfile->getUserData($_SESSION['user_id']);

