<?php

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'vendor/PHPMailer/src/Exception.php';
  require 'vendor/PHPMailer/src/PHPMailer.php';
  require 'vendor/PHPMailer/src/SMTP.php';

  require("includes/init.php");

  $email = '';
  $subject = '';
  $message = '';
  $sent = false;

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $errors = [];

  if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $errors[] = "Please enter a valid email address";
  }
  if($subject == '') {
    $errors[] = "Please enter a subject";
  }
  if($message == '') {
    $errors[] = "Please enter a message";
  }

  if (empty($errors)) {
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();
        $mail->Host = HOST;
        $mail->SMTPAuth = true;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($email);
        $mail->addAddress($mail->Username) ;
        $mail->addReplyTo($email);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();

        $sent = true;

    } catch (Exception $e) {

        $errors = $mail->ErrorInfo;
    }
  }

}
?>

<?php require("includes/header.php"); ?>

  <h2>Contact Us</h2>

  <?php if($sent):?>
    Message sent!
  <?php else: ?>

    <?php if(!empty($errors)): ?>
      <?php foreach($errors as $error):?>
        <ul>
          <li>
            <?= $error; ?>
          </li>
        </ul>
      <?php endforeach;?>
    <?php endif;?>

    <form method="post" id="formContact">
      <div class="form-group">
        <label for="email">Your Email</label>
        <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?= htmlspecialchars($email); ?>"/>
      </div>

      <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" value="<?= htmlspecialchars($subject); ?>"/>
      </div>

      <div class="form-group">
        <label for="message">Message</label>
        <textarea name="message" class="form-control" id="message" placeholder="Message" value="<?= htmlspecialchars($message); ?>"></textarea>
      </div>

      <button class="btn btn-primary">Send</button>
    </form>
<?php endif;?>

<?php require("includes/footer.php");?>
