<?php 
//Variables. 
$user_email = 'saini1.rs.ravi@gmail.com'; 
$user_name = 'ravi saini'; 
$user_subject = 'mail test'; 
$user_comment = 'no comment'; 
$user_send = 'codewinners'; 
$user_check = stripos("$user_email","@"); 
//Body of the email to be sent. 
$body_mail = "Hello YOURANME, someone wants to contact you.. Details..  
Name: $user_name   
Email: $user_email  
subject: $user_subject 
Comment: $user_comment."; 
//Body of the Email for the user requesting a copy. 
$body_email = " 
Here is a copy of the email. 
Your Name: $user_name . 
Your Email: $user_email.  
Your subject: $user_subject. 
Your Comment: $user_comment. 
Thank you for contacting us, we'll reply ASAP. 
Yourwebsite team."; 
//Check if the user submited the data require. 
//If the @ is measing from the email address stop the user for continuing. 
if ($user_check) { 
echo ""; 
} 
else { 
echo "You can't continue with out a email address, Please enter a email address."; 
   exit ($user_check); 
} 
if (empty($user_name)) { 
echo "<center><h2><font color='ff0000'>ERROR</font></h2></center>You didn't enter a your first name.<br>"; 
   exit(); 
} 
elseif (!$user_comment) { 
echo "<center><h2><font color='ff0000'>ERROR</h2></center></font>Please enter a comment."; 
   die(); 
} 
//Everything okay? send the e-mail.      
else { 
mail('YOUREMAIL','Email from YOURWEBITE',"$body_mail","from:YOURWEBSITE"); 
    echo "your email was sent! Thank you."; 
} 
//If the checkbox if check send a copy to the user. 
if (isset($user_send)) { 
@mail("$user_email","The copy of your information from YOURWEBSITE","$body_email","YOURWEBSITE"); 
    echo "And a copy of the Email was send to you!"; 
} 
else { 
     die($user_send); 
} 
?> 