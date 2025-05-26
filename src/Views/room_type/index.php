<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintain PMS - Room Type</title>
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
                <option value="<?php echo $hotel->id; ?>" <?php echo $selectedHotelId && $selectedHotelId == $hotel->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="toolbar">
        <form method="post" action="index.php?action=save&tab=roomtype" style="display:inline;">
            <button type="submit">Save</button>
        </form>
        <form method="post" action="index.php?action=delete&tab=roomtype" style="display:inline;">
            <input type="hidden" name="id" id="deleteId" value="">
            <button type="submit" id="deleteBtn">Delete</button>
        </form>
        <form method="post" action="index.php?action=close&tab=roomtype" style="display:inline;">
            <button type="submit">Close</button>
        </form>
    </div>
    <div class="nav-tabs">
        <span onclick="window.location.href='index.php?tab=hotel'">Hotel Information</span>
        <span onclick="window.location.href='index.php?tab=season'">Season</span>
        <span class="active" onclick="window.location.href='index.php?tab=roomtype'">Room Type</span>
        <span class="active" onclick="window.location.href='index.php?tab=room'">Room</span>
        <span onclick="window.location.href='index.php?tab=board'">Board</span>
        <span onclick="window.location.href='index.php?tab=roomrate'">Room Rate</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Room Type Description</th>
                    <th>ClipOrPicture</th>
                    <th>Remark</th>
                    <th>Account</th>
                </tr>
            </thead>
            <tbody id="roomTypeTable">
                <?php
                $sn = 1;
                $roomTypes = isset($roomTypes) ? $roomTypes : [];
                $descriptionOptions = [
                    'Classic Room', 'Deluxe', 'Extra Bed', 'Family Room', 'Hall',
                    'Presidential Room', 'Single', 'Standard', 'Suite', 'Twin'
                ];
                foreach ($roomTypes as $roomType):
                    $selected = isset($_SESSION['selected_roomtype']) && $_SESSION['selected_roomtype'] == $roomType->id ? 'selected' : '';
                ?>
                    <tr class="<?php echo $selected; ?>" data-id="<?php echo $roomType->id; ?>" data-hotel-id="<?php echo $roomType->hotel_id; ?>">
                        <td><?php echo $sn++; ?></td>
                        <td>
                            <select class="description-select" data-field="description">
                                <?php foreach ($descriptionOptions as $option): ?>
                                    <option value="<?php echo $option; ?>" <?php echo $roomType->description == $option ? 'selected' : ''; ?>>
                                        <?php echo $option; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="editable" data-field="clip_or_picture" contenteditable="true"><?php echo htmlspecialchars($roomType->clip_or_picture); ?></td>
                        <td class="editable" data-field="remark" contenteditable="true"><?php echo htmlspecialchars($roomType->remark ?? ''); ?></td>
                        <td class="editable" data-field="account" contenteditable="true"><?php echo htmlspecialchars($roomType->account); ?></td>
                    </tr>
                <?php endforeach; ?>
                <!-- Empty row for new entry -->
                <tr class="new-row" data-id="new">
                    <td><?php echo $sn++; ?></td>
                    <td>
                        <select class="description-select" data-field="description">
                            <option value="">Select Description</option>
                            <?php foreach ($descriptionOptions as $option): ?>
                                <option value="<?php echo $option; ?>">
                                    <?php echo $option; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="editable" data-field="clip_or_picture" contenteditable="true"></td>
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
                    <h5 class="modal-title" id="deleteErrorModalLabel">Cannot Delete Room Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This room type cannot be deleted because it is linked to rooms.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let selectedRow = null;

        // Handle row selection
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('click', () => {
                rows.forEach(r => r.classList.remove('selected'));
                row.classList.add('selected');
                selectedRow = row;
                document.getElementById('deleteId').value = row.dataset.id !== 'new' ? row.dataset.id : '';
            });
        });

        // Confirm deletion
        document.getElementById('deleteBtn').addEventListener('click', function(e) {
            if (!selectedRow || selectedRow.dataset.id === 'new') {
                alert('Please select a room type to delete.');
                e.preventDefault();
                return;
            }
            if (!confirm('Are you sure you want to delete this room type?')) {
                e.preventDefault();
            }
        });

        // Handle Save button
        document.querySelector('form[action="index.php?action=save&tab=roomtype"]').addEventListener('submit', function(e) {
            e.preventDefault();
            if (!selectedRow) {
                alert('Please select a row to save.');
                return;
            }

            const id = selectedRow.dataset.id === 'new' ? '' : selectedRow.dataset.id;
            const hotelIdElement = document.getElementById('hotelDropdown');
            const descriptionElement = selectedRow.querySelector('[data-field="description"]');
            const clipOrPictureElement = selectedRow.querySelector('[data-field="clip_or_picture"]');
            const remarkElement = selectedRow.querySelector('[data-field="remark"]');
            const accountElement = selectedRow.querySelector('[data-field="account"]');

            const hotel_id = hotelIdElement ? hotelIdElement.value : 0;
            const description = descriptionElement ? descriptionElement.value : '';
            const clip_or_picture = clipOrPictureElement ? clipOrPictureElement.innerText.trim() : '';
            const remark = remarkElement ? remarkElement.innerText.trim() : '';
            const account = accountElement ? accountElement.innerText.trim() : '';

            // Debug the values
            console.log('Saving:', { id, hotel_id, description, clip_or_picture, remark, account });

            // Validation: Ensure required fields are filled
            if (!description) {
                alert('Room Type Description is required.');
                return;
            }
            if (hotel_id == 0) {
                alert('Please select a hotel.');
                return;
            }

            // Create a hidden form to submit the data
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?action=save&tab=roomtype';

            const fields = { id, hotel_id, description, clip_or_picture, remark, account };
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

        // Update hotel_id in URL when dropdown changes
        document.getElementById('hotelDropdown').addEventListener('change', function() {
            const hotelId = this.value;
            window.history.pushState({}, '', `index.php?tab=roomtype&hotel_id=${hotelId}`);
        });

        // Show error modal if set
        <?php if (isset($error)): ?>
            var deleteErrorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
            deleteErrorModal.show();
        <?php endif; ?>
    </script>
</body>
</html>