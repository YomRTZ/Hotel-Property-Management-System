<?php
$controller = 'room';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2>Room</h2>
<div class="mb-3">
    <label class="form-label">Hotel</label>
    <select class="form-select" onchange="window.location='?controller=room&action=index&hotel_id='+this.value">
        <?php foreach ($hotels as $hotel): ?>
            <option value="<?php echo $hotel->id; ?>" <?php echo $selectedHotelId == $hotel->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($hotel->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Room Type</label>
    <select class="form-select" onchange="window.location='?controller=room&action=index&hotel_id=<?php echo $selectedHotelId; ?>&room_type_id='+this.value">
        <?php foreach ($roomTypes as $roomType): ?>
            <option value="<?php echo $roomType->id; ?>" <?php echo $selectedRoomTypeId == $roomType->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($roomType->description); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<a href="?controller=room&action=form&room_type_id=<?php echo $selectedRoomTypeId; ?>" class="btn btn-primary mb-3">Add Room</a>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>SN</th>
            <th>Room No</th>
            <th>Tel. No</th>
            <th>Location</th>
            <th>Room Specialization</th>
            <th>NoOfBed</th>
            <th>Change To</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?php echo $room->id; ?></td>
            <td><?php echo htmlspecialchars($room->room_number); ?></td>
            <td><?php echo htmlspecialchars($room->telephone_extension); ?></td>
            <td><?php echo htmlspecialchars($room->location); ?></td>
            <td><?php echo htmlspecialchars($room->room_specialization); ?></td>
            <td><?php echo $room->no_of_bed; ?></td>
            <td><?php echo htmlspecialchars($room->change_to); ?></td>
            <td>
                <a href="?controller=room&action=form&id=<?php echo $room->id; ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="?controller=room&action=delete&id=<?php echo $room->id; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>