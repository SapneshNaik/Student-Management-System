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
        //register perms
        'REGISTER_STUDENT' => 'Register Student',
        'REGISTER_ADMIN' => 'Register Admin',
        'REGISTER_STAFF' => 'Register Staff',

        //CRUD Perms
        'VIEW_ALL_USERS' => 'View All Users',
        'EDIT_ALL_USERS' => 'Edit All Users',
        'DELETE_ALL_USERS' => 'Delete All Users',

        'VIEW_ALL_STUDENTS' => 'View All Students',
        'EDIT_ALL_STUDENTS' => 'Edit All Students',
        'DELETE_ALL_STUDENTS' => 'Delete All Students',

        'VIEW_ALL_STAFF' => 'View All Staff',
        'EDIT_ALL_STAFF' => 'Edit All Staff',
        'DELETE_ALL_STAFF' => 'Delete All Staff',

        'VIEW_ALL_PARENTS' => 'View All Parents',
        'EDIT_ALL_PARENTS' => 'Edit All Parents',
        'DELETE_ALL_PARENTS' => 'Delete All Parents',

        'VIEW_ALL_ADMINS' => 'View All Admins',
        'EDIT_ALL_ADMINS' => 'Edit All Admins',
        'DELETE_ALL_ADMINS' => 'Delete All Admins',
    ];

    public const USER_STATUS = ["Active", "Inactive", "Final Record"];

    public const BASE_ROLE = ["Admin", "Staff", "Student", "Parent"];
}