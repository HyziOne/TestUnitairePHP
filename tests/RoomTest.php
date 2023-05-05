<?php
require_once './classes/ORM.php';
require_once './classes/User.php';
require_once './classes/Room.php';
require_once './classes/Message.php';
use PHPUnit\Framework\TestCase;

class RoomTest extends TestCase
{
    public function createRoom(string $name): Room
    {
        $room = new Room($name);
        $this->rooms[] = $room;

        return $room;
    }


    public function testToArray()
    {
        $room = new Room("Test Room", null);

        $roomArray = $room->toArray();

        $this->assertArrayHasKey('id', $roomArray);
        $this->assertArrayHasKey('name', $roomArray);
        $this->assertEquals($room->getId(), $roomArray['id']);
        $this->assertEquals($room->getName(), $roomArray['name']);
    }
}
