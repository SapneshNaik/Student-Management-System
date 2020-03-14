<?php

namespace App;

class Constants
{
    public const PREFIXES = ["Mr.", "Mrs.", "Miss", "Dr.", "Ms.", "Prof.", "Rev.", "Lady.", "Sir."];

    public const GENDER = ['Male', 'Female'];

    public const CASTE = ['Brahmin', 'Lingayat', 'Thakur', 'Suryavanshi', 'Dalit', "Chammar", "Devadiga", "GSB"];

    public const CASTE_CATEGORY = ['SC', 'ST', 'OBC', 'General', '2A', "2B", "3B", "3A"];

    public const RELATIONSHIP = ['Father', 'Mother', 'Other'];

    public const ADDRESS_TYPES = ['Communication', 'Permanent'];

    public const RELIGIONS = [
        'Hinduism',
        'Islam',
        'Christianity',
        'Sikhism',
        'Buddhism',
        'Jainism',
        'Zoroastrianism',
        'Other'
    ];

    public const BLOOD_GROUP = [
        "A+",
        "A-",
        "B+",
        "B-",
        "AB+",
        "O+",
        "O-"
    ];

    public const ROLES = [
        'SUPER_ADMIN' => "Super Admin",
        'ADMIN' => "Admin",
        'STUDENT' => "Student",
        'NON_TEACHING_STAFF' => "Non Teaching Staff",
        'TEACHING_STAFF' => "Teaching Staff",
    ];

    public const PERMISSIONS = [
        //register perms
        'REGISTER_STUDENT' => 'Register Student',
        'REGISTER_ADMIN' => 'Register Admin',
        'REGISTER_STAFF' => 'Register Staff',
        'REGISTER_PARENT' => 'Register Parent',

        //CRUD Perms
        'VIEW_ALL_USERS' => 'View All Users',
        'VIEW_SPECIFIC_USER' => 'View Specific User',
        'EDIT_ALL_USERS' => 'Edit All Users',
        'DELETE_ALL_USERS' => 'Delete All Users',

        'VIEW_ALL_STUDENTS' => 'View All Students',
        'VIEW_SPECIFIC_STUDENT' => 'View Specific Student',
        'EDIT_ALL_STUDENTS' => 'Edit All Students',
        'DELETE_ALL_STUDENTS' => 'Delete All Students',

        'VIEW_ALL_STAFF' => 'View All Staff',
        'VIEW_SPECIFIC_STAFF' => 'View Specific Staff',
        'EDIT_ALL_STAFF' => 'Edit All Staff',
        'DELETE_ALL_STAFF' => 'Delete All Staff',
        'SEARCH_STAFF' => 'Search All Staff',

        'VIEW_ALL_PARENTS' => 'View All Parents',
        'VIEW_SPECIFIC_PARENT' => 'View Specific Parent',
        'EDIT_ALL_PARENTS' => 'Edit All Parents',
        'DELETE_ALL_PARENTS' => 'Delete All Parents',
        'SEARCH_PARENT' => 'Search All Parents',

        'VIEW_ALL_ADMINS' => 'View All Admins',
        'VIEW_SPECIFIC_ADMIN' => 'View Specific Admin',
        'EDIT_ALL_ADMINS' => 'Edit All Admins',
        'DELETE_ALL_ADMINS' => 'Delete All Admins',

        'VIEW_ALL_ROLES' => 'View All Roles',
        'VIEW_SPECIFIC_ROLE' => 'View Specific Role',
        'EDIT_ALL_ROLES' => 'Edit All Roles',
        'DELETE_ALL_ROLES' => 'Edit All Roles',

        'VIEW_ALL_PERMISSIONS' => 'View All Permissions',


    ];

    public const USER_STATUS = ["Active", "Inactive", "Final Account"];

    public const BASE_ROLE = ["Admin", "Staff", "Student", "Parent"];

    public const QUALIFICATION = [
        'No Formal Education',
        'Primary Education',
        'Secondary Education or High School',
        'Vocational Qualification',
        'Diploma',
        'Graduate',
        'Post Graduate',
        'Doctorate or higher'
    ];

    public const PROFESSION = [
        "Architect",
        "Accountant",
        "Teacher",
        "Physician",
        "Lawyer",
        "Engineer",
        "Technician",
        "Pharmacist",
        "Veterinarian",
        "Surveyor",
        "Software Developer",
        "Dietitian",
        "Electrician",
        "Scientist",
        "Psychologist",
        "Chef",
        "Labour",
        "Consultant",
        "Technologist",
        "Designer",
        "Librarian",
        "Mechanic",
        "Hairdresser",
        "Surgeon",
        "Police Officer",
        "Artist",
        "Firefighter",
        "Actor",
        "Plumber",
        "Dentist",
        " Midwife",
        "Medical Laboratory Scientist",
        "Actuary",
        "Physiotherapist",
        "Waiting Staff",
        "Health Professional",
        "Secretary",
        "Journalist",
        "Radiographer",
        "Broker",
        "Judge",
        "Social worker",
        "Homemaker",
    ];
}
