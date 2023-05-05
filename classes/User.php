<?php

class User
{
    private static $counter = 0;

    private $id;
    private $username;
    private $lastMessageTimestamp;

    public function __construct($username, $id = null)
    {
        $this->id = $id ?? ++self::$counter;
        $this->username = $username;
        $this->lastMessageTimestamp = null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getLastMessageTimestamp()
    {
        return $this->lastMessageTimestamp;
    }

    public function setLastMessageTimestamp(DateTime $timestamp)
    {
        $this->lastMessageTimestamp = $timestamp;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
        ];
    }
}


