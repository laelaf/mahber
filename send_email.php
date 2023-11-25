<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $message = $_POST['message'];

    // Email recipient and subject
    $to = 'nsagiraju59@gwu.edu';
    $subject = 'New Contact Form Submission';

    // Compose the email
    $emailBody = "Name: $firstName $lastName\n";
    $emailBody .= "Email: $email\n";
    $emailBody .= "Phone Number: $phoneNumber\n";
    $emailBody .= "Message: $message\n";

    // Email headers
    $headers = "From: mahber-contact@example.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $subject, $emailBody, $headers)) {
        echo "Email sent successfully!";
        // Redirect or display a success message
    } else {
        echo "Email sending failed.";
        // Redirect or display an error message
    }
}
?>
