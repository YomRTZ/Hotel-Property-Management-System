<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hotel PMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link <?php echo $controller == 'hotel' ? 'active' : ''; ?>" href="?controller=hotel&action=index">Hotel Information</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $controller == 'room_type' ? 'active' : ''; ?>" href="?controller=room_type&action=index">Room Type</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $controller == 'room' ? 'active' : ''; ?>" href="?controller=room&action=index">Room</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $controller == 'board_price' ? 'active' : ''; ?>" href="?controller=board_price&action=index">Board</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $controller == 'room_rate' ? 'active' : ''; ?>" href="?controller=room_rate&action=index">Room Rate</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo $controller == 'currency_exchange' ? 'active' : ''; ?>" href="?controller=currency_exchange&action=index">Currency Exchange</a>
            </li>
        </ul>
        <div class="mt-4">
            <?php include $view; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>