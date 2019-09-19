<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
  public function loadUserByUsername($username)
  {
    throw new \Exception('TODO: fill in loadUserByUsername() inside ' . __FILE__);
  }

  public function refreshUser(UserInterface $user)
  {
    if (!$user instanceof User) {
      throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
    }

    throw new \Exception('TODO: fill in refreshUser() inside ' . __FILE__);
  }

  public function supportsClass($class)
  {
    return User::class === $class;
  }
}
