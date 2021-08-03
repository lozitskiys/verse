<?php

namespace Verse\Action;

use Verse\Access\AccessLevel;
use Verse\Access\AdminAccess;
use Verse\Access\GuestAccess;
use Verse\Action;
use Verse\Env;
use Verse\Error\AccessDeniedException;
use Verse\Error\MustAuthenticateException;
use Verse\Response;
use Verse\User;

/**
 * Action decorator.
 *
 * User has to be authorized, or Action should implement GuestAccess interface.
 * In addition, user has to be admin
 */
class ActionAuthorized implements Action
{
    public function __construct(
        private Action $action,
        private ?AccessLevel $guestAccLvl,
        private ?AccessLevel $adminAccLvl
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
        $adminAccessNeeded = false;
        foreach (class_implements($this->action) as $k => $v) {
            if (GuestAccess::class === $k) {
                return;
            } elseif (AdminAccess::class === $k) {
                $adminAccessNeeded = true;
                break;
            }
        }

        if (null !== $this->guestAccLvl && false === $this->guestAccLvl->check($user)) {
            throw new MustAuthenticateException();
        }

        if (
            $adminAccessNeeded &&
            null !== $this->adminAccLvl &&
            false === $this->adminAccLvl->check($user)
        ) {
            throw new AccessDeniedException();
        }
    }
}
