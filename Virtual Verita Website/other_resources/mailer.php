<?php

session_start();
$_SESSION['firstname'] = $_POST['firstname'];
$_SESSION['lastname'] = $_POST['lastname'];
$_SESSION['phone'] = $_POST['phone'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['comments'] = $_POST['comments'];

$firstname = preg_replace("/\r/", "", $_SESSION['firstname']);
$firstname = preg_replace("/\n/", "", $firstname);
$lastname = preg_replace("/\r/", "", $_SESSION['lastname']);
$lastname = preg_replace("/\n/", "", $lastname);
$phone = preg_replace("/\r/", "", $_SESSION['phone']);
$phone = preg_replace("/\n/", "", $phone);
$email = preg_replace("/\r/", "", $_SESSION['email']);
$email = preg_replace("/\n/", "", $email);
$comments = preg_replace("/\r/", "", $_SESSION['comments']);
$comments = preg_replace("/\n/", "", $comments);

$spchar = array("%", "/", "#", "-", "&", '"', "'", ";");
$good = array(" percent", "", "num ", " ", " and ", " inch ", "", " "); 

$firstname = str_replace($spchar, $good, "$firstname");
$lastname = str_replace($spchar, $good, "$lastname");
$phone = str_replace($spchar, $good, "$phone");
$email = str_replace($spchar, $good, "$email");
$comments = str_replace($spchar, $good, "$comments");

$regex = '/^[_a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*@[a-zA-Z0-9]+\.[a-zA-Z0-9-]+$/';
   
if(!$_SESSION['firstname'] || !$_SESSION['lastname'] || !$_SESSION['phone'] || !$_SESSION['email'] || !$_SESSION['comments']) {
   $_SESSION['formMessage'] = "Please fill out all the fields.\n";
   Header("Location:contact.html");
   exit();
} 
else 
{
   if (!preg_match($regex, $email))
   {
      $_SESSION['formMessage'] = "Invalid Email Address<br /> Please enter a valid Email Address\n";
      Header("Location:contact.html");
      exit();
   } 
   else 
   {

      if (strlen($firstname) < 2)
      {
         $_SESSION['formMessage'] = "Invalid information in Name Field<br /> Please enter a valid Name\n";
         Header("Location:contact.html");
         exit();
      } 
      else 
      {

         if (strpos($comments, "href") !== false || strpos($email, "href") !== false || strpos($comments, "http") !== false || strpos($email, "http") !== false)
         {
            $_SESSION['formMessage'] = "HTML links are not allowed the the Subject or Message area<br /> Please enter valid Information\n";
            Header("Location:contact.html");
            exit();
         } 
         else 
         { 

            $email="spirit44style@gmail.com";

            $from = "Intergalactic Glamour Web Site <$email>";

            $subject="Contact Request from $firstname $lastname";

            $message = "\nName: $firstname $lastname\n\nEmail Address: $email\n\nSubject: $subject\n\nPhone Number: $phone\n\n\nMessage: $comments\n";

            $headers="From: $from\n";

            SESSION_UNREGISTER('firstname');
            SESSION_UNREGISTER('lastname');
            SESSION_UNREGISTER('phone');
            SESSION_UNREGISTER('email');
            SESSION_UNREGISTER('comments');

            if (@mail($email, $subject, $message, $headers)) 
            {
               $_SESSION["formMessage"] = "		".'Thank you, your email has been sent'."";
               Header("Location:contact.html");
            } 
            else 
            {
               $_SESSION["formMessage"] = "I'm sorry, there seems to have been an error trying to send your email. Please try again.";
               Header("Location:contact.html");
            }
         }
      }
   }
}

?>
