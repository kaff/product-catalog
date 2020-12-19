Feature:
  In order to present offers to customers
  As a shop owner
  I want to have the possibility to create a new product

  Scenario: Can create product
    Given the request body is:
    """
    {
      "name": "Product name",
      "price_amount": 2345,
      "price_currency": "PLN"
    }
    """
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products" using HTTP POST
    Then the response code is 202
    Then the response body matches:
    """
    /\"uid\": \"[a-f0-9]{32}\"/
    """
    And the response body contains JSON:
    """
    {
        "_links": {
            "status": {
                "href": "//example.com/api/products/status/a7fa58d932e666ece80124199cb83ae7"
            }
        },
        "status": {
            "status": "Pending"
        }
    }
    """

  Scenario: Response should not be cached by client
    Given the request body is:
    """
    {
      "name": "Product name",
      "price_amount": 2345,
      "price_currency": "PLN"
    }
    """
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products" using HTTP POST
    Then the response code is 202
    And the "cache-control" response header matches "no-cache, no-store, private"
    And the "expires" response header matches "0"
    And the "pragma" response header matches "no-cache"

  Scenario: Receive a error message when request format is invalid
    Given the request body is:
    """
    {
      "name": "Product
    }
    """
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
    {
      "code": 400,
      "message": "Invalid json message received"
    }
    """

  Scenario: Receive an error message when there is a lack of required data
    Given the request body is:
    """
    {
      "name": "",
      "price_amount": "-1",
      "price_currency": ""
    }
    """
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/classes" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
            "name": "This value is too short. It should have 1 character or more.",
            "priceAmount": "This value should be either positive or zero.",
            "priceCurrency": "This value should have exactly 3 characters."
          }
      }
    """

  Scenario: Receive an error message when name is longer than 255 characters
    Given the request body is:
    """
    {
      "name": "A very long but extremely exciting name for a class, A very long but extremely exciting name for a class, A very long but extremely exciting name for a class, A very long but extremely exciting name for a class, A very long but extremely exciting name for a class ",
      "price_amount": 2345,
      "price_currency": "PLN"
    }
    """
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/classes" using HTTP POST
    Then the response code is 400
    And the response body contains JSON:
    """
      {
          "code": 400,
          "error": "Validation error",
          "messages": {
              "name": "This value is too long. It should have 255 characters or less."
          }
      }
    """
