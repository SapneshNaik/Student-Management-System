export default [
  {
    url: null,
    name: "User Management",

    icon: "UserIcon",
    i18n: "UserManagement",
    submenu: [
      {
        url: null,
        name: "Registration",
        slug: "dashboard-sms-register",
        i18n: "Registration",
        icon: "UserPlusIcon",
        submenu: [
          {
            url: '/dashboard/sms/register/admin',
            name: "Register Admin",
            slug: "dashboard-sms-register-admin",
            i18n: "RegisterAdmin",
          },
          {
            url: '/dashboard/sms/register/staff',
            name: "Register Staff",
            slug: "dashboard-sms-register-staff",
            i18n: "RegisterStaff",
          },
          {
            url: '/dashboard/sms/register/student',
            name: "Register Student",
            slug: "dashboard-sms-register-student",
            i18n: "RegisterStudent",
          },
        ]
      },
      {
        url: null,
        name: "View",
        slug: "dashboard-sms-view",
        i18n: "View",
        icon: "EyeIcon",
        submenu: [
          {
            url: '/dashboard/sms/view/admins',
            name: "View Admins",
            slug: "dashboard-sms-register-admins",
            i18n: "ViewAdmins",
          },
          {
            url: '/dashboard/sms/view/parents',
            name: "View Parents",
            slug: "dashboard-sms-register-parents",
            i18n: "ViewParents",
          },
          {
            url: '/dashboard/sms/view/staff',
            name: "View Staff",
            slug: "dashboard-sms-view-staff",
            i18n: "ViewStaff",
          },
          {
            url: '/dashboard/sms/view/students',
            name: "View Students",
            slug: "dashboard-sms-view-students",
            i18n: "ViewStudents",
          },
        ]
      },
    ],
  },
  {
    url: null,
    name: "Settings",

    icon: "SettingsIcon",
    i18n: "Settings",
    submenu: [
      {
        url: null,
        name: "Access Control",
        slug: "dashboard-sms-roles",
        i18n: "AccessControl",
        icon: "ShieldIcon",
        submenu: [
          {
            url: '/dashboard/sms/roles/create',
            name: "Create Role",
            slug: "dashboard-sms-create-role",
            icon: "PlusIcon",
            i18n: "CreateRole",
          },
          {
            url: '/dashboard/sms/roles/view',
            name: "View Roles",
            slug: "dashboard-sms-view-role",
            icon: "EyeIcon",
            i18n: "ViewRole",
          },
          {
            url: '/dashboard/sms/permissions/view',
            name: "View Permissions",
            slug: "dashboard-sms-view-permissions",
            icon: "EyeIcon",
            i18n: "ViewPerms",
          }
        ]
      },
    ],
  },
]

