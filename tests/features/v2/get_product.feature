Feature:
  In order to present offers to customers
  As a shop owner
  I want to have the possibility to get product

  Scenario: Can fetch product
    Given there is product with guid "2cf2d8fb2e4e8adb7658829cd1869436"
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products/2cf2d8fb2e4e8adb7658829cd1869436" using HTTP GET
    Then the response code is 200
    And the response body contains JSON:
    """
    {
      "uid": "2cf2d8fb2e4e8adb7658829cd1869436",
      "name": "__PRODUCT_NAME__",
      "price_amount": 1,
      "price_currency": "pln"
    }
    """

  Scenario: Response should be cached by client
    Given there is product with guid "2cf2d8fb2e4e8adb7658829cd1869436"
    And the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products/2cf2d8fb2e4e8adb7658829cd1869436" using HTTP GET
    Then the response code is 200
    And the "cache-control" response header matches "max-age=3600"
    And the "expires" response header matches date format
    And the "last-modified" response header matches date format

  Scenario: Receive a error message when UID format is invalid
    Given the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products/__INVALID_UID__" using HTTP GET
    Then the response code is 400
    And the response body contains JSON:
    """
    {
      "code": 400,
      "error": "Validation error",
      "messages": {
         "uid": "Given uid is invalid"
      }
    }
    """

  Scenario: Receive a error message when product does not exists
    Given the "Content-Type" request header is "application/json"
    And the "X-Accept-Version" request header is "v2"
    When I request "api/products/2cf2d8fb2e4e8adb7658829cd1869436" using HTTP GET
    Then the response code is 404
