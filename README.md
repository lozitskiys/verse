# Introduction

Example of index.php:
```php
<?php

/** @var \Verse\Env $env */
$env = require_once __DIR__ . '/../env.php';

$user = new CurrentUser($env->pdo());

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

/auth/process POST: Auth/AuthProcess
```

Each line which starts from "/" is a separate route. Default HTTP method is GET.
You can define route like this:
```yaml
/auth: Auth/AuthForm
```
or like that:
```yaml
/auth GET: Auth/AuthForm
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
        $tag = $env->route()->token('tag');
        $author = $env->route()->token('author');
        
        return new Response\RespHtml($env->tpl()->render(
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