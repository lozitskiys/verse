<?php

namespace Verse\Action;

use Verse\Access\AccessLevel;
use Verse\Access\GuestAccess;
use Verse\Action;
use Verse\Env;
use Verse\Errors\MustAuthenticateException;
use Verse\Response;
use Verse\User;

/**
 * Action decorator.
 *
 * User has to be authorized, or Action should implement GuestAccess interface.
 */
class ActionAuthorized implements Action
{
    private $action;
    private $guestAccLvl;

    public function __construct(
        Action $action,
        AccessLevel $guestAccLvl
    ) {
        $this->action = $action;
        $this->guestAccLvl = $guestAccLvl;
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