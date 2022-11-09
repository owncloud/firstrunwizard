@webUI @insulated @disablePreviews
Feature: Customize firstrunwizard popup
  As an administrator
  I want to customize firstrunwizard popup message
  So that I can send message from firstrunwizard to all new users


  Scenario: Administrator changes the default message of firstrunwizard
    Given the administrator has changed the default popup message of firstrunwizard to "next default message"
    And user "Alice" has been created with default attributes and without skeleton files
    When user "Alice" logs in using the webUI
    Then the user should see the firstrunwizard popup message
    And the heading of the popup should be "next default message"


  Scenario: Administrator reverts the popup message of firstrunwizard to default message
    Given user "Alice" has been created with default attributes and without skeleton files
    When user "Alice" logs in using the webUI
    Then the user should see the firstrunwizard popup message
    And the heading of the popup should be "A safe home for all your data"
