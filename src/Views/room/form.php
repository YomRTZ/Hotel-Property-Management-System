<?php
$controller = 'room';
$view = __FILE__;

include __DIR__ . '/../layouts/main.php';
?>

<h2><?php echo $room ? 'Edit' : 'Add'; ?> Room</h2>
<form method="POST" action="?controller=room&action=save">
    <input type="hidden" name="id" value="<?php echo $room->id ?? ''; ?>">
    <div class="mb-3">
        <label class="form-label">Hotel</label>
        <select class="form-select" onchange="window.location='?controller=room&action=form&hotel_id='+this.value">
            <?php foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel->id; ?>" <?php echo (isset($room->room_type->hotel_id) && $room->room_type->hotel_id == $hotel->id) || ($_GET['hotel_id'] ?? '' == $hotel->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Room Type</label>
        <select name="room_type_id" class="form-select" required>
            <?php foreach ($roomTypes as $roomType): ?>
                <option value="<?php echo $roomType->id; ?>" <?php echo (isset($room->room_type_id) && $room->room_type_id == $roomType->id) || ($_GET['room_type_id'] ?? '' == $roomType->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($roomType->description); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Room No</label>
        <input type="text" name="room_number" class="form-control" value="<?php echo $room->room_number ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Tel. No</label>
        <input type="text" name="telephone_extension" class="form-control" value="<?php echo $room->telephone_extension ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Location</label>
        <input type="text" name="location" class="form-control" value="<?php echo $room->location ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Room Specialization</label>
        <select name="room_specialization" class="form-select">
            <option value="None" <?php echo isset($room->room_specialization) && $room->room_specialization == 'None' ? 'selected' : ''; ?>>None</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">No Of Bed</label>
        <input type="number" name="no_of_bed" class="form-control" value="<?php echo $room->no_of_bed ?? ''; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Change To</label>
        <select name="change_to" class="form-select">
            <option value="Family Room" <?php echo isset($room->change_to) && $room->change_to == 'Family Room' ? 'selected' : ''; ?>>Family Room</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Remark</label>
        <input type="text" name="remark" class="form-control" value="<?php echo $room->remark ?? ''; ?>">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="?controller=room&action=index&room_type_id=<?php echo $_GET['room_type_id'] ?? $room->room_type_id; ?>" class="btn btn-secondary">Cancel</a>
</form>