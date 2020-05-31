@webUI @insulated @disablePreviews
Feature: first login wizard is displayed again when the reset-all command has been run
  As an administrator
  I want to be able to reset the first run wizard display status for all users
  So that I can force users to be shown the first run wizard popup again

  Scenario: Administrator runs reset-all occ command after all the users log into ownCloud
    Given user "Alice" has been created with default attributes and skeleton files
    And user "Brian" has been created with default attributes and skeleton files
    And user "Alice" has logged in using the webUI
    And the user has closed the firstrunwizard popup message
    And the user has re-logged in as "Brian" using the webUI
    And the user has closed the firstrunwizard popup message
    And the administrator has invoked occ command "firstrunwizard:reset-all"
    When the user re-logs in as "Alice" using the webUI
    Then the user should see the firstrunwizard popup message
    When the user closes the firstrunwizard popup message
    And the user re-logs in as "Brian" using the webUI
    Then the user should see the firstrunwizard popup message

  Scenario: Administrator runs reset-all occ command after some users log into ownCloud
    Given user "Alice" has been created with default attributes and skeleton files
    And user "Brian" has been created with default attributes and skeleton files
    And user "Alice" has logged in using the webUI
    And the user has closed the firstrunwizard popup message
    And the administrator has invoked occ command "firstrunwizard:reset-all"
    When the user re-logs in as "Alice" using the webUI
    Then the user should see the firstrunwizard popup message
    When the user closes the firstrunwizard popup message
    And the user re-logs in as "Brian" using the webUI
    Then the user should see the firstrunwizard popup message
