<?php

namespace App\Enums;

enum UserRole: string
{
    case Parent = 'parent';
    case PhotoManager = 'photo_manager';
    case OrganizationCoordinator = 'organization_coordinator';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Parent => 'Parent / Customer',
            self::PhotoManager => 'Photo Manager',
            self::OrganizationCoordinator => 'Organization Coordinator',
            self::Admin => 'Administrator',
        };
    }
}
