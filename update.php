<?php
include 'core.php';
$pdo = pdo_conn();
$msg = '';
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');
        // Update statement
        $query = $pdo->prepare('UPDATE contacts SET id = ?, name = ?, email = ?, phone = ?, created = ? WHERE id = ?');
        $query->execute([$id, $name, $email, $phone, $created, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Fetch results from contact table
    $query = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $query->execute([$_GET['id']]);
    $contact = $query->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?= header_template('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="name">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$contact['id']?>" id="id">
        <input type="text" name="name" placeholder="Full Name" value="<?=$contact['name']?>" id="name">
        <label for="email">Email</label>
        <label for="phone">Phone</label>
        <input type="text" name="email" placeholder="username@email.com" value="<?=$contact['email']?>" id="email">
        <input type="text" name="phone" placeholder="123456789" value="<?=$contact['phone']?>" id="phone">
        <label for="created">Created</label>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=footer_template()?>
