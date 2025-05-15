<section>
	<nav id="navbar" class="navbar navbar-expand-lg navbar-light">


	  	<?php 
			
	  		$userFirstname = $_SESSION['firstname'];

			if (!isset($_SESSION['firstname'])) 
			{

			  echo "<a class='nav-link' href='/?admin-panel'>AdminUser</a>";
			} else
			{
				echo "<a class='nav-link' href='/?admin-panel'>$userFirstname Admin Panel</a>";
			}


      	?>

	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarText">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item nav_home">
	        <a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a>
	      </li>
	      <li class="nav-item nav_posts">
	        <a class="nav-link" href="?posts">Posts</a>
	      </li>
	      <li class="nav-item nav_createPosts">
	        <a class="nav-link" href="?createPosts">Create Post</a>
	      </li>
	      <li class="nav-item nav_admins">
	      	<?php 

				if ($_SESSION['loggedin'] <> '1@gmail.com' || !isset($_SESSION['loggedin'])) 
				{

				  echo "<a class='nav-link' href='#'></a>";
				} else
				{
					echo "<a class='nav-link' href='?admins'>Admins</a>";
				}


	      	?>
	        
	      </li>
	    </ul>
		    <form method="POST" action="users/includes/users/fetch_userData.php"´ style="margin: 0;">
		      <button class="btn btn-dark" type="submit" name="logout">Logout</button>
		    </form>
	  </div>
	</nav>

</section>