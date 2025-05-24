<?php
$controller = 'room_rate';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2>Room Rate</h2>
<div class="mb-3">
    <label class="form-label">Hotel</label>
    <select class="form-select" onchange="window.location='?controller=room_rate&action=index&hotel_id='+this.value">
        <?php foreach ($hotels as $hotel): ?>
            <option value="<?php echo $hotel->id; ?>" <?php echo $selectedHotelId == $hotel->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($hotel->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Room Type</label>
    <select class="form-select" onchange="window.location='?controller=room_rate&action=index&hotel_id=<?php echo $selectedHotelId; ?>&room_type_id='+this.value">
        <?php foreach ($roomTypes as $roomType): ?>
            <option value="<?php echo $roomType->id; ?>" <?php echo $selectedRoomTypeId == $roomType->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($roomType->description); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<a href="?controller=room_rate&action=form&room_type_id=<?php echo $selectedRoomTypeId; ?>" class="btn btn-primary mb-3">Add Room Rate</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SN</th>
            <th>Season</th>
            <th>Rate Description</th>
            <th>Rate</th>
            <th>IsDefault</th>
            <th>Currency</th>
            <th>Board Price</th>
            <th>Price Tag</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roomRates as $roomRate): ?>
        <tr>
            <td><?php echo $roomRate->id; ?></td>
            <td><?php echo htmlspecialchars($roomRate->season); ?></td>
            <td><?php echo htmlspecialchars($roomRate->rate_description); ?></td>
            <td><?php echo $roomRate->rate; ?></td>
            <td><?php echo $roomRate->is_default ? '✔' : ''; ?></td>
            <td><?php echo htmlspecialchars($roomRate->currency_code); ?></td>
            <td><?php echo $roomRate->board_price_id ? htmlspecialchars(R::load('board_price', $roomRate->board_price_id)->board_type) : ''; ?></td>
            <td><?php echo htmlspecialchars($roomRate->price_tag); ?></td>
            <td>
                <a href="?controller=room_rate&action=form&id=<?php echo $roomRate->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="?controller=room_rate&action=delete&id=<?php echo $roomRate->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>