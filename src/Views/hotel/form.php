<?php
$controller = 'hotel';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2><?php echo $hotel ? 'Edit' : 'Add'; ?> Hotel</h2>
<form method="POST" action="?controller=hotel&action=save">
    <input type="hidden" name="id" value="<?php echo $hotel->id ?? ''; ?>">
    <div class="mb-3">
        <label class="form-label">Hotel Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $hotel->name ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Grade</label>
        <select name="grade" class="form-select" required>
            <option value="1" <?php echo isset($hotel->grade) && $hotel->grade == 1 ? 'selected' : ''; ?>>1 star</option>
            <option value="4" <?php echo isset($hotel->grade) && $hotel->grade == 4 ? 'selected' : ''; ?>>4 star</option>
        </select>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_default" class="form-check-input" value="1" <?php echo isset($hotel->is_default) && $hotel->is_default ? 'checked' : ''; ?>>
        <label class="form-check-label">Is Default</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Remark</label>
        <input type="text" name="remark" class="form-control" value="<?php echo $hotel->remark ?? ''; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="?controller=hotel&action=index" class="btn btn-secondary">Cancel</a>
</form>