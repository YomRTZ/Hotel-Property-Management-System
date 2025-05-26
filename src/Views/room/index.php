<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintain PMS - Room</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #d3d3d3;
            margin: 0;
            padding: 0;
        }
        .title-bar {
            background-color: #000080;
            color: white;
            padding: 5px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .title-bar span {
            font-size: 14px;
            font-weight: bold;
        }
        .toolbar {
            background-color: #c0c0c0;
            padding: 5px;
            display: flex;
            gap: 5px;
        }
        .toolbar button {
            background-color: #808080;
            color: white;
            border: 1px solid #000000;
            padding: 2px 10px;
            cursor: pointer;
        }
        .toolbar button:hover {
            background-color: #a9a9a9;
        }
        .nav-tabs {
            background-color: #c0c0c0;
            padding: 5px;
            display: flex;
            gap: 10px;
        }
        .nav-tabs span {
            cursor: pointer;
            padding: 2px 10px;
            background-color: #d3d3d3;
            border: 1px solid #000000;
        }
        .nav-tabs .active {
            background-color: #ffffff;
            font-weight: bold;
        }
        .table-container {
            margin: 10px;
            background-color: #ffffff;
            border: 1px solid #000000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            border: 1px solid #000000;
            text-align: left;
        }
        th {
            background-color: #c0c0c0;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr.selected {
            background-color: #000080;
            color: white;
        }
        select, input[type="checkbox"] {
            padding: 2px;
            border: 1px solid #000000;
        }
        .error { color: red; }
        .success { color: green; }
        .editable:hover {
            background-color: #e0e0e0;
            cursor: pointer;
        }
        .dropdown-container {
            margin: 10px;
            padding: 5px;
            background-color: #ffffff;
            border: 1px solid #000000;
        }
    </style>
</head>
<body>
    <div class="title-bar">
        <span>Maintain PMS</span>
    </div>
    <div class="dropdown-container">
        <label for="hotelDropdown">Select Hotel: </label>
        <select id="hotelDropdown" name="hotel_id">
            <option value="0">Select Hotel</option>
            <?php 
            error_log('Hotels in view: ' . print_r($hotels, true)); 
            foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel->id; ?>" <?php echo isset($selectedHotelId) && $selectedHotelId == $hotel->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="roomTypeDropdown">Select Room Type: </label>
        <select id="roomTypeDropdown" name="room_type_id">
            <option value="0">Select Room Type</option>
            <?php foreach ($roomTypes as $roomType): ?>
                <option value="<?php echo $roomType->id; ?>" <?php echo isset($selectedRoomTypeId) && $selectedRoomTypeId == $roomType->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($roomType->description); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="toolbar">
        <form method="post" action="index.php?action=save&tab=room" style="display:inline;">
            <button type="submit">Save</button>
        </form>
        <form method="post" action="index.php?action=delete&tab=room" style="display:inline;">
            <input type="hidden" name="id" id="deleteId" value="">
            <button type="submit" id="deleteBtn">Delete</button>
        </form>
        <form method="post" action="index.php?action=close&tab=room" style="display:inline;">
            <button type="submit">Close</button>
        </form>
    </div>
    <div class="nav-tabs">
        <span onclick="window.location.href='index.php?tab=hotel'">Hotel Information</span>
        <span onclick="window.location.href='index.php?tab=season'">Season</span>
        <span onclick="window.location.href='index.php?tab=roomtype'">Room Type</span>
        <span class="active" onclick="window.location.href='index.php?tab=room'">Room</span>
        <span onclick="window.location.href='index.php?tab=board'">Board</span>
        <span onclick="window.location.href='index.php?tab=roomrate'">Room Rate</span>
    </div>
    <div class="table-container">
        <table id="roomTable">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Room No</th>
                    <th>Tel. No</th>
                    <th>Location</th>
                    <th>Room Specialization</th>
                    <th>No of Bed</th>
                    <th>Change To</th>
                </tr>
            </thead>
            <tbody id="roomTableBody">
                <?php $sn = 1; foreach ($rooms as $room): ?>
                    <tr class="<?php echo isset($_SESSION['selected_room']) && $_SESSION['selected_room'] == $room->id ? 'selected' : ''; ?>" data-id="<?php echo $room->id; ?>" data-hotel-id="<?php echo isset($room->hotel_id) ? $room->hotel_id : ''; ?>">
                        <td><?php echo $sn++; ?></td>
                        <td class="editable" data-field="room_number" contenteditable="true"><?php echo htmlspecialchars($room->room_number ?? ''); ?></td>
                        <td class="editable" data-field="telephone_extension" contenteditable="true"><?php echo htmlspecialchars($room->telephone_extension ?? ''); ?></td>
                        <td>
                            <select data-field="location">
                                <option value="" <?php echo !$room->location ? 'selected' : ''; ?>>Select Floor</option>
                                <option value="1st floor" <?php echo $room->location === '1st floor' ? 'selected' : ''; ?>>1st floor</option>
                                <option value="2nd floor" <?php echo $room->location === '2nd floor' ? 'selected' : ''; ?>>2nd floor</option>
                                <option value="3rd floor" <?php echo $room->location === '3rd floor' ? 'selected' : ''; ?>>3rd floor</option>
                                <option value="4th floor" <?php echo $room->location === '4th floor' ? 'selected' : ''; ?>>4th floor</option>
                            </select>
                        </td>
                        <td>
                            <select data-field="room_specialization">
                                <option value="None" <?php echo $room->room_specialization === 'None' ? 'selected' : ''; ?>>None</option>
                                <option value="Not None" <?php echo $room->room_specialization === 'Not None' ? 'selected' : ''; ?>>Not None</option>
                            </select>
                        </td>
                        <td class="editable" data-field="no_of_bed" contenteditable="true"><?php echo htmlspecialchars($room->no_of_bed ?? ''); ?></td>
                        <td>
                            <select data-field="change_to">
                                <option value="" <?php echo !$room->change_to ? 'selected' : ''; ?>>Select Change To</option>
                                <?php foreach ($roomTypes as $roomType): ?>
                                    <option value="1_<?php echo htmlspecialchars($roomType->description); ?>" <?php echo $room->change_to === "1_{$roomType->description}" ? 'selected' : ''; ?>>
                                        1_<?php echo htmlspecialchars($roomType->description); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="new-row" data-id="new">
                    <td><?php echo $sn++; ?></td>
                    <td class="editable" data-field="room_number" contenteditable="true"></td>
                    <td class="editable" data-field="telephone_extension" contenteditable="true"></td>
                    <td>
                        <select data-field="location">
                            <option value="">Select Floor</option>
                            <option value="1st floor">1st floor</option>
                            <option value="2nd floor">2nd floor</option>
                            <option value="3rd floor">3rd floor</option>
                            <option value="4th floor">4th floor</option>
                        </select>
                    </td>
                    <td>
                        <select data-field="room_specialization">
                            <option value="None">None</option>
                            <option value="Not None">Not None</option>
                        </select>
                    </td>
                    <td class="editable" data-field="no_of_bed" contenteditable="true"></td>
                    <td>
                        <select data-field="change_to">
                            <option value="">Select Change To</option>
                            <?php foreach ($roomTypes as $roomType): ?>
                                <option value="1_<?php echo htmlspecialchars($roomType->description); ?>">
                                    1_<?php echo htmlspecialchars($roomType->description); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal for Deletion Error -->
    <div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteErrorModalLabel">Cannot Delete Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This room cannot be deleted because it is linked to other data.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedRow = null;

        // Handle row selection
        const rows = document.querySelectorAll('#roomTableBody tr');
        rows.forEach(row => {
            row.addEventListener('click', () => {
                rows.forEach(r => r.classList.remove('selected'));
                row.classList.add('selected');
                selectedRow = row;
                const deleteIdInput = document.getElementById('deleteId');
                deleteIdInput.value = row.dataset.id !== 'new' ? row.dataset.id : '';
                console.log('Selected Row ID:', deleteIdInput.value); // Debug: Log the selected ID
            });
        });

        // Confirm deletion
        document.getElementById('deleteBtn').addEventListener('click', function(e) {
            if (!selectedRow || selectedRow.dataset.id === 'new') {
                alert('Please select a room to delete.');
                e.preventDefault();
                return;
            }
            if (!confirm('Are you sure you want to delete this room?')) {
                e.preventDefault();
                return;
            }
            console.log('Submitting delete form with ID:', document.getElementById('deleteId').value); // Debug: Log before submission
        });

        // Handle Save button
        document.querySelector('form[action="index.php?action=save&tab=room"]').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedRow) {
                alert('Please select a row to save or use the new row.');
                return;
            }

            const id = selectedRow.dataset.id === 'new' ? '' : selectedRow.dataset.id;
            const hotelIdElement = document.getElementById('hotelDropdown');
            const roomTypeIdElement = document.getElementById('roomTypeDropdown');
            const roomNumberElement = selectedRow.querySelector('[data-field="room_number"]');
            const telephoneExtensionElement = selectedRow.querySelector('[data-field="telephone_extension"]');
            const locationElement = selectedRow.querySelector('[data-field="location"]');
            const roomSpecializationElement = selectedRow.querySelector('[data-field="room_specialization"]');
            const noOfBedElement = selectedRow.querySelector('[data-field="no_of_bed"]');
            const changeToElement = selectedRow.querySelector('[data-field="change_to"]');

            const hotel_id = hotelIdElement ? hotelIdElement.value : 0;
            const room_type_id = roomTypeIdElement ? roomTypeIdElement.value : 0;
            const room_number = roomNumberElement ? roomNumberElement.textContent.trim() : '';
            const telephone_extension = telephoneExtensionElement ? telephoneExtensionElement.textContent.trim() : '';
            const location = locationElement ? locationElement.value : '';
            const room_specialization = roomSpecializationElement ? roomSpecializationElement.value : 'None';
            const no_of_bed = noOfBedElement ? noOfBedElement.textContent.trim() : '';
            const change_to = changeToElement ? changeToElement.value : '';

            console.log('Saving:', { id, hotel_id, room_type_id, room_number, telephone_extension, location, room_specialization, no_of_bed, change_to });

            if (!room_number || !telephone_extension || !location || !no_of_bed) {
                alert('Room No, Tel. No, Location, and No of Bed are required.');
                return;
            }
            if (hotel_id == 0 || room_type_id == 0) {
                alert('Please select a hotel and room type.');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?action=save&tab=room';

            const fields = { id, hotel_id, room_type_id, room_number, telephone_extension, location, room_specialization, no_of_bed, change_to };
            for (const [key, value] of Object.entries(fields)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = value;
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
        });

        // Update hotel_id and room_type_id in URL when dropdowns change
        document.getElementById('hotelDropdown').addEventListener('change', function() {
            const hotelId = this.value;
            const roomTypeId = document.getElementById('roomTypeDropdown').value;
            window.history.pushState({}, '', `index.php?tab=room&hotel_id=${hotelId}&room_type_id=${roomTypeId}`);
        });

        document.getElementById('roomTypeDropdown').addEventListener('change', function() {
            const hotelId = document.getElementById('hotelDropdown').value;
            const roomTypeId = this.value;
            window.history.pushState({}, '', `index.php?tab=room&hotel_id=${hotelId}&room_type_id=${roomTypeId}`);
        });

        // Show error modal if set
        <?php if (isset($error) && strpos($error, 'cannot be deleted') !== false): ?>
            var deleteErrorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
            deleteErrorModal.show();
        <?php endif; ?>
    </script>
</body>
</html>