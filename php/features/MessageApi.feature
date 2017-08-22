Feature: Message Api
  As an User
  I want to manage my Messages
  So that I can use it to Internal Communication

  Scenario: List Messages
    Given I have Messages
    When I Retrieve a paginateable list of Messages
    Then I receive a paginateable list of Messages

  Scenario: List Archived Messages
    Given I have Archived Messages
    When I Retrieve a paginateable list of Archived Messages
    Then I receive a paginateable list of Archived Messages

  Scenario: Show Message
    Given I have a Message
    When I Retrieve a Message
    Then I receive a Message

  Scenario: Read Message
    Given I have a Message to Read
    When I Read a Message
    Then The Message was saved as Read

  Scenario: Archive Message
    Given I have a Message to Archive
    When I Archive a Message
    Then The Message was saved as Archived
