<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

require_once './classes/ORM.php';
require_once './classes/User.php';
require_once './classes/Room.php';
require_once './classes/Message.php';


class FeatureContext implements Context
{
    private $orm;
    private $user;
    private $room;
    private $message;

    /**
     * @Given I have an empty ORM instance
     */
    public function iHaveAnEmptyOrmInstance()
    {
        $this->orm = new ORM();
    }

    /**
     * @When I create a user with username :username
     */
    public function iCreateAUserWithUsername($username)
    {
        $user = new User($username);
        $this->user = $this->orm->addUser($user);
    }

    /**
     * @Then I should be able to retrieve the user by username :username
     */
    public function iShouldBeAbleToRetrieveTheUserByUsername($username)
    {
        $retrievedUser = $this->orm->getUserByUsername($username);
        Assert::assertEquals($this->user['data'], $retrievedUser['data']);
    }

    /**
     * @Then I should be able to retrieve the user by their id
     */
    public function iShouldBeAbleToRetrieveTheUserByTheirId()
    {
        $retrievedUser = $this->orm->getUserById($this->user['data']['id']);
        Assert::assertEquals($this->user['data'], $retrievedUser['data']);
    }

    /**
     * @When I create a room with name :name
     */
    public function iCreateARoomWithName($name)
    {
        $room = new Room($name);
        $this->room = $this->orm->addRoom($room);
    }

    /**
     * @Then I should be able to retrieve the room by name :name
     */
    public function iShouldBeAbleToRetrieveTheRoomByName($name)
    {
        $retrievedRoom = $this->orm->getRoomByName($name);
        Assert::assertEquals($this->room['data'], $retrievedRoom['data']);
    }

    /**
     * @Then I should be able to retrieve the room by its id
     */
    public function iShouldBeAbleToRetrieveTheRoomByItsId()
    {
        $retrievedRoom = $this->orm->getRoomById($this->room['data']['id']);
        Assert::assertEquals($this->room['data'], $retrievedRoom['data']);
    }

    /**
     * @When I create a message with user_id :user_id, room_id :room_id and content :content
     */
    public function iCreateAMessageWithUserIdRoomIdAndContent($user_id, $room_id, $content)
    {
        $message = new Message($user_id, $room_id, $content, null);
        $this->message = $this->orm->addMessage($message);
    }

    /**
     * @Then I should be able to retrieve the message by its id
     */
    public function iShouldBeAbleToRetrieveTheMessageByItsId()
    {
        $retrievedMessage = $this->orm->getMessageById($this->message['data']['id']);
        Assert::assertEquals($this->message['data'], $retrievedMessage['data']);
    }

    /**
     * @Then I should be able to retrieve all messages in room with id :room_id ordered by timestamp
     */
    public function iShouldBeAbleToRetrieveAllMessagesInRoomWithIdOrderedByTimestamp($room_id)
    {
        $retrievedMessages = $this->orm->getMessagesByRoomId($room_id);
        Assert::assertNotEmpty($retrievedMessages['data']);
        Assert::assertCount(2, $retrievedMessages['data']);

        $firstMessage = $retrievedMessages['data'][0];
        $secondMessage = $retrievedMessages['data'][1];
        Assert::assertLessThanOrEqual($firstMessage['timestamp'], $secondMessage['timestamp']);
    }
    /**
     * @Given I have a user with username :arg1
     */
    public function iHaveAUserWithUsername($arg1)
    {
        $user = new User($arg1);
        $this->user = $this->orm->addUser($user);
    }


    /**
     * @Given I have a room with name :arg1
     */
    public function iHaveARoomWithName($arg1)
    {
        $room = new Room($arg1);
        $this->room = $this->orm->addRoom($room);
    }
    
}
