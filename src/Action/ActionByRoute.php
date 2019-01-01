<?php

namespace Verse\Action;

use Verse\Action;
use Verse\Env;
use Verse\Response;
use Verse\User;

class ActionByRoute implements Action
{
    public function run(Env $env, User $user): Response
    {
        $className = 'Actions';
        $actionPath = $env->srv()->route()->action();

        if (false !== strpos($actionPath, '/')) {
            foreach (explode('/', $actionPath) as $subDir) {
                $className .= '\\' . $subDir;
            }
        } else {
            $className .= '\\' . $actionPath;
        }

        /** @var Action $action */
        $action = new $className;

        return $action->run($env, $user);
    }
}