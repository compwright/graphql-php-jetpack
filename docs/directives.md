# Directives

Easily add support for custom directives with webonyx/graphql-php

## Setup

Directives are run after your field resolvers, to modify the result. To do this, append the directive executor to your existing field resolver as follows:

```php
use Compwright\GraphqlPhpJetpack\Execution\ChainExecutor;
use Compwright\GraphqlPhpJetpack\Execution\DirectiveExecutor;

/** @var GraphQL\Server\ServerConfig $config */
$config->setFieldResolver(
    new ChainExecutor(
        $yourFieldResolver,
        new DirectiveExecutor()
    )
);
```

To use a custom directive handler, you must define each custom directive in your schema, and call it everywhere you plan to use it. For example:

```graphql
directive @changeCase(case: String!) on FIELD_DEFINITION | FIELD

type Query {
    user: User
}

type User {
    # Make firstName uppercase
    firstName: String! @changeCase(case: "upper")
    # Make lastName lowercase
    firstName: String! @changeCase(case: "lower")
}
```

## Jetpack Directives

### @changeCase(case: String!)

Change the case of a value. Supported `case` values:

* `upper`
* `lower`

### @scalar(class: String!)

Attaches validation methods from the specified class to a custom scalar type.

> Note: this directive is not loaded the normal way. To use it, pass an instance of ScalarDirectiveDecorator
> as the $schemaTypeDecorator argument to SchemaBuilder::build(). See the [scalar documentation](scalars.md)
> for details.
