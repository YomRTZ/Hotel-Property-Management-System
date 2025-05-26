<?php
require_once 'src/Helpers/Database.php';
use RedBeanPHP\R;

R::freeze(true);

// Hotel table
$hotel = R::dispense('hotel');
$hotel->name = null;
$hotel->grade = null;
$hotel->is_default = null;
$hotel->remark = null;
R::store($hotel);
R::exec('ALTER TABLE hotel 
         MODIFY COLUMN id INT(11) NOT NULL AUTO_INCREMENT,
         MODIFY COLUMN name VARCHAR(255),
         MODIFY COLUMN grade VARCHAR(255),
         MODIFY COLUMN is_default TINYINT(1) UNSIGNED,
         MODIFY COLUMN remark VARCHAR(255)');

// Room Type table
try {
    $roomType = R::dispense('roomtype');
    $roomType->hotel_id = null;
    $roomType->description = null;
    $roomType->account = null;
    $roomType->clip_or_picture = null;
    $roomType->remark = null;
    R::store($roomType);
} catch (Exception $e) {
    die("Error creating roomtype: " . $e->getMessage());
}
R::exec('ALTER TABLE roomtype 
         MODIFY COLUMN hotel_id INT(11),
         MODIFY COLUMN description VARCHAR(255),
         MODIFY COLUMN account VARCHAR(255),
         MODIFY COLUMN clip_or_picture VARCHAR(255),
         MODIFY COLUMN remark VARCHAR(255)');

// Room table
$room = R::dispense('room');
$room->room_number = null;
$room->room_type_id = null;
$room->telephone_extension = null;
$room->location = null;
$room->room_specialization=null;
$room->no_of_bed = null;
$room->change_to = null;
R::store($room);

// Define schema for room table
R::exec('ALTER TABLE room 
         MODIFY COLUMN room_type_id INT(11),
         MODIFY COLUMN room_number VARCHAR(50),
         MODIFY COLUMN telephone_extension VARCHAR(20),
         MODIFY COLUMN location VARCHAR(255)');

// Board Price table
$boardPrice = R::dispense('boardprice');
$boardPrice->room_type_id = null;
$boardPrice->board_type = null;
$boardPrice->amount = null;
$boardPrice->currency_code = null;
R::store($boardPrice);

// Define schema for boardprice table
R::exec('ALTER TABLE boardprice 
         MODIFY COLUMN room_type_id INT(11),
         MODIFY COLUMN board_type VARCHAR(50),
         MODIFY COLUMN amount DECIMAL(10,2),
         MODIFY COLUMN currency_code CHAR(3)');

// Room Rate table
$roomRate = R::dispense('roomrate');
$roomRate->room_type_id = null;
$roomRate->season = null;
$roomRate->rate = null;
$roomRate->currency_code = null;
R::store($roomRate);

// Define schema for roomrate table
R::exec('ALTER TABLE roomrate 
         MODIFY COLUMN room_type_id INT(11),
         MODIFY COLUMN season VARCHAR(50),
         MODIFY COLUMN rate DECIMAL(10,2),
         MODIFY COLUMN currency_code CHAR(3)');

echo "Database 'FrontOffice' and tables created successfully!";
?>