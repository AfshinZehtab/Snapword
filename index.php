<?php 
session_start();
if (!isset($_SESSION['loggedin'])) 
{ 

  header("Location: /users/login.php");
    
  
} 
else 
{



include "users/includes/header.php";
include "users/includes/nav.php";


echo "<div class='container'>
<section id='content'>
  <div class='mt-5'>";


include "users/classes/user.php";
include "users/classes/post.php";
$user = new User;


if( basename(__FILE__) == "index.php" ) {
  echo "

  <script type='text/javascript'>
    
      $('.nav_home').addClass('active');

  </script>

  ";
}

if (isset($_SESSION['status']))
{
  echo $_SESSION['status'];
  $now = time();
  if ($now = $now+3)
  {
    unset($_SESSION['status']);
  }
}


if (isset($_GET['admins']) && $user->isAdmin($_SESSION['loggedin'])) 
{

  echo "
  <script type='text/javascript'>

    $('.nav_home').removeClass('active');
    $('.nav_admins').addClass('active');

  </script>

  ";

  unset($_SESSION["old_post_title"]);
  unset($_SESSION["old_post_body"]);
  unset($_SESSION["post_id"]);
  unset($_SESSION["old_post_photo"]);
  unset($_SESSION["posted_photo_name"]);

  include "users/includes/users/admins_template.php";

  $user = new User; $user->fetch_users_data();
}


if (isset($_GET['admin-panel'])) {

  include "users/includes/users/admin-panel.php";

}


if (isset($_GET['posts'])) {
  echo "

  <script type='text/javascript'>

    $('nav#navbar .nav_home').removeClass('active');
    $('nav#navbar .nav_posts').addClass('active');

  </script>

  ";
  echo "<h1>All Posts</h1>";
  unset($_SESSION["old_post_title"]);
  unset($_SESSION["old_post_body"]);
  unset($_SESSION["post_id"]);
  unset($_SESSION["old_post_photo"]);
  unset($_SESSION["posted_photo_name"]);
  $post = new Post;
  
if (isset($_POST['show_more'])) 
  {

    // echo $_POST['show_more']+5;
    $i = $_POST['show_more'] * 4 ;
    $x = $_POST['show_more'];
    $post->fetch_users_posts($i);

            echo "



      <script type='text/javascript'>
          

        $('button.show_more_$x').click(function(){

        $('button.show_more_$x').addClass('active');
        });
        

      </script>

    ";
  } else
  {
    $post->fetch_users_posts();
    
  }
  $test = $post->test();


}



if (isset($_GET['createPosts'])) {

  echo "

  <script type='text/javascript'>
    
    $('.nav_home').removeClass('active');
    $('.nav_createPosts').addClass('active');

  </script>

  ";

  include "users/includes/users/create_post_template.php";
  
}



     ?>
    </div>
  </section>
</div>


<?php include "users/includes/footer.php";


}
