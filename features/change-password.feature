Feature: Users can change their password
  In order to keep my account secure
  As a logged in user
  I can change my password using the frontend

  Background:
    Given I am logged in as a subscriber
    And I am on the homepage

  Scenario: I can access the 'Change Password' page
    When I follow "Change My Password"
    Then I should see "Change Your Account Password"
