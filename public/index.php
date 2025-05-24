<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controllers/HotelController.php';
require_once __DIR__ . '/../src/Controllers/RoomController.php';
// Include other controllers...

$controller = $_GET['controller'] ?? 'hotel';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

try {
    switch ($controller) {
        case 'hotel':
            $ctrl = new HotelController();
            break;
        case 'room':
            $ctrl = new RoomController();
            break;
        // Add cases for other controllers...
        default:
            throw new Exception("Invalid controller.");
    }

    switch ($action) {
        case 'index':
            $ctrl->index();
            break;
        case 'form':
            $ctrl->form($id);
            break;
        case 'save':
            $ctrl->save();
            break;
        case 'delete':
            $ctrl->delete($id);
            break;
        default:
            throw new Exception("Invalid action.");
    }
} catch (Exception $e) {
    // Log the error (e.g., to a file) and show a user-friendly message
    error_log($e->getMessage());
    http_response_code(500);
    echo "An error occurred. Please try again later.";
}