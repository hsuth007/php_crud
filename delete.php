<?php
include 'core.php';
$pdo = pdo_conn();
$msg = '';
// Check if contact ID exists
if (isset($_GET['id'])) {
    // Select the id that is being deleted
    $query = $pdo->prepare('SELECT * FROM contacts WHERE id = ?');
    $query->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
    // Confirmation from user input
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // Proceed with delete once user affirms
            $query = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
            $query->execute([$_GET['id']]);
            $msg = 'You have deleted the contact!';
        } else {
            // Redirect user to read page if user clicks no
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=header_template('Delete')?>

<div class="content delete">
	<h2>Delete Contact #<?=$contact['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Delete contact #<?=$contact['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$contact['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$contact['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=footer_template()?>
