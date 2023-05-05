<?php


if (isset($_SESSION['errors']['login'])) {
    // Set login error in variable
    $login_error = $_SESSION['errors']['login'];

    // Remove error message from session
    unset($_SESSION['errors']['login']);
} elseif (isset($_SESSION['successes']['register'])) {
    // Set register success message in variable
    $register_success = $_SESSION['successes']['register'];

    // Remove success message from session
    unset($_SESSION['successes']['register']);
}

?>

<form method="post">
    <input type="email" name="email" id="email" placeholder="Email">
    <input type="password" name="password" id="password" placeholder="Password">
    <input type="submit" name="submit" value="Login">
    <?php if (isset($login_error)): ?>
        <p><?= $login_error ?></p>
    <?php elseif (isset($register_success)): ?>
        <p><?= $register_success ?></p>
    <?php endif ?>
</form>