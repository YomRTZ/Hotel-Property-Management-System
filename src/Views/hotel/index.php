<?php
$controller = 'hotel';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2>Hotel Information</h2>
<a href="?controller=hotel&action=form" class="btn btn-primary mb-3">Add Hotel</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SN</th>
            <th>Hotel Name</th>
            <th>Grade</th>
            <th>IsDefault</th>
            <th>Remark</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hotels as $hotel): ?>
        <tr>
            <td><?php echo $hotel->id; ?></td>
            <td><?php echo htmlspecialchars($hotel->name); ?></td>
            <td><?php echo $hotel->grade; ?> star</td>
            <td><?php echo $hotel->is_default ? '✔' : ''; ?></td>
            <td><?php echo htmlspecialchars($hotel->remark ?? ''); ?></td>
            <td>
                <a href="?controller=hotel&action=form&id=<?php echo $hotel->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="?controller=hotel&action=delete&id=<?php echo $hotel->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>