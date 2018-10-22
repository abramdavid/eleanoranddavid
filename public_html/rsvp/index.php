<?php
session_start();

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function connect_to_db($host_name, $user, $password, $db_name) {
    $conn = mysqli_connect($host_name, $user, $password); 
    if (!$conn) 
    { 
      $output = 'Unable to connect to the database server.'; 
      include 'output.html.php'; 
      exit(); 
    } 
    
    if (!mysqli_set_charset($conn, 'utf8')) 
    { 
      $output = 'Unable to set database connection encoding.'; 
      include 'output.html.php'; 
      exit(); 
    } 
    
    if (!mysqli_select_db($conn, $db_name)) 
    { 
      $output = 'Unable to locate the wedding database.'; 
      include 'output.html.php'; 
      exit(); 
    } 
    
    return $conn;
}

function var_to_num($var) 
{
    if ($var == 'y') {
        return 1;
    }
    else {
        return 0;
    }
}


# If first time getting to page
if (!isset($_POST['guest_submit']) and !isset($_POST["party_submit"]))    
{
    $not_found='';
    include 'guest_form.html.php';    
}   

# If guest form was submitted
elseif (!isset($_POST["party_submit"]))    
{    
    $firstname = $_REQUEST['firstname'];    
    $lastname = $_REQUEST['lastname'];        

    $conn = connect_to_db('localhost', 'eleanora_david', 'DragoCesnu!', 'eleanora_wedding');

    $sql = "SELECT party_id FROM guests WHERE first_name = '$firstname' and last_name='$lastname' ";

    $guest_result = mysqli_query($conn, $sql);   
    if (!$guest_result)   
    {   
        $output = 'Error while performing query';
        include 'output.html.php';   
        exit();   
    }   
    elseif (mysqli_num_rows($guest_result)==0)
    {
        if ($firstname and $lastname) {
            $not_found = "* '$firstname $lastname' was not found in our list of guests.\n* Please check the spelling on the invitation and make sure you are only entering the name of ONLY one guest in your party.";
                
                $to      = 'dabram@gmail.com, eleanor.chestnut@gmail.com';
                $subject = 'Guest Name Not Found' . $party_name;
                $message = "First Name: " . $firstname . "\r\nLast Name: " . $lastname;
                $headers = 'From: david@eleanoranddavid.com' . "\r\n" .
                    'Reply-To: david@eleanoranddavid.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                
                mail($to, $subject, $message, $headers);
        }
        else {
          $not_found = "* Please enter both your first and last name";  
        }
        include 'guest_form.html.php';   
    }    
    else
    {
        # Guest is found; now assign guest and party variables
        $guest_row=mysqli_fetch_row($guest_result);
        $party_id = $guest_row[0];

        $party_result = mysqli_query($conn, "SELECT * FROM parties WHERE party_id='$party_id'");   
        $_SESSION['party_row'] = mysqli_fetch_row($party_result);

        $guests_result = mysqli_query($conn, "SELECT * FROM guests WHERE party_id='$party_id'");
        $_SESSION['num_guests'] = mysqli_num_rows($guests_result);

        $guests_array = array(); 
        $reh=$wed=$bru=array();
        $rehErr = $wedErr = $bruErr = array_fill(0, $_SESSION['num_guests'] , '');

        while ($guests_row=mysqli_fetch_row($guests_result))
        {
                array_push($guests_array, $guests_row);
                array_push($reh, $guests_row[5]);
                array_push($wed, $guests_row[6]);
                array_push($bru, $guests_row[7]);
        }

        $_SESSION['guests_array'] = $guests_array;
        $_SESSION['comment'] = $_SESSION['party_row'][3];
        $_SESSION['reh'] = $reh;
        $_SESSION['wed'] = $wed ;
        $_SESSION['bru'] = $bru;
        $_SESSION['rehErr'] = $rehErr;
        $_SESSION['wedErr'] = $wedErr;
        $_SESSION['bruErr'] = $bruErr;
        
        
        mysqli_close($conn); //Close connection        
        
        include 'party_form.html.php';
    }
}
    
# If party_form was just submitted
else 
{
    
    $_SESSION['comment'] = test_input($_POST["comment"]);
    $num_guests = $_SESSION['num_guests'];
    $reh = $_SESSION['reh'];
    $wed = $_SESSION['wed'];
    $bru = $_SESSION['bru'];
    $rehErr = $wedErr = $bruErr = array_fill(0, $_SESSION['num_guests'] , '');
    $no_response = "Please select a response <(\"<)";
    $unfilled = FALSE;

    for($i=0;$i<$num_guests;$i++)
    {
        if ($_SESSION['party_row'][2]) {
            if (!isset($_POST["rehradio"][$i])) {
                $rehErr[$i] = $no_response;
                $unfilled = TRUE;
            }
            else {
                $reh[$i] = var_to_num(test_input($_POST["rehradio"][$i]));
            }
        }

        if (!isset($_POST["wedradio"][$i])) {
            $wedErr[$i] = $no_response;
            $unfilled = TRUE;
        }
        else {
            $wed[$i] = var_to_num(test_input($_POST["wedradio"][$i]));
        }

        if (!isset($_POST["bruradio"][$i])) {
            $bruErr[$i] = $no_response;
            $unfilled = TRUE;
        }
        else {
            $bru[$i] = var_to_num(test_input($_POST["bruradio"][$i]));
        }
    }
    
    # Update session variables
    $_SESSION['reh'] = $reh;
    $_SESSION['wed'] = $wed ;
    $_SESSION['bru'] = $bru;
    $_SESSION['rehErr'] = $rehErr;
    $_SESSION['wedErr'] = $wedErr;
    $_SESSION['bruErr'] = $bruErr;
    
    # Handle a successful submission
    if (!$unfilled) {
        $submit_error = FALSE;
        #Connect to db
        $conn = connect_to_db('localhost', 'eleanora_david', 'DragoCesnu!', 'eleanora_wedding');

        #Party session variables update
        $_SESSION['party_row'][3] = $_SESSION['comment']; //Comment
        $_SESSION['party_row'][5] = 1; //RSVP
        $party_id = $_SESSION['party_row'][0];
        $comment = $_SESSION['comment'];
        $comment = mysqli_real_escape_string($link, $comment);

        #Party db update
        $sql = "UPDATE parties SET comment='$comment', rsvpd=1 WHERE party_id='$party_id'";
        if (!mysqli_query($conn, $sql)) {
            $party_name = $_SESSION['party_row'][1];
            $comment = $_SESSION['party_row'][3];
            $to      = 'dabram@gmail.com, eleanor.chestnut@gmail.com';
            $subject = 'Guests database update error for: ' . $party_name;
            $message = "Party Responses Key: indices 5,6,7 are responses for rehearsal, wedding, brunch, respectively.\rParty Responses: " . print_r($_SESSION['guests_array'], true ) . "\rComment: " . $comment;
            $headers = 'From: david@eleanoranddavid.com' . "\r\n" .
                'Reply-To: david@eleanoranddavid.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
            
            $output = 'Error occurred during parties RSVP submission';
            include 'output.html.php';   
            exit();   
        }
        
        #Guests session variables and db update
        for($i=0;$i<$num_guests;$i++) {
            $_SESSION['guests_array'][$i][5] = $reh[$i]; //Okay to update this as null should persist throughout if not invited
            $_SESSION['guests_array'][$i][6] = $wed[$i];
            $_SESSION['guests_array'][$i][7] = $bru[$i];
            
            $guest_id = $_SESSION['guests_array'][$i][0];
            
            $sql = "UPDATE guests SET attending_rehearsal='$reh[$i]', attending_wedding='$wed[$i]', attending_brunch='$bru[$i]' WHERE guest_id='$guest_id'";
            if (!mysqli_query($conn, $sql)) {
                $party_name = $_SESSION['party_row'][1];
                $comment = $_SESSION['party_row'][3];
                $to      = 'dabram@gmail.com, eleanor.chestnut@gmail.com';
                $subject = 'Parties database update error for: ' . $party_name;
                $message = "Party Responses Key: indices 5,6,7 are responses for rehearsal, wedding, brunch, respectively.\rParty Responses: " . print_r($_SESSION['guests_array'], true ) . "\rComment: " . $comment;
                $headers = 'From: david@eleanoranddavid.com' . "\r\n" .
                    'Reply-To: david@eleanoranddavid.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                
                mail($to, $subject, $message, $headers);
                $rsvp_msg = 'Error connecting to server: RSVP not recorded. Please contact Ellie or David.';
                $submit_error = TRUE;
                break;
            }
        }
        if (!$submit_error) {
            $rsvp_msg = "Thank you for your RSVP!";
                    
            $party_name = $_SESSION['party_row'][1];
            $comment = $_SESSION['party_row'][3];
            $to      = 'dabram@gmail.com, eleanor.chestnut@gmail.com';
            $subject = 'RSVP update for: ' . $party_name;
            $message = "Party Responses Key: indices 5,6,7 are responses for rehearsal, wedding, brunch, respectively.\rParty Responses: " . print_r($_SESSION['guests_array'], true ) . "\rComment: " . $comment;
            $headers = 'From: david@eleanoranddavid.com' . "\r\n" .
                'Reply-To: david@eleanoranddavid.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
        }
        mysqli_close($conn); //Close connection

    }
    else {  
            $rsvp_msg = "Submission not stored: Please select a response for each guest and event.";
            $party_name = $_SESSION['party_row'][1];
            $comment = $_SESSION['comment'];
            $to      = 'dabram@gmail.com, eleanor.chestnut@gmail.com';
            $subject = 'Incomplete RSVP submission for: ' . $party_name;
            $message = "Party Responses Key: indices 5,6,7 are responses for rehearsal, wedding, brunch, respectively.\rAttempted party Responses: " . print_r($_SESSION['guests_array'], true ) . "\rComment: " . $comment;
            $headers = 'From: david@eleanoranddavid.com' . "\r\n" .
                'Reply-To: david@eleanoranddavid.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
    }
    
    include 'party_form.html.php';
}

?>