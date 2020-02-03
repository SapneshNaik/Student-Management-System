<?php
namespace App;


class Constants
{
    public const PREFIXES = ["Mr.", "Mrs.", "Miss", "Dr.", "Ms.", "Prof.", "Rev.", "Lady.", "Sir."];

    public const ROLES = [
        'SUPER_ADMIN' => "Super Admin",
        'ADMIN' => "Admin",
        'NON_TEACHING_STAFF' => "Non Teaching Staff",
        'TEACHING_STAFF' => "Teaching Staff"
    ];

    public const PERMISSIONS = [
        'REGISTER_STUDENT' => 'Register Student',
        'REGISTER_ADMIN' => 'Register Admin',
        'REGISTER_STAFF' => 'Register Staff',
    ];

    public const USER_STATUS = ["Active", "Inactive", "Final Record"];

    public const BASE_ROLE = ["Admin", "Staff", "Student", "Parent"];
}