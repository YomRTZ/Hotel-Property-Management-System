<?php
$controller = 'board_price';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2><?php echo $boardPrice ? 'Edit' : 'Add'; ?> Board Price</h2>
<form method="POST" action="?controller=board_price&action=save">
    <input type="hidden" name="id" value="<?php echo $boardPrice->id ?? ''; ?>">
    <div class="mb-3">
        <label class="form-label">Hotel</label>
        <select class="form-select" onchange="window.location='?controller=board_price&action=form&hotel_id='+this.value">
            <?php foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel->id; ?>" <?php echo (isset($boardPrice->room_type->hotel_id) && $boardPrice->room_type->hotel_id == $hotel->id) || ($_GET['hotel_id'] ?? '' == $hotel->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Room Type</label>
        <select name="room_type_id" class="form-select" required>
            <?php foreach ($roomTypes as $roomType): ?>
                <option value="<?php echo $roomType->id; ?>" <?php echo (isset($boardPrice->room_type_id) && $boardPrice->room_type_id == $roomType->id) || ($_GET['room_type_id'] ?? '' == $roomType->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($roomType->description); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Board Type</label>
        <select name="board_type" class="form-select" required>
            <option value="Bed and Breakfast" <?php echo isset($boardPrice->board_type) && $boardPrice->board_type == 'Bed and Breakfast' ? 'selected' : ''; ?>>Bed and Breakfast</option>
            <option value="Room Only" <?php echo isset($boardPrice->board_type) && $boardPrice->board_type == 'Room Only' ? 'selected' : ''; ?>>Room Only</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Rate</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="<?php echo $boardPrice->amount ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Currency</label>
        <select name="currency_code" class="form-select" required>
            <?php foreach ($currencies as $currency): ?>
                <option value="<?php echo $currency->currency_code; ?>" <?php echo isset($boardPrice->currency_code) && $boardPrice->currency_code == $currency->currency_code ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($currency->currency_code); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_default" class="form-check-input" value="1" <?php echo isset($boardPrice->is_default) && $boardPrice->is_default ? 'checked' : ''; ?>>
        <label class="form-check-label">Is Default</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Remark</label>
        <input type="text" name="remark" class="form-control" value="<?php echo $boardPrice->remark ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Account</label>
        <input type="text" name="account" class="form-control" value="<?php echo $boardPrice->account ?? '412-001'; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="?controller=board_price&action=index&room_type_id=<?php echo $_GET['room_type_id'] ?? $boardPrice->room_type_id; ?>" class="btn btn-secondary">Cancel</a>
</form>