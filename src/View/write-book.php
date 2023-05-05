<?php
session_start();

if (isset($_SESSION['errors']['write_book'])) {
    // Set write_book error in variable
    $write_book_error = $_SESSION['errors']['write_book'];

    // Remove error message from session
    unset($_SESSION['errors']['write_book']);
} elseif (isset($_SESSION['successes']['write_book'])) {
    // Set write_book success message in variable
    $write_book_success = $_SESSION['successes']['write_book'];

    // Remove success message from session
    unset($_SESSION['successes']['write_book']);
}
?>

<form method="post">
    <input type="text" name="title" id="title" placeholder="Title">
    <textarea name="summary" id="summary" cols="20" rows="8" placeholder="Summary"></textarea>
    <textarea name="content" id="content" cols="40" rows="20" placeholder="Write your book here..."></textarea>
    <input type="submit" name="submit" value="Submit">
    <?php if (isset($write_book_error)): ?>
        <p><?= $write_book_error ?></p>
    <?php elseif (isset($write_book_success)): ?>
        <p><?= $write_book_success ?></p>
    <?php endif ?>
</form>