<?php
session_start();

$party_row = $_SESSION['party_row'];
$guests_array = $_SESSION['guests_array'];
$reh = $_SESSION['reh'];
$wed = $_SESSION['wed'];
$bru = $_SESSION['bru'];
$rehErr = $_SESSION['rehErr'];
$wedErr = $_SESSION['wedErr'];
$bruErr = $_SESSION['bruErr'];
?>

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

  <body>
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
            <div class="white-text" id="party-container">
                  <form method="post" action="" style="padding: 20px;">
                    <p>RSVP for <?php echo $party_row[1]; ?> </p>
                    <?php if ($party_row[2]) {
                        $form_width = "col-md-4";
                        ?><p>We are also having a rehearsal dinner for close family and friends, and we would love for you to attend.  The dinner will take place at 6pm on Friday, June 8, at <a href="https://goo.gl/maps/aF1VyWTw5fE2" target="_blank">Scottadito Osteria Toscana</a>.</p><?php
                    }?>
                    
                    <?php for($i=0;$i<$_SESSION['num_guests'];$i++)
                    { ?>
                        <hr><h3 style="font-weight:bold; text-align:center;">Is <?php echo $guests_array[$i][1] . ' ' . $guests_array[$i][2]; ?> attending:</h3>
                        <div class="form-group row">
                        <?php if ($party_row[2]) {
                            $form_width = "col-md-4";
                            ?>
                            <div class=<?=$form_width;?> >
                                <input type="hidden" name="ques"/>Rehearsal Dinner (6/8, 6pm)?<br>
                                <label class="radio-inline"><input type="radio" name="rehradio[<?php echo $i; ?>]" value='y' <?php if($reh[$i]==1) {echo "checked";}?>>Yes</label>
                                <label class="radio-inline"><input type="radio" name="rehradio[<?php echo $i; ?>]" value='n' <?php if(isset($reh[$i]) and $reh[$i]==0) {echo "checked";}?>>No</label>
                                <?php if ($rehErr[$i] != '') {?><span class="error"><br><?php echo '&nbsp&nbsp&nbsp* ' . $rehErr[$i];?></span><?php } ?>
                            </div>
                            <?php
                            }
                            else {
                                $form_width = "col-md-6";
                            }
                            ?>
    
                          <div class=<?=$form_width;?>>
                                <input type="hidden" name="ques"/>Wedding (6/9, 5pm)?<br>
                                <label class="radio-inline"><input type="radio" name="wedradio[<?php echo $i; ?>]" value='y' <?php if($wed[$i]==1) {echo "checked";}?>>Yes</label>
                                <label class="radio-inline"><input type="radio" name="wedradio[<?php echo $i; ?>]" value='n'<?php if(isset($wed[$i]) and $wed[$i]==0) {echo "checked";}?>>No</label>
                                <?php if ($wedErr[$i] != '') {?><span class="error"><br><?php echo '&nbsp&nbsp&nbsp* ' . $wedErr[$i];?></span><?php } ?>
                            </div>
    
                          <div class=<?=$form_width;?>>
                                <input type="hidden" name="ques"/>Brunch (6/10, TBD)?<br>
                                <label class="radio-inline"><input type="radio" name="bruradio[<?php echo $i; ?>]" value='y' <?php if($bru[$i]==1) {echo "checked";}?>>Yes</label>
                                <label class="radio-inline"><input type="radio" name="bruradio[<?php echo $i; ?>]" value='n' <?php if(isset($bru[$i]) and $bru[$i]==0) {echo "checked";}?>>No</label>
                                <?php if ($bruErr[$i] != '') {?><span class="error"><br><?php echo '&nbsp&nbsp&nbsp* ' . $bruErr[$i];?></span><?php } ?>
                            </div>
                        </div>

                    <?php }?>
                    
                    <div class="form-group"><hr>
                        <label for="comment">Any comments or questions?</label>
                      <textarea class="form-control" rows="5" name="comment" id="comment"><?php echo $_SESSION['comment']; ?></textarea>
                    </div>
                    
                    <div class="row">
                        
                    <div class="row">
                        <button type="submit" class="btn btn-default" name="party_submit"><?php if($party_row[5]) {echo "Update RSVP";} else{echo "Submit RSVP";}?></button>
                    </div>
                    <div class="form-group" id="success">
                        <?php if ($rsvp_msg) {
                            echo $rsvp_msg;
                        }?>
                    </div>
                </form>
            </div>
        </div>
                <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        
                
        <script src="/js/onResize.js"></script>
    </body>
</html>