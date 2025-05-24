<?php
$controller = 'board_price';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2>Board</h2>
<div class="mb-3">
    <label class="form-label">Hotel</label>
    <select class="form-select" onchange="window.location='?controller=board_price&action=index&hotel_id='+this.value">
        <?php foreach ($hotels as $hotel): ?>
            <option value="<?php echo $hotel->id; ?>" <?php echo $selectedHotelId == $hotel->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($hotel->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Room Type</label>
    <select class="form-select" onchange="window.location='?controller=board_price&action=index&hotel_id=<?php echo $selectedHotelId; ?>&room_type_id='+this.value">
        <?php foreach ($roomTypes as $roomType): ?>
            <option value="<?php echo $roomType->id; ?>" <?php echo $selectedRoomTypeId == $roomType->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($roomType->description); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<a href="?controller=board_price&action=form&room_type_id=<?php echo $selectedRoomTypeId; ?>" class="btn btn-primary mb-3">Add Board Price</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SN</th>
            <th>Board Type</th>
            <th>Rate</th>
            <th>Currency</th>
            <th>IsDefault</th>
            <th>Remark</th>
            <th>Account</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($boardPrices as $boardPrice): ?>
        <tr>
            <td><?php echo $boardPrice->id; ?></td>
            <td><?php echo htmlspecialchars($boardPrice->board_type); ?></td>
            <td><?php echo $boardPrice->amount; ?></td>
            <td><?php echo htmlspecialchars($boardPrice->currency_code); ?></td>
            <td><?php echo $boardPrice->is_default ? '✔' : ''; ?></td>
            <td><?php echo htmlspecialchars($boardPrice->remark ?? ''); ?></td>
            <td><?php echo htmlspecialchars($boardPrice->account); ?></td>
            <td>
                <a href="?controller=board_price&action=form&id=<?php echo $boardPrice->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="?controller=board_price&action=delete&id=<?php echo $boardPrice->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>