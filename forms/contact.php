<?php
// Requires the "PHP Email Form" library
$receiving_email_address = 'tamjid15-5542@diu.edu.bd';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate required fields
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        die('All fields are required.');
    }

    // Validate email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }

    // Ensure the PHP Email Form library exists
    $php_email_form = '../assets/vendor/php-email-form/php-email-form.php';
    
    if (file_exists($php_email_form)) {
        include($php_email_form);
    } else {
        die('Unable to load the "PHP Email Form" Library!');
    }

    // Create new email form instance
    $contact = new PHP_Email_Form;
    $contact->ajax = true;
    
    $contact->to = $receiving_email_address;
    $contact->from_name = htmlspecialchars($_POST['name']);
    $contact->from_email = htmlspecialchars($_POST['email']);
    $contact->subject = htmlspecialchars($_POST['subject']);

    // SMTP Configuration (Optional)
    /*
    $contact->smtp = array(
        'host' => 'smtp.example.com',
        'username' => 'your_username',
        'password' => 'your_password',
        'port' => '587'
    );
    */

    // Add message content
    $contact->add_message($_POST['name'], 'From');
    $contact->add_message($_POST['email'], 'Email');
    $contact->add_message($_POST['message'], 'Message', 10);

    // Send the email
    echo $contact->send();
} else {
    die('Invalid request method.');
}
?>
