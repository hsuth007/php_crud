<?php
include_once 'core.php';
$pdo = pdo_conn();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
// Check if POST variable "name" exists, if not default to blank
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
    
    // Insert new record into the contacts table
    $query = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?)');
    $query->execute([$id, $name, $email, $phone, $created]);

    // Output message
    $msg = 'Created Successfully!';
}
?>

<?= header_template('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="name" placeholder="First and Last Name" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="username@email.com.com" id="email">
        <input type="text" name="phone" placeholder="123456789" id="phone">
        <label for="created">Created</label>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=footer_template()?>
