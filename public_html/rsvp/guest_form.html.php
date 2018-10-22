<?php session_start();?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Mallanna" />
    
      <style>
        body, html, .bg {
            height: 100%;
        }
        
        .bg { 
        	background: url(img/website_sheep_edited.png) no-repeat top center fixed; 
        	-webkit-background-size: cover;
        	-moz-background-size: cover;
        	-o-background-size: cover;
        	background-size: cover;
            
    	}
	</style>
  </head>

  <body onresize="onResize()">
      <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container-fluid">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span> 
              </button>
              <a class="navbar-brand" href=/>Ellie & David's Wedding</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
              <ul class="nav navbar-nav">
                <li><a href="/OurStory/">Our Story</a></li>
                <li><a href="/events/">Events</a></li>
                <li><a href="/directions/">Directions</a></li>
                <li><a href="/hotels/">Hotels</a></li>
                <li><a href="/registry/">Registry</a></li>
                <li><a class="active" href="/rsvp/">RSVP</a></li>
              </ul>
            </div>
          </div>
        </nav>
    
        <div class="bg">
            <div class="form-container" id="user-container">
                <div class="white-text">
                    Please enter your first and last name, as written on the invitation. (This should be the first and last name of only one person.)
                    </div>
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <label class="sr-only" for="firstname">First Name</label>
                        <input type="text" class="form-control" name="firstname" placeholder="First name">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" placeholder="Last name">
                    </div>
                    <button type="submit" class="btn btn-default" name="guest_submit">RSVP for my party</button>
    
                </form>
                
                <div class="error">
                    <span class="not-found"><?php if ($not_found) { echo nl2br($not_found);} ?></span>
                </div>
            </div>
        </div>
        


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
        <script src="/js/onResize.js"></script>
        
    </body>
</html>