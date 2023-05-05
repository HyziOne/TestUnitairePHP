<?php
require_once './classes/ORM.php';
require_once './classes/User.php';
require_once './classes/Room.php';
require_once './classes/Message.php';
use PHPUnit\Framework\TestCase;

class ORMTest extends TestCase
{
    public function testAddUser()
    {
        $orm = new ORM();
        $user = new User("JohnDoe", null);

        $response = $orm->addUser($user);

        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertEquals("JohnDoe", $response['data']['username']);
    }

    public function testAddUserWithExistingUsername()
    {
        $orm = new ORM();
        $user1 = new User("JohnDoe", null);
        $orm->addUser($user1);

        $user2 = new User("JohnDoe", null);
        $response = $orm->addUser($user2);

        $this->assertFalse($response['success']);
        $this->assertEquals("Username already exists", $response['data']); // Fix the typo here
    }


    public function testAddRoom()
    {
        $orm = new ORM();
        $room = new Room("Test Room", null);

        $response = $orm->addRoom($room);

        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertEquals("Test Room", $response['data']['name']);
    }

    public function testAddRoomWithExistingName()
    {
        $orm = new ORM();
        $room1 = new Room("Test Room", null);
        $orm->addRoom($room1);

        $room2 = new Room("Test Room", null);
        $response = $orm->addRoom($room2);

        $this->assertFalse($response['success']);
        $this->assertEquals("A room with the same name already exists.", $response['data']);
    }

    public function testAddMessage()
    {
        $orm = new ORM();
        $user = new User("JohnDoe", null);
        $orm->addUser($user);

        $room = new Room("Test Room", null);
        $orm->addRoom($room);

        $message = new Message($user->getId(), $room->getId(), "This is a test message.", null);

        $response = $orm->addMessage($message);

        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertEquals($user->getId(), $response['data']['user_id']);
        $this->assertEquals($room->getId(), $response['data']['room_id']);
        $this->assertEquals("This is a test message.", $response['data']['content']);
    }

    public function testAddMessageWithNonexistentUser()
    {
        $orm = new ORM();
    
        $room = new Room("Test Room", null);
        $orm->addRoom($room);
    
        // Utilisation d'un ID d'utilisateur inexistant
        $nonexistentUserId = 999;
        $message = new Message($nonexistentUserId, $room->getId(), "This is a test message.", null);
    
        $response = $orm->addMessage($message);
    
        $this->assertFalse($response['success']);
        $this->assertEquals("User not found", $response['data']);
    }
    

    public function testAddMessageWithNonexistentRoom()
    {
        $orm = new ORM();
        $user = new User("JohnDoe", null);
        $orm->addUser($user);
    
        // Utilisation d'un ID de salle inexistant
        $nonexistentRoomId = 999;
        $message = new Message($user->getId(), $nonexistentRoomId, "This is a test message.", null);
    
        $response = $orm->addMessage($message);
    
        $this->assertFalse($response['success']);
        $this->assertEquals("Room not found", $response['data']);
    }
    
    
    

    public function testAddMessageWithConsecutiveMessages()
    {
        $orm = new ORM();
        $user = new User("JohnDoe", null);
        $orm->addUser($user);
    
        $room = new Room("Test Room", null);
        $orm->addRoom($room);
    
        $message1 = new Message($user->getId(), $room->getId(), "This is a test message 1.", null);
        $orm->addMessage($message1);
    
        // Ajoutez une pause entre les deux messages
        sleep(1);
    
        $message2 = new Message($user->getId(), $room->getId(), "This is a test message 2.", null);
        $response = $orm->addMessage($message2);
    
        $this->assertTrue($response['success']);
        $this->assertArrayHasKey('id', $response['data']);
        $this->assertEquals($user->getId(), $response['data']['user_id']);
        $this->assertEquals($room->getId(), $response['data']['room_id']);
        $this->assertEquals("This is a test message 2.", $response['data']['content']);
    }
    
}
