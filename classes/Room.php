<?php

class Room
{
    private $id;
    private $name;
    private $messages;

    public function __construct($name, $id = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->messages = [];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function addMessage(Message $message)
    {
        $this->messages[] = $message;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}