<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get the form data (and sanitize it!)
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));

    // 2. Validate the data
    $errors = array();
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($email) || !$email) {
        $errors[] = "Valid email is required";
    }
    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // 3. Process the data if there are no errors
    if (empty($errors)) {
        //  Replace with your actual email sending logic
        $to = "your_email@example.com";  //  Your email address
        $subject = "New Contact Form Submission";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: webmaster@example.com"; //  Set a valid From header

        if (mail($to, $subject, $body, $headers)) {
            //  Redirect to a "success" page or display a message
            header("Location: contact_success.html"); //  Create this file
            exit;
        } else {
            //  Handle email sending error (log it, show message)
            error_log("Email sending failed for contact form.");
            echo "Sorry, there was an error sending your message. Please try again later.";
        }
    } else {
        // 4. Handle errors:  Show them to the user, redirect, etc.
        echo "The following errors occurred:<br>";
        foreach ($errors as $error) {
            echo "- " . $error . "<br>";
        }
        //  You could also redirect back to the form with error messages
        //  header("Location: contact_form.html?error=...");
        //  exit;
    }
} else {
    // 5.  Respond to non-POST requests (important for security)
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Method Not Allowed";
}
?>