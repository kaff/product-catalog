ProductCatalog
============================

### Make Request

## Example POST /api/products request:

```
POST /api/products HTTP/1.1
HOST: 127.0.0.1
content-type: application/json
x-accept-version: v2
content-length: 77

{
  "name": "Product name",
  "price_amount": 2345,
  "price_currency": "PLN"
}
```
## Example POST /api/products response:

202 Accepted

```
allow: POST
cache-control: no-cache, no-store, private
content-type: application/json
expires: 0
location: /api/products/ca760a2be282e1128bde03c11fd58483
pragma: no-cache
content-length: 266

{
    "_links": {
        "status": {
            "href": "//example.com/api/products/status/a7fa58d932e666ece80124199cb83ae7"
        }
    },
    "status": {
        "status": "Pending"
    },
    "uid": {
        "hash": "a7fa58d932e666ece80124199cb83ae7"
    }
}
```
