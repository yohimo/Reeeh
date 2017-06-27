<?php
require_once 'includes/public/header/header.php';
Connected();
?>
    <div class="row">
     <div class="col-xs-10 col-sm-4 col-md-4 col-lg-4 col-lg-offset-5 col-xs-offset-1">
     	<img src="assets/logo.png" id="logo">
     </div>
    	
      <form class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-lg-offset-4" method="post">
      <legend>Connect to <?php echo APP;?></legend>
        <label for="inputEmail" class="sr-only">Email</label>
        <input type="hidden" name="class" value="login">
        <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Your email" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Your password" required>
        <button class="btn btn-primary btn-block" type="submit">login</button>
      </form>
      </div>
