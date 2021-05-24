<?php

namespace Verse\Action;

use Verse\Access\AccessLevel;
use Verse\Access\GuestAccess;
use Verse\Action;
use Verse\Env;
use Verse\Error\MustAuthenticateException;
use Verse\Response;
use Verse\User;

/**
 * Action decorator.
 *
 * User has to be authorized, or Action should implement GuestAccess interface.
 */
class ActionAuthorized implements Action
{
    public function __construct(
        private Action $action,
        private AccessLevel $guestAccLvl
    ) {
    }

    /**
     * @param Env $env
     * @param User $user
     * @return Response
     * @throws MustAuthenticateException
     */
    public function run(Env $env, User $user): Response
    {
        $this->checkAccess($user);

        return $this->action->run($env, $user);
    }

    /**
     * @param User $user
     * @throws MustAuthenticateException
     */
    private function checkAccess(User $user): void
    {
        foreach (class_implements($this->action) as $k => $v) {
            if (GuestAccess::class === $k) {
                return;
            }
        }

        if (false === $this->guestAccLvl->check($user)) {
            throw new MustAuthenticateException();
        }

        // TODO more validations
        //throw new AccessDeniedException();
    }
}
