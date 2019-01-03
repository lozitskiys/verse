# Introduction

Verse key features:

- _Plain architecture_: Compact set of tiny core objects. Minimum (in fact zero) 
"best practices" such as factories, service locators and other stuff, that makes code
hard to understand.
- _Immutability_: Every object is immutable.
- _SOLID and OOP_: There are no classes and functions that do not implement interfaces.
No static functions either.
- _Composition over inheritance_: No abstract classes and inheritance use.

## Decorator based

Example of index.php:
```php
<?php

/** @var \Verse\Env $env */
$env = require_once __DIR__ . '/../env.php';

$user = new CurrentUser($env->srv()->pdo());

$app = 
    // App decorator
    new AppErrorLevel(
        // App decorator
        new AppLocaleAndTz(
            // App decorator
            new AppSession(
                // Base App implementation
                new AppBase()
            )
        )
    );

$action = 
    // Action decorator
    new ActionAuthorized(
        // Base Action implementation
        new NumbersListJson(),
        new GuestAccessLvl()
    );

$app->start($action, $env, $user);
```

Verse uses Action Domain Responder pattern. Example of simple action:
```php
<?php

namespace Actions;

class NumbersListJson implements Action
{
    public function run(Env $env, User $user): Response
    {
        return new RespJson([
            'result' => 'ok',
            'list' => [1, 2, 3, 4]
        ]);
    }
}
```

TBA