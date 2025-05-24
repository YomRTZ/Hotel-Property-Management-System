<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $hotel ? 'Edit' : 'Add'; ?> Hotel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2><?php echo $hotel ? 'Edit' : 'Add'; ?> Hotel</h2>
        <form method="POST" action="?controller=hotel&action=save">
            <input type="hidden" name="id" value="<?php echo $hotel['Id'] ?? ''; ?>">
            <div class="mb-3">
                <label class="form-label">Hotel Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $hotel['Name'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Grade</label>
                <select name="grade" class="form-select" required>
                    <option value="1" <?php echo isset($hotel['Grade']) && $hotel['Grade'] == 1 ? 'selected' : ''; ?>>1 star</option>
                    <option value="4" <?php echo isset($hotel['Grade']) && $hotel['Grade'] == 4 ? 'selected' : ''; ?>>4 star</option>
                </select>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="isDefault" class="form-check-input" value="1" <?php echo isset($hotel['isDefault']) && $hotel['isDefault'] ? 'checked' : ''; ?>>
                <label class="form-check-label">Is Default</label>
            </div>
            <div class="mb-3">
                <label class="form-label">Remark</label>
                <input type="text" name="remark" class="form-control" value="<?php echo $hotel['Remark'] ?? ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="?controller=hotel&action=index" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>