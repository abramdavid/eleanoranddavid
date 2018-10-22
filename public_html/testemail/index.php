<?php
$party_name = "Best Bride and Groom Ever";
$comment = "This is a comment.";
$guests_array = array(array("rebecca", "roth", "1", "adult",1,0,1), array("melina", "marini", "1", "adult",1,0,1));
$to      = 'dabram@gmail.com, eleanor.chestnut@gmail.com';
$subject = 'RSVP update for: ' . $party_name;
$message = "Party Responses: " . print_r( $guests_array, true ) . "\rComment: " . $comment;
$headers = 'From: david@eleanoranddavid.com' . "\r\n" .
    'Reply-To: david@eleanoranddavid.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
?> 