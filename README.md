# Introduction

Verse key features:

- _Plain architecture_: Compact set of tiny core objects. Minimum (in fact zero) 
"best practices" such as factories, service locators and other stuff, that makes code
hard to understand.
- _Immutability_: Every object is immutable.
- _SOLID and OOP_: There are no classes and functions that do not implement interfaces.
No static functions either.
- _Composition over inheritance_: No abstract classes and inheritance use.

## Decorator-based nature

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

## Routing

Routes are stored in yaml file, for example:
```yaml
/auth: Auth/AuthForm

/auth/process:
  action: Auth/AuthProcess
  method: POST

```

Each line which starts from "/" is a separate route. Default HTTP method is GET.
You can define route like this:
```yaml
/auth: Auth/AuthForm
```
or like that, no difference:
```yaml
/auth:
  action: Auth/AuthProcess
  method: GET
```

You can use tokens to retrieve variables from URI:
```yaml
/blog/read/{id}: Blog/ReadPost
```
or even
```yaml
/blog/list/{tag}/{author}: Blog/ListPosts
```

Use tokens in action:
```php
class ListPosts implements Action
{
    public function run(Env $env, User $user): Response
    {
        $tag = $env->srv()->route()->token('tag');
        $author = $env->srv()->route()->token('author');
        
        return new Response\RespHtml($env->srv()->tpl()->render(
            'blog/list',
            [
                'posts' => (new BlogPosts($tag, $author))->list(),
                'tag' => $tag,
                'author' => $author
            ]
        ));
    }
}
```

TBA