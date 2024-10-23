<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'D:/xampp/htdocs/ab/customers/PHPMailer/src/Exception.php';
require 'D:/xampp/htdocs/ab/customers/PHPMailer/src/PHPMailer.php';
require 'D:/xampp/htdocs/ab/customers/PHPMailer/src/SMTP.php';

// Database connection settings
$servername = "localhost";
$username = "root";  // Adjust as needed
$password = "";      // Adjust as needed
$dbname = "fashion"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert the data into the database
    $sql = "INSERT INTO contact_messages (name, email, subject, message)
            VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "Message saved to database successfully!";
        
        // Now, send email confirmation using PHPMailer
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Use your SMTP host
            $mail->SMTPAuth   = true;
            $mail->Username   = 'sulfathpm20@gmail.com';  // Your email address
            $mail->Password   = '3434';   // Your email password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('your-email@gmail.com', 'Custom Dress Team');
            $mail->addAddress($email, $name);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Confirmation: We\'ve received your message';
            $mail->Body    = "Hi $name,<br><br>Thank you for getting in touch with us! We have received your message and will get back to you soon.<br><br>Best regards,<br>Custom Dress Team";

            // Send the email
            $mail->send();
            echo 'Email sent successfully!';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close connection
$conn->close();
?>
