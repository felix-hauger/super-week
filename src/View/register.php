<?php

session_start();

if (isset($_SESSION['errors']['register'])) {
    // Set register error in variable
    $register_error = $_SESSION['errors']['register'];

    // Remove error message from session
    unset($_SESSION['errors']['register']);
}

?>

<form method="post">
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="password" name="confirm" id="confirm" placeholder="Password Confirmation">
    <input type="text" name="firstname" id="firstname" placeholder="First name">
    <input type="text" name="lastname" id="lastname" placeholder="Last name">
    <input type="submit" name="submit" value="Register">
    <?php if (isset($register_error)): ?>
        <p><?= $register_error ?></p>
    <?php endif ?>
</form>