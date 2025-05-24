<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Controllers/HotelController.php';
require_once __DIR__ . '/../src/Controllers/RoomTypeController.php';
require_once __DIR__ . '/../src/Controllers/RoomController.php';
require_once __DIR__ . '/../src/Controllers/BoardPriceController.php';
require_once __DIR__ . '/../src/Controllers/RoomRateController.php';
require_once __DIR__ . '/../src/Controllers/CurrencyExchangeController.php';

$controller = $_GET['controller'] ?? 'hotel';
$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

try {
    switch ($controller) {
        case 'hotel':
            $ctrl = new HotelController();
            break;
        case 'room_type':
            $ctrl = new RoomTypeController();
            break;
        case 'room':
            $ctrl = new RoomController();
            break;
        case 'board_price':
            $ctrl = new BoardPriceController();
            break;
        case 'room_rate':
            $ctrl = new RoomRateController();
            break;
        case 'currency_exchange':
            $ctrl = new CurrencyExchangeController();
            break;
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
    echo "An error occurred: " . $e->getMessage();
}