<?php
require_once './classes/ORM.php';
require_once './classes/User.php';
require_once './classes/Room.php';
require_once './classes/Message.php';
use PHPUnit\Framework\TestCase;
class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $user = new User("JohnDoe");

        $this->assertNotNull($user->getId());
        $this->assertEquals("JohnDoe", $user->getUsername());
    }

    public function testToArray()
    {
        $user = new User("JohnDoe");

        $userArray = $user->toArray();

        $this->assertArrayHasKey('id', $userArray);
        $this->assertArrayHasKey('username', $userArray);
        $this->assertEquals($user->getId(), $userArray['id']);
        $this->assertEquals($user->getUsername(), $userArray['username']);
    }
}
