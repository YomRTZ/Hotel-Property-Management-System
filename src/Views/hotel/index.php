<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
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
                    <td><?php echo $hotel['Id']; ?></td>
                    <td><?php echo htmlspecialchars($hotel['Name']); ?></td>
                    <td><?php echo $hotel['Grade']; ?> star</td>
                    <td><?php echo $hotel['isDefault'] ? '✔' : ''; ?></td>
                    <td><?php echo htmlspecialchars($hotel['Remark'] ?? ''); ?></td>
                    <td>
                        <a href="?controller=hotel&action=form&id=<?php echo $hotel['Id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="?controller=hotel&action=delete&id=<?php echo $hotel['Id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>