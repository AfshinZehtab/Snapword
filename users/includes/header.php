

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <?php 

      if (basename($_SERVER['PHP_SELF'], '.php') == "login")
      {
        echo "

        
    

    <link type='text/css' rel='stylesheet' href='/users/includes/css/jsgrid.min.css' />
    <link type='text/css' rel='stylesheet' href='/users/includes/css/jsgrid-theme.min.css' />
    
    <script src='/users/includes/js/jquery-3.7.1.min.js'></script>
    <script type='text/javascript' src='/users/includes/js/jsgrid.min.js'></script>
    <script src='users/includes/js/main.js'></script>

    <!-- Bootstrap CSS -->
    <link rel='stylesheet' href='/users/includes/css/bootstrap.min.css'>
    <link type='text/css' rel='stylesheet' href='/users/includes/css/main.css' />

    

    "; 
      } 
      else
      {

        echo "

        
    

    <link type='text/css' rel='stylesheet' href='/users/includes/css/jsgrid.min.css' />
    <link type='text/css' rel='stylesheet' href='/users/includes/css/jsgrid-theme.min.css' />

    <script src='/users/includes/js/jquery-3.7.1.min.js'></script>
    <script type='text/javascript' src='/users/includes/js/jsgrid.min.js'></script>
    <script src='/users/includes/js/main.js'></script>
    <!-- Bootstrap CSS -->

    <link rel='stylesheet' href='/users/includes/css/bootstrap.min.css' >
    <link type='text/css' rel='stylesheet' href='/users/includes/css/main.css' />
    
    "; 

      
      }
      ?>
 

    <title>
      
      <?php 

      if (basename($_SERVER['PHP_SELF'], '.php') == "admin")
      {
        echo "Admin Panel";  
      } 
      elseif (basename($_SERVER['PHP_SELF'], '.php') == "login")
      {
        echo "Login Page"; 
      }
      else
      {
        echo "Welcome"; 
      }

      ?>

    </title>
  </head>
  <body>
<script type="text/javascript">
  setTimeout(function(){
  if ($('div.alert').length > 0) {
    $('div.alert').remove();
  }
}, 5000)
</script>

<!-- <section class="container">
  <div class="mt-5"> -->
