<?php

class ORM
{
    private $users;
    private $rooms;
    private $messages;
    public $response = ['success' => false, 'data' => null];

    public function __construct()
    {
        $this->users = [];
        $this->rooms = [];
        $this->messages = [];
    }

    // User-related methods
    public function getUsers()
    {
        if (count($this->users) == 0) {
            $this->response['data'] = "No users found";
            $this->response['success'] = false;
            return $this->response;
        }
        return array_map(function ($user) {
            return [
                'success' => true,
                'data' => $user->toArray(),
            ];
        }, $this->users);
    }

    public function getUserById($id)
    {
        foreach ($this->users as $user) {
            if ($user->getId() == $id) {
                $this->response['data'] = $user->toArray();
                $this->response['success'] = true;
                return $this->response;
            }
        }
        $this->response['data'] = "User not found";
        $this->response['success'] = false;
        return $this->response;
    }

    public function getUserByUsername($username)
    {
        foreach ($this->users as $user) {
            if ($user->getUsername() == $username) {
                $this->response['data'] = $user->toArray();
                $this->response['success'] = true;
                return $this->response;
            }
        }
        $this->response['data'] = "User not found";
        $this->response['success'] = false;
        return $this->response;
    }

    public function addUser(User $user)
    {
        foreach ($this->users as $baseUser) {
            if ($baseUser->getUsername() == $user->getUsername()) {
                $this->response['data'] = "Username already exists";
                $this->response['success'] = false;
                return $this->response;
            }
        }
        $this->users[] = $user;
        $this->response['data'] = $user->toArray();
        $this->response['success'] = true;
        return $this->response;
    }

    // Room-related methods
    public function getRooms()
    {
        if (count($this->rooms) == 0) {
            $this->response['data'] = "No rooms found";
            $this->response['success'] = false;
            return $this->response;
        }
        return array_map(function ($room) {
            return [
                'success' => true,
                'data' => $room->toArray(),
            ];
        }, $this->rooms);
    }

    public function getRoomByName($name)
    {
        foreach ($this->rooms as $room) {
            if ($room->getName() == $name) {
                $this->response['data'] = $room->toArray();
                $this->response['success'] = true;
                return $this->response;
            }
        }
        $this->response['data'] = "Room not found";
        $this->response['success'] = false;
        return $this->response;
    }

    public function getRoomById($id)
    {
        foreach ($this->rooms as $room) {
            if ($room->getId() == $id) {
                $this->response['data'] = $room->toArray();
                $this->response['success'] = true;
                return $this->response;
            }
        }
        $this->response['data'] = "Room not found";
        $this->response['success'] = false;
        return $this->response;
    }

    public function addRoom(Room $room)
    {
        if ($this->getRoomByName($room->getName())['success'] == true) {
            $this->response['data'] = "A room with the same name already exists.";
            $this->response['success'] = false;
            return $this->response;
        }
        $this->rooms[] = $room;
        $this->response['data'] = $room->toArray();
        $this->response['success'] = true;
        return $this->response;
    }

    public function getMessageById($id)
    {
        foreach ($this->messages as $message) {
            if ($message->getId() == $id) {
                $this->response['data'] = $message->toArray();
                $this->response['success'] = true;
                return $this->response;
            }
        }
        $this->response['data'] = "Message not found";
        $this->response['success'] = false;
        return $this->response;
    }

    public function getMessages()
    {
        return $this->messages;
    }
// Message-related methods
    public function getMessagesByRoomId($room_id)
    {
        if ($this->getRoomById($room_id)['success'] == false) {
            return $this->getRoomById($room_id);
        }
        $room_messages = [];
        foreach ($this->messages as $message) {
            if ($message->getRoomId() == $room_id) {
                $room_messages[] = $message->toArray();
            }
        }

        usort($room_messages, function ($a, $b) {
            return $a['timestamp'] <=> $b['timestamp'];
        });

        $response['data'] = $room_messages;
        $response['success'] = true;
        return $response;
    }

    public function getNextMessageByUserId($user_id)
    {
        $nextMessage = null;
        foreach ($this->messages as $message) {
            if ($message->getUserId() == $user_id) {
                if ($nextMessage === null || $message->getTimestamp() > $nextMessage->getTimestamp()) {
                    $nextMessage = $message;
                }
            }
        }
        return $nextMessage;
    }



    public function addMessage(Message $message)
    {
        // Check if the user exists
        if ($this->getUserById($message->getUserId())['success'] == false) {
            $this->response['data'] = "User not found";
            $this->response['success'] = false;
            return $this->response;
        }

        // Check if the room exists
        if ($this->getRoomById($message->getRoomId())['success'] == false) {
            $this->response['data'] = "Room not found";
            $this->response['success'] = false;
            return $this->response;
        }
        $lastMessage = $this->getLastMessageByUserId($message->getUserId());
        if ($lastMessage !== null && !($lastMessage instanceof Message)) {
            return $lastMessage;
        }
        if ($lastMessage !== null) {
            $lastMessageTimestamp = $lastMessage->getTimestamp();
            $interval = $lastMessageTimestamp->diff($message->getTimestamp());
            if ($interval->days == 0 && $interval->h == 0 && $interval->i < 24) {
                $nextMessage = $this->getNextMessageByUserId($message->getUserId());
                if ($nextMessage === null) {
                    $this->response['data'] = "You cannot post two consecutive messages within 24 hours.";
                    $this->response['success'] = false;
                    return $this->response;
                }
            }
        }
        $this->messages[] = $message;
        $this->response['data'] = $message->toArray();
        $this->response['success'] = true;
        return $this->response;
    }



    public function getLastMessageByUserId($user_id)
    {
        $last_message = null;
        if ($this->getUserById($user_id)['success'] == false) {
            return $this->getUserById($user_id);
        }
        foreach ($this->messages as $message) {
            if ($message->getUserId() == $user_id) {
                if ($last_message === null || $message->getTimestamp() > $last_message->getTimestamp()) {
                    $last_message = $message;
                }
            }
        }
        return $last_message;
    }
}


