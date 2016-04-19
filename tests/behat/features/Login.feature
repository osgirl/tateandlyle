@javascript
Feature: Basic authentication access test
  In order to test if Drupal is set up
  As a user
  I need to be able to load the homepage

  Scenario: Load a page
    Given I am on "/user/login"
    Then I should see the text "Log in"

# @todo Add @api example.
