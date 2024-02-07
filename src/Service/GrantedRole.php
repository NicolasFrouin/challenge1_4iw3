<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class GrantedRole
{
    public function __construct(private AccessDecisionManagerInterface $accessDecisionManager)
    {
    }

    public function isGranted(User $user, array $attributes, mixed $object = null): bool
    {
        if (!is_array($attributes)) {
            $attributes = [$attributes];
        }

        $token = new UsernamePasswordToken($user, "none", $user->getRoles());

        return $this->accessDecisionManager->decide($token, $attributes, $object);
    }
}
