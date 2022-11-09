@webUI @insulated @disablePreviews
Feature:  first login wizard
  As a user
  I want to be informed about the basic features of ownCloud when I first log in
  So that I can get a basic overview about ownCloud


  Scenario: User logs in into ownCloud for the first time
    Given user "Alice" has been created with default attributes and without skeleton files
    When user "Alice" logs in using the webUI
    Then the user should see the firstrunwizard popup message
    And the heading of the popup should be "A safe home for all your data"


  Scenario: Previously created user logs into ownCloud
    Given user "Alice" has been created with default attributes and without skeleton files
    When user "Alice" logs in using the webUI
    And the user closes the firstrunwizard popup message
    And the user re-logs in as "Alice" using the webUI
    Then the user should not see the firstrunwizard popup message

  @skipOnFIREFOX
  # Firefox gives an "out of bounds of viewport width" error
  Scenario: User requests to show firstrunwizard popup in settings page
    Given user "Alice" has been created with default attributes and without skeleton files
    And user "Alice" has logged in using the webUI
    And the user has closed the firstrunwizard popup message
    And the user has browsed to the personal general settings page
    When the user requests to show firstrunwizard popup in settings page
    Then the user should see the firstrunwizard popup message
