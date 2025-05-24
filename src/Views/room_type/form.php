<?php
$controller = 'room_type';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2><?php echo $roomType ? 'Edit' : 'Add'; ?> Room Type</h2>
<form method="POST" action="?controller=room_type&action=save">
    <input type="hidden" name="id" value="<?php echo $roomType->id ?? ''; ?>">
    <div class="mb-3">
        <label class="form-label">Hotel</label>
        <select name="hotel_id" class="form-select" required>
            <?php foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel->id; ?>" <?php echo (isset($roomType->hotel_id) && $roomType->hotel_id == $hotel->id) || ($_GET['hotel_id'] ?? '' == $hotel->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Room Type Description</label>
        <input type="text" name="description" class="form-control" value="<?php echo $roomType->description ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Clip Or Picture</label>
        <input type="text" name="clip_or_picture" class="form-control" value="<?php echo $roomType->clip_or_picture ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Remark</label>
        <input type="text" name="remark" class="form-control" value="<?php echo $roomType->remark ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Account</label>
        <input type="text" name="account" class="form-control" value="<?php echo $roomType->account ?? '411-001'; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="?controller=room_type&action=index&hotel_id=<?php echo $_GET['hotel_id'] ?? $roomType->hotel_id; ?>" class="btn btn-secondary">Cancel</a>
</form>