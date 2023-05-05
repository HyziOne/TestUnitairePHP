Feature: Message Board
  In order to manage users, rooms, and messages
  As a developer
  I need to be able to perform CRUD operations using the ORM class

  Scenario: Create and retrieve users
    Given I have an empty ORM instance
    When I create a user with username "john_doe"
    Then I should be able to retrieve the user by username "john_doe"
    And I should be able to retrieve the user by their id

  Scenario: Create and retrieve rooms
    Given I have an empty ORM instance
    When I create a room with name "general"
    Then I should be able to retrieve the room by name "general"
    And I should be able to retrieve the room by its id

  Scenario: Create and retrieve messages
    Given I have an empty ORM instance
    And I have a user with username "john_doe"
    And I have a room with name "general"
    When I create a message with user_id 1, room_id 1 and content "Hello, world!"
    Then I should be able to retrieve the message by its id

  Scenario: Retrieve messages in a room
    Given I have an empty ORM instance
    And I have a user with username "john_doe"
    And I have a user with username "bob_jane"
    And I have a room with name "general"
    When I create a message with user_id 1, room_id 1 and content "Hello, everyone!"
    And I create a message with user_id 2, room_id 1 and content "Hi, John!"
    And the ORM should have 2 messages
    Then I should be able to retrieve all messages in room with id 1 ordered by timestamp
