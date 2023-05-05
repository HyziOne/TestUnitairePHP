<?php

require_once './classes/ORM.php';
require_once './classes/User.php';
require_once './classes/Room.php';
require_once './classes/Message.php';
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testMessageConstructor()
    {
        $user_id = 1;
        $room_id = 1;
        
        $content = "Hello, this is a test message.";

        $message = new Message($user_id, $room_id, $content, null);

        $this->assertEquals($user_id, $message->getUserId());
        $this->assertEquals($room_id, $message->getRoomId());
        $this->assertEquals($content, $message->getContent());
    }

    public function testMessageToArray()
    {
        $user = new User('John Doe');
        $room_id = 1;
        $content = "Hello, this is a test message.";
    
        $message = new Message($user->getId(), $room_id, $content, null);
        $messageArray = $message->toArray();
    
        $this->assertArrayHasKey('id', $messageArray);
        $this->assertArrayHasKey('user_id', $messageArray);
        $this->assertArrayHasKey('room_id', $messageArray);
        $this->assertArrayHasKey('content', $messageArray);
        $this->assertArrayHasKey('timestamp', $messageArray);
    
        $this->assertEquals($user->getId(), $messageArray['user_id']);
        $this->assertEquals($room_id, $messageArray['room_id']);
        $this->assertEquals($content, $messageArray['content']);
    }
    
    

    public function testMessageConstructorThrowsException()
    {
        $user_id = 1;
        $room_id = 1;
        $content = "A"; // Invalid content (less than 2 characters)

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Message content must be between 2 and 2048 characters.");

        new Message($user_id, $room_id, $content, null);
    }

    


    public function testMessageConstructorThrowsExceptionForLongContent()
    {
        $user_id = 1;
        $room_id = 1;
        $content = str_repeat("A", 2049); // Invalid content (more than 2048 characters)

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Message content must be between 2 and 2048 characters.");

        new Message($user_id, $room_id, $content, null);
    }

    
}
