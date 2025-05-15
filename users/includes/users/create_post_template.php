<?php include_once "users/classes/post.php";


$method = $_SERVER['REQUEST_METHOD'];

$post = new Post;
 ?>

<form method="POST" action="users/includes/users/create_post.php" enctype="multipart/form-data" id="createPost_form" name="create_post" style="    margin-bottom: 100px;">
  <div class="mb-3" style="text-align: center;">
    <img id="post_photo" name="img" class="img-fluid" src=

     <?php 

     if (empty($_SESSION['posted_photo_name']))

     {
      echo "'users/includes/users/img/image-not-available.svg'"; 
      

     } else
     {

      echo $_SESSION['posted_photo_url'];
     }

    
  ?> alt="your image" />
  </div>
<div class="mb-3">
  <input type="title" class="form-control" id="post_title" name="post_title" placeholder="Title" required>
</div>
<div class="mb-3">
  <textarea class="form-control" id="post_body" name="post_body" rows="3"  placeholder="Write your post" required></textarea>
</div>
<div class="col-auto" style="padding-left: 0;">
  <?php if (!isset($_SESSION['post_id']) && !isset($_SESSION['old_post_title']) && !isset($_SESSION['old_post_body']) && !isset($_SESSION["posted_photo_url"])) {
    echo "
    
    <div class='form-row mt-3'>
      <div class='col-2'>
        <button type='submit' class='btn btn-primary mb-3' name='create_post'>Submit</button>
      </div>
      <div class='col-4'>
          <input type='file' name='img' class='form-control' id='user_post_photo' value='' onchange='readURL(this);' />
      </div>
    </div>
    ";
  } else {
    echo "
    
    <div class='form-row mt-3'>
      <div class='col-2'>
        <button type='submit' class='btn btn-warning mb-3' name='update_post'>Update</button>
      </div>
      <div class='col-4'>
          <input type='file' name='img' class='form-control' id='user_post_photo' value='' onchange='readURL(this);' />
      </div>
    </div>
    ";


    echo "<script type='text/javascript'>
        jQuery(document).ready(function(){ 
  
            $('form#createPost_form #post_title').val('".$_SESSION['old_post_title']."');
            $('form#createPost_form #post_body').val('".$_SESSION['old_post_body']."');
            });
          </script>";
  }
   ?>

  </div>
</form>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#post_photo').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


