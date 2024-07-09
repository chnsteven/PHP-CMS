<?php require_once('../../../private/initialize.php');
$pages = find_all_pages();
?>

<?php $page_title = 'Pages'; ?>
<?php include(PRIVATE_HEADER); ?>

<div id="content">
    <div class="page listing">
        <h1>Pages</h1>

        <div class="actions">
            <a class="action" href="<?php echo url_for('/staff/pages/new.php'); ?>">Create New Page</a>
        </div>

        <table class="list">
            <tr>
                <th>ID</th>
                <th>Page Name</th>
                <th>Position</th>
                <th>Visible</th>
                <th>Content</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php while ($page = mysqli_fetch_assoc($pages)) { ?>
                <tr>
                    <td><?php echo h($page['id']); ?></td>
                    <td><?php echo h($page['page_name']); ?></td>
                    <td><?php echo h($page['position']); ?></td>
                    <td><?php echo h($page['visible']); ?></td>
                    <td><?php echo h($page['content']); ?></td>
                    <td><a class="action" href="<?php echo url_for('/staff/pages/show.php?id=' . h(u($page['id']))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </table>

        <?php
        mysqli_free_result($pages);
        ?>
    </div>

</div>

<?php include(PRIVATE_FOOTER); ?>