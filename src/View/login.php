<?php

session_start();

if (isset($_SESSION['errors']['login'])) {
    $login_error = $_SESSION['errors']['login'];

    unset($_SESSION['errors']['login']);
}

?>

<form method="post">
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="submit" name="submit" value="Login">
    <?php if (isset($login_error)): ?>
        <p><?= $login_error ?></p>
    <?php endif ?>
</form>