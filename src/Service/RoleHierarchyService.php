<?php


namespace App\Service;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;


class RoleHierarchyService
{

    public function getUserRolesWithHierarchy(RoleHierarchyInterface $roleHierarchy, UserInterface $user): array
    {
        $userRoles = $user->getRoles(); // Rôles directs
        $allRoles = $roleHierarchy->getReachableRoleNames($userRoles); // Résout la hiérarchie
        return $allRoles;
    }
}
