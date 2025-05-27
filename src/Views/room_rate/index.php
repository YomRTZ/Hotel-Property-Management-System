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
               .grade-select {
    width: 100%;
    border: none;
    box-sizing: border-box;
}
.border{ border: none;}
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
            margin-right: 30%;
    margin-left: 10%;
            display: flex;
            justify-content: space-between;
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
        <div class="dropdown-container ">
      <div>  <label for="hotelDropdown">Select Hotel: </label>
        <select id="hotelDropdown" name="hotel_id">
            <option value="0">Select Hotel</option>
            <?php 
            error_log('Hotels in view: ' . print_r($hotels, true)); 
            foreach ($hotels as $hotel): ?>
                <option value="<?php echo $hotel->id; ?>" <?php echo isset($selectedHotelId) && $selectedHotelId == $hotel->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hotel->name); ?>
                </option>
            <?php endforeach; ?>
        </select></div>
        <div><label for="roomTypeDropdown">Select Room Type: </label>
        <select id="roomTypeDropdown" name="room_type_id">
            <option value="0">Select Room Type</option>
            <?php foreach ($roomTypes as $roomType): ?>
                <option value="<?php echo $roomType->id; ?>" <?php echo isset($selectedRoomTypeId) && $selectedRoomTypeId == $roomType->id ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($roomType->description); ?>
                </option>
            <?php endforeach; ?>
        </select></div>
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
            <th>Rate Description</th>
            <th>Rate</th>
            <th>isDefault</th>
            <th>Currency</th>
            <th>Tag Type</th>
            <th>Price Tag</th>
        </tr>
    </thead>
    <tbody id="roomRateTableBody">
        <?php $sn = 1; foreach ($roomRates as $rate): ?>
            <tr data-id="<?php echo $rate->id; ?>">
                <td><?php echo $sn++; ?></td>
                <td>
                    <select data-field="season" class="grade-select">
                        <option value="10_Normal Season" <?php echo $rate->season === '10_Normal Season' ? 'selected' : ''; ?>>10_Normal Season</option>
                    </select>
                </td>
                <td>
                    <select data-field="description" class="grade-select">
                        <?php 
                        $descriptions = ['Normal Price', 'Rack Rate', 'World Vision', 'UN', 'Discounted', 'Discounted 2'];
                        foreach ($descriptions as $desc): ?>
                            <option value="<?php echo $desc; ?>" <?php echo $rate->description === $desc ? 'selected' : ''; ?>><?php echo $desc; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input class="border"  data-field="rate" value="<?php echo htmlspecialchars($rate->rate ?? ''); ?>"></td>
                <td><input type="checkbox" data-field="is_default" <?php echo $rate->is_default ? 'checked' : ''; ?>></td>
                <td>
                    <select data-field="currency" class="grade-select">
                        <option value="196_USD" <?php echo $rate->currency === '196_USD' ? 'selected' : ''; ?>>196_USD</option>
                        <option value="195_ETB" <?php echo $rate->currency === '195_ETB' ? 'selected' : ''; ?>>195_ETB</option>
                    </select>
                </td>
                <td>
                    <select data-field="tagtype" class="grade-select">
                        <option value="None" <?php echo $rate->tagtype === 'None' ? 'selected' : ''; ?>>None</option>
                    </select>
                </td>
                <td><input class="border" data-field="pricetag" value="<?php echo htmlspecialchars($rate->pricetag ?? ''); ?>"></td>
            </tr>
        <?php endforeach; ?>
        <!-- New empty row for adding new record -->
        <tr class="new-row" data-id="new">
            <td><?php echo $sn++; ?></td>
            <td>
                <select data-field="season" class="grade-select">
                    <option value="10_Normal Season">10_Normal Season</option>
                </select>
            </td>
            <td>
                <select data-field="description" class="grade-select">
                    <option value="Normal Price">Normal Price</option>
                    <option value="Rack Rate">Rack Rate</option>
                    <option value="World Vision">World Vision</option>
                    <option value="UN">UN</option>
                    <option value="Discounted">Discounted</option>
                    <option value="Discounted 2">Discounted 2</option>
                </select>
            </td>
            <td><input class="border" data-field="rate"></td>
            <td><input type="checkbox" data-field="is_default"></td>
            <td>
                <select data-field="currency" class="grade-select">
                    <option value="196_USD">196_USD</option>
                    <option value="195_ETB">195_ETB</option>
                </select>
            </td>
            <td>
                <select data-field="tagtype" class="grade-select">
                    <option value="None">None</option>
                </select>
            </td>
            <td><input class="border" data-field="pricetag"></td>
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
        const rows = document.querySelectorAll('#roomRateTableBody tr');
        rows.forEach(row => {
            row.addEventListener('click', () => {
                rows.forEach(r => r.classList.remove('selected'));
                row.classList.add('selected');
                selectedRow = row;
                const deleteIdInput = document.getElementById('deleteId');
                deleteIdInput.value = row.dataset.id !== 'new' ? row.dataset.id : '';
               
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
    const seasonElement = selectedRow.querySelector('[data-field="season"]');
    const tagtypeElement = selectedRow.querySelector('[data-field="tagtype"]');
    const rateElement = selectedRow.querySelector('[data-field="rate"]');
    const isDefaultElement = selectedRow.querySelector('[data-field="is_default"]');
    const currencyElement = selectedRow.querySelector('[data-field="currency"]');
    const pricetagElement = selectedRow.querySelector('[data-field="pricetag"]');
    const descriptionElement = selectedRow.querySelector('[data-field="description"]');

    const hotel_id = hotelIdElement ? hotelIdElement.value : 0;
    const room_type_id = roomTypeIdElement ? roomTypeIdElement.value : 0;
    const season = seasonElement ? seasonElement.value : '';
    const tagtype = tagtypeElement ? tagtypeElement.value : '';
    const rate = rateElement ? rateElement.value : 0;
    const is_default = isDefaultElement ? isDefaultElement.checked ? 1 : 0 : 0;
    const currency = currencyElement ? currencyElement.value : '';
    const pricetag = pricetagElement ? pricetagElement.value : '';
    const description = descriptionElement ? descriptionElement.value : '';

    if (!season || !description || !rate || !currency) {
        alert('Season, description, rate, and currency are required.');
        return;
    }
    if (hotel_id == 0 || room_type_id == 0) {
        alert('Please select a hotel and room type.');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?action=save&tab=roomrate';

    const fields = { id, hotel_id, room_type_id, season, description, rate, is_default, currency, tagtype, pricetag };
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