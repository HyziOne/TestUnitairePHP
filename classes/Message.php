<?php

class Message
{
    private $id;
    private $user_id;
    private $room_id;
    private $content;
    private $timestamp;

    public function __construct($user_id, $room_id, $content, $timestamp = null)
    {
        if (strlen($content) < 2 || strlen($content) > 2048) {
            throw new InvalidArgumentException("Message content must be between 2 and 2048 characters.");
        }

        $this->id = uniqid();
        $this->user_id = $user_id;
        $this->room_id = $room_id;
        $this->content = $content;
        $this->timestamp = $timestamp ?? new DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getRoomId()
    {
        return $this->room_id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'room_id' => $this->room_id,
            'content' => $this->content,
            'timestamp' => $this->timestamp->format('Y-m-d H:i:s'),
        ];
    }
}
