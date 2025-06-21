<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: contact_form.html?status=error"); // Redirect with error
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact_form.html?status=error"); // Redirect with error
        exit;
    }

    // Recipient email address
    $to = "jacek.salczynski123@gmail.com"; // **CHANGE THIS to your actual email address**

    // Email headers
    $headers = "From: " . $name . " <" . $email . ">\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Email body
    $email_body = "Otrzymano nową wiadomość z formularza kontaktowego.\n\n";
    $email_body .= "Imię i Nazwisko: " . $name . "\n";
    $email_body .= "E-mail: " . $email . "\n";
    $email_body .= "Temat: " . $subject . "\n";
    $email_body .= "Wiadomość:\n" . $message . "\n";

    // Attempt to send the email
    if (mail($to, $subject, $email_body, $headers)) {
        header("Location: contact_form.html?status=success"); // Redirect with success
        exit;
    } else {
        header("Location: contact_form.html?status=error"); // Redirect with error
        exit;
    }
} else {
    // If someone tries to access process_form.php directly without a POST request
    header("Location: contact_form.html");
    exit;
}
?>