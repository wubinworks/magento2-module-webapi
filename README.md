# Features and Usage

*(Only works for REST endpoints.)*

This module is designed as a dependency for developing other modules.

**1. Support for `Content-Type: application/x-www-form-urlencoded`**\
Magento WEBAPI_REST recognizes `application/json`, `application/xml`, `application/xhtml+xml`, `text/xml` Content-Type out of the box, any others will result in an error message like
`"message": "Server cannot understand Content-Type HTTP header media type application/x-www-form-urlencoded"`

However, `application/x-www-form-urlencoded` is commonly used in <ins>forms</ins> and many third part software could only POST this content type.

**How to use?**\
Just make the request normally using `Content-Type: application/x-www-form-urlencoded` and add an additional custom header `Use-Deprecated-Content-Type: 1`.\
**Note: You MUST include the `Use-Deprecated-Content-Type: 1` header in your request, otherwise it does not work!**

**2. Conditionally modifies JSON output behavior**\
When developing a service class(usually a file called someActionManagement.php in Model folder), if it returns an array like below,
```
return [
    'code' => 0,
    'message' => 'Success',
    'data' => [
        'customer_id' => 1
    ]
];
```
Magento encloses the returned data in an array parentheses and property names got stripped out.\
Output:
```
[
    0,
    "Success",
    {
        "customer_id": 1
    }
]
```
This may be not what you want.\
If the service class returns
```
return [
    'dummy' => [
        'code' => 0,
        'message' => 'Success',
        'data' => [
            'customer_id' => 1
        ]
    ]
];
```
the output becomes
```
[
    {
        "code": 0,
        "message": "Success",
        "data": {
            "customer_id": 1
        }
    }
]
```
<ins>Note the outermost `[]`, many third party software expects the output to be an object, though.</ins>

**How to use?**\
Add `'type' => 'simple_array'` in the output array, i.e.,
```
return [
    'code' => 0,
    'message' => 'Success',
    'data' => [
        'customer_id' => 1
    ],
    'type' => 'simple_array' // Add this key-value pair
];
```
Then output will be
```
{
    "code": 0,
    "message": "Success",
    "data": {
        "customer_id": 1
    }
}
```
**Note: the JSON output will not have `"type": "simple_array"`, it got removed!**

# Requirements
**Only tested under Magento 2.4**

# Installation
**`composer require wubinworks/module-webapi`**
