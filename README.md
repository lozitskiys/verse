# Introduction

Verse key features:

- _Plain architecture_: Compact set of tiny core objects. Minimum (in fact zero) 
"best practices" such as factories, service locators and other stuff, that makes code
hard to understand.
- _Immutability_: Every object is immutable.
- _SOLID and OOP_: There are no classes and functions that do not implement interfaces.
No static functions either.
- _Composition over inheritance_: No abstract classes and inheritance use.

Verse uses Action Domain Responder pattern. Example of simple action:
```php
<?php

namespace Actions;

use Verse\ActionJson;
use Verse\Env;
use Verse\Response;
use Verse\Response\RespJson;
use Verse\User;

class NumbersListJson implements ActionJson
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