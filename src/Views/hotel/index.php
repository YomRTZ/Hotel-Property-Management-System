<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintain PMS - Hotel Information</title>
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
    </style>
</head>
<body>
    <div class="title-bar">
        <span>Maintain PMS</span>
    </div>
    <div class="toolbar">
        <form method="post" action="index.php?action=save" style="display:inline;">
            <button type="submit">Save</button>
        </form>
        <form method="post" action="index.php?action=delete" style="display:inline;">
            <input type="hidden" name="id" id="deleteId" value="">
            <button type="submit" id="deleteBtn">Delete</button>
        </form>
        <form method="post" action="index.php?action=close" style="display:inline;">
            <button type="submit">Close</button>
        </form>
    </div>
    <div class="nav-tabs">
        <span class="active" onclick="window.location.href='index.php?tab=hotel'">Hotel Information</span>
        <span onclick="window.location.href='index.php?tab=season'">Season</span>
        <span  onclick="window.location.href='index.php?tab=roomtype'">Room Type</span>
        <span onclick="window.location.href='index.php?tab=room'">Room</span>
        <span onclick="window.location.href='index.php?tab=board'">Board</span>
        <span onclick="window.location.href='index.php?tab=roomrate'">Room Rate</span>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Hotel Name</th>
                    <th>Grade</th>
                    <th>IsDefault</th>
                    <th>Remark</th>
                </tr>
            </thead>
       <tbody id="hotelTable">
    <?php
    $sn = 1;
    foreach ($hotels as $hotel):
    ?>
        <tr class="<?php echo $selected; ?>" data-id="<?php echo $hotel->id; ?>">
            <td><?php echo $sn++; ?></td>
            <td class="editable" data-field="name" contenteditable="true"><?php echo htmlspecialchars($hotel->name); ?></td>
            <td>
                <select class="grade-select" data-field="grade">
                    <option value="4star" <?php echo $hotel->grade === '4star' ? 'selected' : ''; ?>>4 star</option>
                    <option value="3star" <?php echo $hotel->grade === '3star' ? 'selected' : ''; ?>>3 star</option>
                    <option value="2star" <?php echo $hotel->grade === '2star' ? 'selected' : ''; ?>>2 star</option>
                    <option value="1star" <?php echo $hotel->grade === '1star' ? 'selected' : ''; ?>>1 star</option>
                </select>
            </td>
            <td>
                <input type="checkbox" class="is-default" data-field="is_default" <?php echo $hotel->is_default ? 'checked' : ''; ?>>
            </td>
            <td class="editable" data-field="remark" contenteditable="true"><?php echo htmlspecialchars($hotel->remark); ?></td>
        </tr>
    <?php endforeach; ?>
    <!-- Empty row for new entry -->
    <tr class="new-row" data-id="new">
        <td><?php echo $sn++; ?></td>
        <td class="editable" data-field="name" contenteditable="true"></td>
        <td>
            <select class="grade-select" data-field="grade">
                <option value="4star">4 star</option>
                <option value="3star">3 star</option>
                <option value="2star">2 star</option>
                <option value="1star">1 star</option>
            </select>
        </td>
        <td>
            <input type="checkbox" class="is-default" data-field="is_default">
        </td>
        <td class="editable" data-field="remark" contenteditable="true"></td>
    </tr>
</tbody>
        </table>
    </div>

    <!-- Modal for Deletion Error -->
    <div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteErrorModalLabel">Cannot Delete Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This hotel cannot be deleted because it is linked to room types.
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
            alert('Please select a hotel to delete.');
            e.preventDefault();
            return;
        }
        if (!confirm('Are you sure you want to delete this hotel?')) {
            e.preventDefault();
        }
    });

    // Handle Save button
    document.querySelector('form[action="index.php?action=save"]').addEventListener('submit', function(e) {
        e.preventDefault();
        if (!selectedRow) {
            alert('Please select a row to save.');
            return;
        }

        const id = selectedRow.dataset.id === 'new' ? '' : selectedRow.dataset.id;
        const nameElement = selectedRow.querySelector('[data-field="name"]');
        const gradeElement = selectedRow.querySelector('[data-field="grade"]');
        const isDefaultElement = selectedRow.querySelector('[data-field="is_default"]');
        const remarkElement = selectedRow.querySelector('[data-field="remark"]');

        const name = nameElement ? nameElement.innerText.trim() : '';
        const grade = gradeElement ? gradeElement.value : '';
        const isDefault = isDefaultElement ? (isDefaultElement.checked ? 1 : 0) : 0;
        const remark = remarkElement ? remarkElement.innerText.trim() : '';

        // Debug the values
        console.log('Saving:', { id, name, grade, is_default: isDefault, remark });

        // Validation: Ensure required fields are filled
        if (!name) {
            alert('Hotel Name is required.');
            return;
        }

        // Create a hidden form to submit the data
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?action=save';

        const fields = { id, name, grade, is_default: isDefault, remark };
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

    // Show error modal if set
    <?php if (isset($error)): ?>
        var deleteErrorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
        deleteErrorModal.show();
    <?php endif; ?>
</script>
</body>
</html>