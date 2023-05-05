<form method="post">
    <input type="text" name="title" id="title" placeholder="Title">
    <textarea name="" id="" cols="20" rows="8" placeholder="Summary"></textarea>
    <textarea name="" id="" cols="40" rows="20" placeholder="Write your book here..."></textarea>
    <input type="submit" name="submit" value="Submit">
    <?php if (isset($register_error)): ?>
        <p><?= $register_error ?></p>
    <?php endif ?>
</form>