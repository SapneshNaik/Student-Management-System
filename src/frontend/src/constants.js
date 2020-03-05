const PREFIXES = ["Mr.", "Mrs.", "Miss", "Dr.", "Ms.", "Prof.", "Rev.", "Lady.", "Sir."];

const GENDER = ['Male', 'Female'];

const RELIGIONS = ['Hinduism',
  'Islam',
  'Christianity',
  'Sikhism',
  'Buddhism',
  'Jainism',
  'Zoroastrianism',
  'Other'];

const BLOOD_GROUP = [
  "A+",
  "A-",
  "B+",
  "B-",
  "AB+",
  "O+",
  "O-"
];

const PERMISSIONS = {
  'REGISTER_STUDENT': 'Register Student',
  'REGISTER_ADMIN': 'Register Admin',
  'REGISTER_STAFF': 'Register Staff',
  'REGISTER_PARENT': 'Register Parent',

  'VIEW_ALL_USERS': 'View All Users',
  'EDIT_ALL_USERS': 'Edit All Users',
  'DELETE_ALL_USERS': 'Delete All Users',

  'VIEW_ALL_STUDENTS': 'View All Students',
  'EDIT_ALL_STUDENTS': 'Edit All Students',
  'DELETE_ALL_STUDENTS': 'Delete All Students',

  'VIEW_ALL_STAFF': 'View All Staff',
  'EDIT_ALL_STAFF': 'Edit All Staff',
  'DELETE_ALL_STAFF': 'Delete All Staff',

  'VIEW_ALL_PARENTS': 'View All Parents',
  'EDIT_ALL_PARENTS': 'Edit All Parents',
  'DELETE_ALL_PARENTS': 'Delete All Parents',

  'VIEW_ALL_ADMINS': 'View All Admins',
  'EDIT_ALL_ADMINS': 'Edit All Admins',
  'DELETE_ALL_ADMINS': 'Delete All Admins',

  'VIEW_ALL_PERMISSIONS': 'View All Permissions',
  'VIEW_ALL_ROLES': 'View All Roles',
  'EDIT_ALL_ROLES': 'Edit All Roles',
  'DELETE_ALL_ROLES': 'Edit All Roles',
};

export default {
  PREFIXES: PREFIXES,
  GENDER: GENDER,
  RELIGIONS: RELIGIONS,
  BLOOD_GROUP: BLOOD_GROUP,
  PERMISSIONS: PERMISSIONS,
}
