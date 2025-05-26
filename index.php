<?php
require_once 'vendor/autoload.php';
require_once 'src/Helpers/database.php';
require_once 'src/Controllers/HotelController.php';
require_once 'src/Controllers/RoomTypeController.php';
require_once 'src/Controllers/RoomController.php';
require_once 'src/Controllers/RoomRateController.php';
$tab = $_GET['tab'] ?? 'hotel';
if ($tab === 'roomtype') {
    $controller = new RoomTypeController();
} else if ($tab === 'room') {
    $controller = new RoomController();
}
else if ($tab === 'roomrate') {
    $controller = new RoomRateController();
}
 else {
    $controller = new HotelController();
}
$action = $_GET['action'] ?? 'index';
switch ($action) {
    case 'save':
        $controller->save();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'close':
        $controller->close();
        break;
    default:
        $controller->index();
        break;
}