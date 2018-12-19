Simple REST Demo
===============
This project is a craft demo for my custom RESTfull API choices, it can help you build your API extremely faster.

## Features

* CRUD
* Swagger Doc
* API version(JMS serializer)
* Map request to entity via Symfony Form
* HAL
* Custom paginator(filter, sorting for pagination)

## Ingredients

* willdurand/hateoas-bundle
* lexik/jwt-authentication-bundle

## Functional tests

all APIs provided by this demo have functional test, simply run to test all APIs
```
vendor/bin/phpunit
```

if you just want to test a specific API, you can run
```
vendor/bin/phpunit --filter it_allows_to_create_comment
```
