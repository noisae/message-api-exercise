Feature: Message Api
  As an User
  I want to manage my Messages
  So that I can use it to Internal Communication

  Scenario: List Messages
    Given I have Messages
    When I Retrieve a list of Messages
    Then I receive a paginateable list of Messages
     And I can see if Messages was read already

  Scenario: List Archived Messages
    Given I have Archived Messages
    When I Retrieve a list of Archived Messages
    Then I receive a paginateable list of Archived Messages

  Scenario: Show Message
    Given I have a one Message
    When I Retrieve a one Message
    Then I receive Message
     And I can see if Message was read already
     And I can see if Message was achieved already

  Scenario: Read Message
    Given I have a one Message
    When I Read a one Message
    Then the Message was marked as read

  Scenario: Archive Message
    Given I have a one Message
    When I Archive a one Message
    Then the Message was marked as archived
