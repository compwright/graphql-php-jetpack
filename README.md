# graphql-php-jetpack

Unlock new [graphql-php](https://github.com/webonyx/graphql-php) superpowers with Jetpack scalar and directive support

[![Validate](https://github.com/compwright/graphql-php-jetpack/actions/workflows/validate.yml/badge.svg)](https://github.com/compwright/graphql-php-jetpack/actions/workflows/validate.yml)
[![GitHub license](https://img.shields.io/github/license/compwright/graphql-php-jetpack.svg)](https://github.com/compwright/graphql-php-jetpack/blob/master/LICENSE)
[![Packagist](https://img.shields.io/packagist/v/compwright/graphql-php-jetpack.svg)](https://packagist.org/packages/compwright/graphql-php-jetpack)
[![Packagist](https://img.shields.io/packagist/dt/compwright/graphql-php-jetpack.svg)](https://packagist.org/packages/compwright/graphql-php-jetpack)

## Features

* Improve your GraphQL schema validation with custom scalars
* Post-process resolved field values with directives

## Installation

```
$ composer require compwright/graphql-php-jetpack
```

## Usage

Install Jetpack schema support at schema build time:

```php
use Compwright\GraphqlPhpJetpack\JetpackDecorator;
use GraphQL\Utils\BuildSchema;

$schemaTypeDecorator = new JetpackDecorator();
$schema = BuildSchema::build($ast, $schemaTypeDecorator);
```

Install Jetpack directive support at server config build time:

```php
use Compwright\GraphqlPhpJetpack\DirectiveResolver;
use GraphQL\Server\ServerConfig;
use GraphQL\Type\Definition\ResolveInfo;

$resolver = function ($root, array $args, $context, ResolveInfo $info) {
    // resolve field value
    return $root;
};

$serverConfig = ServerConfig::create()
    ->setFieldResolver(new DirectiveResolver($resolver));
```

Declare the directives and scalars you wish to use in your schema, and call them where desired:

```graphql
directive @uppercase on FIELD_DEFINITION

scalar Email

type User {
    email: Email! @uppercase
}

type Query {
    user: User!
}
```

## Jetpack Scalars

You can use the provided Scalars just like any other type in your schema definition.

### scalar BigInt

An arbitrarily long sequence of digits that represents a big integer.

### scalar Date

A date string with format `Y-m-d`, e.g. `2011-05-23`.

The following conversion applies to all date scalars:

- Outgoing values can either be valid date strings or `\DateTimeInterface` instances.
- Incoming values must always be valid date strings and will be converted to `\DateTimeImmutable` instances.

### scalar DateTime

A datetime string with format `Y-m-d H:i:s`, e.g. `2018-05-23 13:43:32`.

### scalar DateTimeTz

A datetime string with format `Y-m-d\TH:i:s.uP`, e.g. `2020-04-20T16:20:04+04:00`, `2020-04-20T16:20:04Z`.

### scalar Email

A [RFC 5321](https://tools.ietf.org/html/rfc5321) compliant email.

### scalar JSON

Arbitrary data encoded in JavaScript Object Notation. See https://www.json.org.

This expects a string in JSON format, not a GraphQL literal.

```graphql
type Query {
  foo(bar: JSON!): JSON!
}

# Wrong, the given value is a GraphQL literal object
{
  foo(bar: { baz: 2 })
}

# Correct, the given value is a JSON string representing an object
{
  foo(bar: "{ \"bar\": 2 }")
}
```

JSON responses will contain nested JSON strings.

```json
{
  "data": {
    "foo": "{ \"bar\": 2 }"
  }
}
```

### scalar Mixed

Loose type that allows any value. Be careful when passing in large `Int` or `Float` literals,
as they may not be parsed correctly on the server side. Use `String` literals if you are
dealing with really large numbers to be on the safe side.

### scalar Null

Always `null`. Strictly validates value is non-null, no coercion.

## Jetpack Directives

### directive @callback(fn: String!) on FIELD_DEFINITION

Execute a function on the resolved value

### directive @lowercase on FIELD_DEFINITION

Transform resolved text lowercase

### directive @uppercase on FIELD_DEFINITION

Transform resolved text uppercase

## License

MIT License
