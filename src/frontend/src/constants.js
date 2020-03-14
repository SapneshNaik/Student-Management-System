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
  'VIEW_SPECIFIC_USER': 'View Specific User',
  'EDIT_ALL_USERS': 'Edit All Users',
  'DELETE_ALL_USERS': 'Delete All Users',

  'VIEW_ALL_STUDENTS': 'View All Students',
  'VIEW_SPECIFIC_STUDENT': 'View Specific Student',
  'EDIT_ALL_STUDENTS': 'Edit All Students',
  'DELETE_ALL_STUDENTS': 'Delete All Students',

  'VIEW_ALL_STAFF': 'View All Staff',
  'VIEW_SPECIFIC_STAFF': 'View Specific Staff',
  'EDIT_ALL_STAFF': 'Edit All Staff',
  'DELETE_ALL_STAFF': 'Delete All Staff',
  'SEARCH_STAFF' : 'Search All Staff',

  'VIEW_ALL_PARENTS': 'View All Parents',
  'VIEW_SPECIFIC_PARENT': 'View Specific Parent',
  'EDIT_ALL_PARENTS': 'Edit All Parents',
  'DELETE_ALL_PARENTS': 'Delete All Parents',
  'SEARCH_PARENT' : 'Search All Parents',

  'VIEW_ALL_ADMINS': 'View All Admins',
  'VIEW_SPECIFIC_ADMIN': 'View Specific Admin',
  'EDIT_ALL_ADMINS': 'Edit All Admins',
  'DELETE_ALL_ADMINS': 'Delete All Admins',

  'VIEW_ALL_PERMISSIONS': 'View All Permissions',
  'VIEW_SPECIFIC_ROLE': 'View Specific Role',
  'VIEW_ALL_ROLES': 'View All Roles',
  'EDIT_ALL_ROLES': 'Edit All Roles',
  'DELETE_ALL_ROLES': 'Edit All Roles',
};

const ROLE_HELP = [
  {
    "operation": "Register Admin",
    "permissions": PERMISSIONS.REGISTER_ADMIN + ", " + PERMISSIONS.VIEW_ALL_ROLES,
  },
  {
    "operation": "Register Staff",
    "permissions": PERMISSIONS.REGISTER_STAFF + ", " + PERMISSIONS.VIEW_ALL_ROLES,
  },
  {
    "operation": "Register Student",
    "permissions": PERMISSIONS.REGISTER_STUDENT + ", " + PERMISSIONS.REGISTER_PARENT + ", " + PERMISSIONS.SEARCH_PARENT +
      ", " + PERMISSIONS.VIEW_SPECIFIC_PARENT + ", " + PERMISSIONS.SEARCH_STAFF
  },
  {
    "operation": "View Admins (Table)",
    "permissions": PERMISSIONS.VIEW_ALL_ADMINS,
  },

  {
    "operation": "View Admin Profile",
    "permissions": PERMISSIONS.VIEW_SPECIFIC_ADMIN,
  },

  {
    "operation": "View Staff (Table)",
    "permissions": PERMISSIONS.VIEW_ALL_STAFF,
  },

  {
    "operation": "View Staff Profile",
    "permissions": PERMISSIONS.VIEW_SPECIFIC_STAFF,
  },

  {
    "operation": "View Students (Table)",
    "permissions": PERMISSIONS.VIEW_ALL_STUDENTS,
  },

  {
    "operation": "View Student Profile",
    "permissions": PERMISSIONS.VIEW_SPECIFIC_STUDENT,
  },

  {
    "operation": "View Parents (Table)",
    "permissions": PERMISSIONS.VIEW_ALL_PARENTS,
  },

  {
    "operation": "View Parent Profile",
    "permissions": PERMISSIONS.VIEW_SPECIFIC_PARENT,
  },

  {
    "operation": "Create Role",
    "permissions": PERMISSIONS.EDIT_ALL_ROLES + ", " + PERMISSIONS.VIEW_ALL_PERMISSIONS,
  },
  {
    "operation": "Edit Role",
    "permissions": PERMISSIONS.VIEW_ALL_ROLES + ", " + PERMISSIONS.EDIT_ALL_ROLES + ", " + PERMISSIONS.VIEW_ALL_PERMISSIONS,
  },
  {
    "operation": "View Roles (Table)",
    "permissions": PERMISSIONS.VIEW_ALL_ROLES,
  },

  {
    "operation": "View Role Details",
    "permissions": PERMISSIONS.VIEW_SPECIFIC_ROLE,
  },

  {
    "operation": "View Permissions",
    "permissions": PERMISSIONS.VIEW_ALL_PERMISSIONS,
  },
];


const VALIDATION_MESSAGES = {
  custom: {
    email: {
      required: 'Email address is required',
      email: "Email should be a valid email address"
    },
    login_id: {
      required: 'Login Id is required',
    },
    phone_number: {
      required: 'Phone number is required',
      numeric: 'Phone number can only contain numbers',
      max: 'Enter a 10-13 digit phone number',
      min: 'Enter a 10-13 digit phone number',
    },
    alternate_phone_number: {
      numeric: 'Alternate phone number can only contain numbers',
    },
    password: {
      required: 'Account password is required',
    },
    password_confirmation: {
      required: 'Confirm your password by entering it here',
    },
    address: {
      required: 'Address is required',
    },
    pin_code: {
      required: 'Pin code is required',
      numeric: 'Pin code can only contain numbers',
      max: 'Pin code cannot contain more than 10 characters.',
      min: 'Pin code should be minimum 5 characters.',
    },
    city: {
      required: 'City is required',
      max: 'City cannot contain more than 50 characters.',
      min: 'City should be minimum 3 characters.',
    },
    district: {
      required: 'District is required',
      max: 'District cannot contain more than 50 characters.',
      min: 'District should be minimum 3 characters.',
    },
    state: {
      required: 'State is required',
      max: 'State cannot contain more than 50 characters.',
      min: 'State should be minimum 3 characters.',
    },
    country: {
      required: 'Country is required',
      max: 'Country cannot contain more than 50 characters.',
      min: 'Country should be minimum 3 characters.',
    },

    staff_linked_id: {
      numeric: 'Staff Id can only contain numbers',
      max: 'Staff Id cannot contain more than 50 characters.',
      min: 'Staff Id should be minimum 3 characters.',
    },

    father_full_name: {
      required: "Father's full name is required",
      max: "Father's full name cannot contain more than 150 characters.",
      min: "Father's full name should be minimum 3 characters.",
      alpha_spaces: "Father's full name can contain only alphabets and spaces",
    },

    father_qualification: {
      required: "Father's qualification is required",
    },

    mother_qualification: {
      required: "Mother's qualification is required",
    },

    father_contact_number: {
      required: "Father's contact number is required",
      max: "Father's contact number cannot contain more than 13 digits.",
      min: "Father's contact number should be minimum 10 digits.",
      numeric: "Father's contact number can only contain numbers",
    },

    mother_contact_number: {
      required: "Mother's contact number is required",
      max: "Mother's contact number cannot contain more than 13 digits.",
      min: "Mother's contact number should be minimum 10 digits.",
      numeric: "Mother's contact number can only contain numbers",
    },

    father_profession: {
      required: "Father's profession is required",
    },

    mother_profession: {
      required: "Mother's profession is required",
    },

    father_designation: {
      required: "Father's designation is required",
      max: "Father's designation cannot contain more than 50 characters.",
      min: "Father's designation should be minimum 3 characters.",
      alpha_spaces: "Father's designation can contain only alphabets and spaces",
    },

    mother_designation: {
      max: "Mother's designation cannot contain more than 150 characters.",
      min: "Mother's designation should be minimum 3 characters.",
      alpha_spaces: "Mother's designation can contain only alphabets and spaces",
    },

    father_net_annual_income: {
      required: "Father's net annual income is required",
      max: "Father's net annual income cannot contain more than 50 characters.",
      min: "Father's net annual income should be minimum 3 characters.",
      numeric: "Father's net annual income can only contain numbers",
    },

    mother_net_annual_income: {
      max: "Mother's net annual income cannot contain more than 150 characters.",
      min: "Mother's net annual income should be minimum 3 characters.",
      numeric: "Mother's net annual income can only contain numbers",
    },

    father_pan: {
      required: "Father's PAN is required",
      regex: "Invalid PAN",
    },

    mother_pan: {
      max: "Mother's PAN cannot contain more than 150 characters.",
      regex: "Invalid PAN",
    },

  }
};

export const QUALIFICATION = [
  'No Formal Education',
  'Primary Education',
  'Secondary Education or High School',
  'Vocational Qualification',
  'Diploma',
  'Graduate',
  'Post Graduate',
  'Doctorate or higher'
];

export const PROFESSION = [
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

export default {
  PREFIXES: PREFIXES,
  GENDER: GENDER,
  RELIGIONS: RELIGIONS,
  BLOOD_GROUP: BLOOD_GROUP,
  PERMISSIONS: PERMISSIONS,
  ROLE_HELP: ROLE_HELP,
  VALIDATION_MESSAGES: VALIDATION_MESSAGES,
  QUALIFICATION: QUALIFICATION,
  PROFESSION: PROFESSION,
}
