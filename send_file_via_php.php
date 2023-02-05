<?php
if(isset($_POST['send'])) {
    $to = 'recipient@example.com';
    $subject = 'Test Email';
    $message = 'This is a test email sent from a PHP script.';
    $headers = 'From: sender@example.com' . "\r\n" .
        'Reply-To: sender@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)) {
        echo 'Email sent successfully!';
    } else {
        echo 'Email sending failed.';
    }
}
?>
<form method="post">
    <input type="submit" name="send" value="Send Email">
</form>



<?php
if(isset($_POST['send'])) {
    $to = 'recipient@example.com';
    $subject = 'Test Email with Attachment';
    $message = 'Please find the attached file.';
    $headers = 'From: sender@example.com' . "\r\n" .
        'Reply-To: sender@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    
    $file = 'path/to/your/file.doc';
    $file_size = filesize($file);
    $handle = fopen($file, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $content = chunk_split(base64_encode($content));
    $uid = md5(uniqid(time()));
    $name = basename($file);
    
    $header = "From: sender@example.com\r\n";
    $header .= "Reply-To: sender@example.com\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
    $header .= "This is a multi-part message in MIME format.\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
    $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $header .= $message."\r\n\r\n";
    $header .= "--".$uid."\r\n";
    $header .= "Content-Type: application/octet-stream; name=\"".$name."\"\r\n";
    $header .= "Content-Transfer-Encoding: base64\r\n";
    $header .= "Content-Disposition: attachment; filename=\"".$name."\"\r\n\r\n";
    $header .= $content."\r\n\r\n";
    $header .= "--".$uid."--";
    
    if(mail($to, $subject, "", $header)) {
        echo 'Email sent successfully!';
    } else {
        echo 'Email sending failed.';
    }
}
?>
<form method="post">
    <input type="submit" name="send" value="Send Email with Attachment">
</form>