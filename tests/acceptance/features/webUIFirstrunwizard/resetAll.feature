@webUI @insulated @disablePreviews
Feature: first login wizard is displayed again when the reset-all command has been run
  As an administrator
  I want to be able to reset the first run wizard display status for all users
  So that I can force users to be shown the first run wizard popup again

  Scenario: Administrator runs reset-all occ command after all the users log into ownCloud
    Given user "user1" has been created with default attributes and skeleton files
    And user "user2" has been created with default attributes and skeleton files
    And user "user1" has logged in using the webUI
    And the user has closed the firstrunwizard popup message
    And the user has re-logged in as "user2" using the webUI
    And the user has closed the firstrunwizard popup message
    And the administrator has invoked occ command "firstrunwizard:reset-all"
    When the user re-logs in as "user1" using the webUI
    Then the user should see the firstrunwizard popup message
    When the user closes the firstrunwizard popup message
    And the user re-logs in as "user2" using the webUI
    Then the user should see the firstrunwizard popup message

  Scenario: Administrator runs reset-all occ command after some users log into ownCloud
    Given user "user1" has been created with default attributes and skeleton files
    And user "user2" has been created with default attributes and skeleton files
    And user "user1" has logged in using the webUI
    And the user has closed the firstrunwizard popup message
    And the administrator has invoked occ command "firstrunwizard:reset-all"
    When the user re-logs in as "user1" using the webUI
    Then the user should see the firstrunwizard popup message
    When the user closes the firstrunwizard popup message
    And the user re-logs in as "user2" using the webUI
    Then the user should see the firstrunwizard popup message
