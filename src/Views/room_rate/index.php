<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintain PMS - Room Rate</title>
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
    <div class="toolbar">
        <form method="post" action="index.php?action=save&tab=roomrate" style="display:inline;">
            <button type="submit">Save</button>
        </form>
        <form method="post" action="index.php?action=delete&tab=roomrate" style="display:inline;">
            <input type="hidden" name="id" id="deleteId" value="">
            <button type="submit" id="deleteBtn">Delete</button>
        </form>
        <form method="post" action="index.php?action=close&tab=roomrate" style="display:inline;">
            <button type="submit">Close</button>
        </form>
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
    <div class="nav-tabs">
        <span onclick="window.location.href='index.php?tab=hotel'">Hotel Information</span>
        <span onclick="window.location.href='index.php?tab=season'">Season</span>
        <span onclick="window.location.href='index.php?tab=roomtype'">Room Type</span>
        <span onclick="window.location.href='index.php?tab=room'">Room</span>
        <span onclick="window.location.href='index.php?tab=board'">Board</span>
        <span class="active" onclick="window.location.href='index.php?tab=roomrate'">Room Rate</span>
    </div>
    <div class="table-container">
        <table id="roomRateTable">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Season</th>
                    <th>Description
                    <th>Rate</th>
                    <th>Is Default</th>
                    <th>Tag Type</th>
                    <th>Currency</th>
                    <th>Board Price</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody id="roomRateTableBody">
                <?php $sn = 1; foreach ($roomRates as $roomRate): ?>
                    <tr class="<?php echo isset($_SESSION['selected_roomrate']) && $_SESSION['selected_roomrate'] == $roomRate->id ? 'selected' : ''; ?>" data-id="<?php echo $roomRate->id; ?>" data-hotel-id="<?php echo isset($roomRate->hotel_id) ? $roomRate->hotel_id : ''; ?>">
                        <td><?php echo $sn++; ?></td>
                        <td>
                            <select data-field="room_type_id">
                                <option value="0" <?php echo !$roomRate->room_type_id ? 'selected' : ''; ?>>Select Room Type</option>
                                <?php foreach ($roomTypes as $roomType): ?>
                                    <option value="<?php echo $roomType->id; ?>" <?php echo $roomRate->room_type_id == $roomType->id ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($roomType->description); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <select data-field="season_id">
                                <option value="0" <?php echo !$roomRate->season_id ? 'selected' : ''; ?>>Select Season</option>
                                <?php foreach ($seasons as $season): ?>
                                    <option value="<?php echo $season->id; ?>" <?php echo $roomRate->season_id == $season->id ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($season->name); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="editable" data-field="rate" contenteditable="true"><?php echo htmlspecialchars($roomRate->rate ?? ''); ?></td>
                        <td>
                            <select data-field="currency">
                                <option value="" <?php echo !$roomRate->currency ? 'selected' : ''; ?>>Select Currency</option>
                                <option value="196_USD" <?php echo $roomRate->currency === '196_USD' ? 'selected' : ''; ?>>196_USD</option>
                                <option value="195_ETB" <?php echo $roomRate->currency === '195_ETB' ? 'selected' : ''; ?>>195_ETB</option>
                            </select>
                        </td>
                        <td>
                            <input type="checkbox" data-field="isdefault" <?php echo $roomRate->isdefault == '1' ? 'checked' : ''; ?>>
                        </td>
                        <td class="editable" data-field="remark" contenteditable="true"><?php echo htmlspecialchars($roomRate->remark ?? ''); ?></td>
                        <td class="editable" data-field="account" contenteditable="true"><?php echo htmlspecialchars($roomRate->account ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="new-row" data-id="new">
                    <td><?php echo $sn++; ?></td>
                    <td>
                        <select data-field="room_type_id">
                            <option value="0">Select Room Type</option>
                            <?php foreach ($roomTypes as $roomType): ?>
                                <option value="<?php echo $roomType->id; ?>">
                                    <?php echo htmlspecialchars($roomType->description); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <select data-field="season_id">
                            <option value="0">Select Season</option>
                            <?php foreach ($seasons as $season): ?>
                                <option value="<?php echo $season->id; ?>">
                                    <?php echo htmlspecialchars($season->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="editable" data-field="rate" contenteditable="true"></td>
                    <td>
                        <select data-field="currency">
                            <option value="">Select Currency</option>
                            <option value="196_USD">196_USD</option>
                            <option value="195_ETB">195_ETB</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" data-field="isdefault">
                    </td>
                    <td class="editable" data-field="remark" contenteditable="true"></td>
                    <td class="editable" data-field="account" contenteditable="true"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal for Deletion Error -->
    <div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteErrorModalLabel">Cannot Delete Room Rate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This room rate cannot be deleted because it is linked to other data.
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
        const rows = document.querySelectorAll('#roomRateTableBody tr');
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
                alert('Please select a room rate to delete.');
                e.preventDefault();
                return;
            }
            if (!confirm('Are you sure you want to delete this room rate?')) {
                e.preventDefault();
                return;
            }
            console.log('Submitting delete form with ID:', document.getElementById('deleteId').value); // Debug: Log before submission
        });

        // Handle Save button
        document.querySelector('form[action="index.php?action=save&tab=roomrate"]').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedRow) {
                alert('Please select a row to save or use the new row.');
                return;
            }

            const id = selectedRow.dataset.id === 'new' ? '' : selectedRow.dataset.id;
            const hotelIdElement = document.getElementById('hotelDropdown');
            const roomTypeIdElement = document.getElementById('roomTypeDropdown');
            const seasonIdElement = document.getElementById('seasonDropdown');
            const roomTypeElement = selectedRow.querySelector('[data-field="room_type_id"]');
            const seasonElement = selectedRow.querySelector('[data-field="season_id"]');
            const rateElement = selectedRow.querySelector('[data-field="rate"]');
            const currencyElement = selectedRow.querySelector('[data-field="currency"]');
            const isDefaultElement = selectedRow.querySelector('[data-field="isdefault"]');
            const remarkElement = selectedRow.querySelector('[data-field="remark"]');
            const accountElement = selectedRow.querySelector('[data-field="account"]');

            const hotel_id = hotelIdElement ? hotelIdElement.value : 0;
            const room_type_id = roomTypeElement ? roomTypeElement.value : 0;
            const season_id = seasonElement ? seasonElement.value : 0;
            const rate = rateElement ? rateElement.textContent.trim() : '';
            const currency = currencyElement ? currencyElement.value : '';
            const isdefault = isDefaultElement ? (isDefaultElement.checked ? '1' : '0') : '0';
            const remark = remarkElement ? remarkElement.textContent.trim() : '';
            const account = accountElement ? accountElement.textContent.trim() : '';

            console.log('Saving:', { id, hotel_id, room_type_id, season_id, rate, currency, isdefault, remark, account });

            if (!room_type_id || room_type_id == 0 || !season_id || season_id == 0 || !rate || !currency) {
                alert('Room Type, Season, Rate, and Currency are required.');
                return;
            }
            if (hotel_id == 0) {
                alert('Please select a hotel.');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?action=save&tab=roomrate';

            const fields = { id, hotel_id, room_type_id, season_id, rate, currency, isdefault, remark, account };
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

        // Update hotel_id, room_type_id, and season_id in URL when dropdowns change
        document.getElementById('hotelDropdown').addEventListener('change', function() {
            const hotelId = this.value;
            const roomTypeId = document.getElementById('roomTypeDropdown').value;
            const seasonId = document.getElementById('seasonDropdown').value;
            window.history.pushState({}, '', `index.php?tab=roomrate&hotel_id=${hotelId}&room_type_id=${roomTypeId}&season_id=${seasonId}`);
        });

        document.getElementById('roomTypeDropdown').addEventListener('change', function() {
            const hotelId = document.getElementById('hotelDropdown').value;
            const roomTypeId = this.value;
            const seasonId = document.getElementById('seasonDropdown').value;
            window.history.pushState({}, '', `index.php?tab=roomrate&hotel_id=${hotelId}&room_type_id=${roomTypeId}&season_id=${seasonId}`);
        });

        document.getElementById('seasonDropdown').addEventListener('change', function() {
            const hotelId = document.getElementById('hotelDropdown').value;
            const roomTypeId = document.getElementById('roomTypeDropdown').value;
            const seasonId = this.value;
            window.history.pushState({}, '', `index.php?tab=roomrate&hotel_id=${hotelId}&room_type_id=${roomTypeId}&season_id=${seasonId}`);
        });

        // Show error modal if set
        <?php if (isset($error) && strpos($error, 'cannot be deleted') !== false): ?>
            var deleteErrorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
            deleteErrorModal.show();
        <?php endif; ?>
    </script>
</body>
</html>