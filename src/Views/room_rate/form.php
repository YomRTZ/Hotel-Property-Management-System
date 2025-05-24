<?php
$controller = 'room_rate';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2><?php echo $roomRate ? 'Edit' : 'Add'; ?> Room Rate</h2>
<form method="POST" action="?controller=room_rate&action=save">
    <input type="hidden" name="id" value="<?php echo $roomRate->id ?? ''; ?>">
    <div class="mb-3">
        <label class="form-label">Hotel</label>
        <select class="form-select" onchange="window.location='?controller=room_rate&action=form&hotel_id='+this.value">
            <?php foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel->id; ?>" <?php echo (isset($roomRate->room_type->hotel_id) && $roomRate->room_type->hotel_id == $hotel->id) || ($_GET['hotel_id'] ?? '' == $hotel->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Room Type</label>
        <select name="room_type_id" class="form-select" required>
            <?php foreach ($roomTypes as $roomType): ?>
                <option value="<?php echo $roomType->id; ?>" <?php echo (isset($roomRate->room_type_id) && $roomRate->room_type_id == $roomType->id) || ($_GET['room_type_id'] ?? '' == $roomType->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($roomType->description); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Season</label>
        <select name="season" class="form-select" required>
            <option value="10_Normal Season" <?php echo isset($roomRate->season) && $roomRate->season == '10_Normal Season' ? 'selected' : ''; ?>>10_Normal Season</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Rate Description</label>
        <select name="rate_description" class="form-select" required>
            <option value="Normal Price" <?php echo isset($roomRate->rate_description) && $roomRate->rate_description == 'Normal Price' ? 'selected' : ''; ?>>Normal Price</option>
            <option value="Rack Rate" <?php echo isset($roomRate->rate_description) && $roomRate->rate_description == 'Rack Rate' ? 'selected' : ''; ?>>Rack Rate</option>
            <option value="World Vision" <?php echo isset($roomRate->rate_description) && $roomRate->rate_description == 'World Vision' ? 'selected' : ''; ?>>World Vision</option>
            <option value="Un" <?php echo isset($roomRate->rate_description) && $roomRate->rate_description == 'Un' ? 'selected' : ''; ?>>Un</option>
            <option value="Discounted" <?php echo isset($roomRate->rate_description) && $roomRate->rate_description == 'Discounted' ? 'selected' : ''; ?>>Discounted</option>
            <option value="Discounted 2" <?php echo isset($roomRate->rate_description) && $roomRate->rate_description == 'Discounted 2' ? 'selected' : ''; ?>>Discounted 2</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Rate</label>
        <input type="number" step="0.01" name="rate" class="form-control" value="<?php echo $roomRate->rate ?? ''; ?>" required>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_default" class="form-check-input" value="1" <?php echo isset($roomRate->is_default) && $roomRate->is_default ? 'checked' : ''; ?>>
        <label class="form-check-label">Is Default</label>
    </div>
    <div class="mb-3">
        <label class="form-label">Currency</label>
        <select name="currency_code" class="form-select" required>
            <?php foreach ($currencies as $currency): ?>
                <option value="<?php echo $currency->currency_code; ?>" <?php echo isset($roomRate->currency_code) && $roomRate->currency_code == $currency->currency_code ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($currency->currency_code); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Board Price</label>
        <select name="board_price_id" class="form-select">
            <option value="">None</option>
            <?php foreach ($boardPrices as $boardPrice): ?>
                <option value="<?php echo $boardPrice->id; ?>" <?php echo isset($roomRate->board_price_id) && $roomRate->board_price_id == $boardPrice->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($boardPrice->board_type); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Price Tag</label>
        <select name="price_tag" class="form-select">
            <option value="NONE" <?php echo isset($roomRate->price_tag) && $roomRate->price_tag == 'NONE' ? 'selected' : ''; ?>>NONE</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Remark</label>
        <input type="text" name="remark" class="form-control" value="<?php echo $roomRate->remark ?? ''; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="?controller=room_rate&action=index&room_type_id=<?php echo $_GET['room_type_id'] ?? $roomRate->room_type_id; ?>" class="btn btn-secondary">Cancel</a>
</form>