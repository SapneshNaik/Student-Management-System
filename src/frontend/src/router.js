import Vue from 'vue'
import Router from 'vue-router'
import 'firebase/auth'

import store from "@/store/store.js"
import commons from "./commons";


Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  scrollBehavior() {
    return {x: 0, y: 0}
  },
  routes: [

    {
      path: '',
      component: () => import('./layouts/main/Main.vue'),
      children: [
        {
          path: '/',
          redirect: '/login',
        },
        {
          path: '/dashboard/sms',
          name: 'dashboard-sms',
          component: () => import('./views/DashboardAnalytics.vue'),
          meta: {
            authRequired: 'true',
            resource: "Dashboard"
          }
        },

        {
          path: '/user/:id/profile',
          name: 'sms-user-profile',
          props: true,
          component: () => import('@/views/pages/user/Profile.vue'),
          meta: {
            //TODO: change this
            breadcrumb: [
              {title: 'Home', url: '/dashboard/sms'},
              {title: 'Profile', active: true},
            ],
            authRequired: 'true',
            pageTitle: 'Profile',
            no_scroll: true,
          },
        },

        {
          path: '/user/:id/edit',
          name: 'sms-user-profile-edit',
          props: true,
          component: () => import('@/views/pages/user/ProfileEdit.vue'),
          meta: {
            breadcrumb: [
              {title: 'Home', url: '/dashboard/sms'},
              {title: 'Profile', url: '/dashboard/sms'},
              {title: 'Edit Profile', active: true},
            ],

            authRequired: 'true',
            pageTitle: 'Edit Profile',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/register/admin',
          name: 'sms-register-admin',
          props: true,
          component: () => import('@/views/pages/admin/AdminCreateWizard.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/register/student',
          name: 'sms-register-student',
          props: true,
          component: () => import('@/views/pages/student/StudentCreateWizard.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },
        {
          path: '/dashboard/sms/register/staff',
          name: 'sms-register-staff',
          props: true,
          component: () => import('@/views/pages/staff/StaffCreateWizard.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/view/admins',
          name: 'sms-view-admins',
          props: true,
          component: () => import('@/views/pages/admin/AdminTable.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/view/parents',
          name: 'sms-view-parents',
          props: true,
          component: () => import('@/views/pages/parent/ParentTable.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/view/staff',
          name: 'sms-view-staff',
          props: true,
          component: () => import('@/views/pages/staff/StaffTable.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },
        {
          path: '/dashboard/sms/view/students',
          name: 'sms-view-students',
          props: true,
          component: () => import('@/views/pages/student/StudentTable.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },
        {
          path: '/dashboard/sms/roles/create',
          name: 'sms-role-create',
          props: true,
          component: () => import('@/views/pages/role_permission/RoleCreate.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/roles/view',
          name: 'sms-role-list',
          props: true,
          component: () => import('@/views/pages/role_permission/RoleTable.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/permissions/view',
          name: 'sms-perm-list',
          props: true,
          component: () => import('@/views/pages/role_permission/PermTable.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/roles/view/:id',
          name: 'sms-role-specific-view',
          props: true,
          component: () => import('@/views/pages/role_permission/RoleView.vue'),
          meta: {
            pageTitle: 'Role Details',
            breadcrumb: [
              {title: 'Home', url: '/dashboard/sms'},
              {title: 'View Roles', url: '/dashboard/sms/roles/view'},
              {title: 'Role Details', active: true},
            ],
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/sms/roles/edit/:id',
          name: 'sms-edit-role',
          props: true,
          component: () => import('@/views/pages/role_permission/RoleEdit.vue'),
          meta: {
            authRequired: 'true',
            no_scroll: true,
          },
        },

        {
          path: '/dashboard/ecommerce',
          name: 'dashboard-ecommerce',
          component: () => import('./views/DashboardECommerce.vue'),
          meta: {
            rule: 'admin'
          }
        },
      ],
    },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
    {
      path: '',
      component: () => import('@/layouts/full-page/FullPage.vue'),
      children: [
        // =============================================================================
        // PAGES
        // =============================================================================
        {
          path: '/login',
          name: 'login',
          component: () => import('@/views/pages/login/Login.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/callback',
          name: 'auth-callback',
          component: () => import('@/views/Callback.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/register',
          name: 'page-register',
          component: () => import('@/views/pages/register/Register.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/forgot-password',
          name: 'page-forgot-password',
          component: () => import('@/views/pages/ForgotPassword.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/reset-password',
          name: 'page-reset-password',
          component: () => import('@/views/pages/ResetPassword.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/lock-screen',
          name: 'page-lock-screen',
          component: () => import('@/views/pages/LockScreen.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/comingsoon',
          name: 'page-coming-soon',
          component: () => import('@/views/pages/ComingSoon.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/error-404',
          name: 'page-error-404',
          component: () => import('@/views/pages/Error404.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/error-500',
          name: 'page-error-500',
          component: () => import('@/views/pages/Error500.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/not-authorized',
          name: 'page-not-authorized',
          component: () => import('@/views/pages/NotAuthorized.vue'),
          meta: {
            rule: 'editor'
          }
        },
        {
          path: '/pages/maintenance',
          name: 'page-maintenance',
          component: () => import('@/views/pages/Maintenance.vue'),
          meta: {
            rule: 'editor'
          }
        },
      ]
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    }
  ],
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
  if (appLoading) {
    appLoading.style.display = "none";
  }
})

router.beforeEach((to, from, next) => {

  //logged in user trying to view log in page
  if (to.name === 'login' && store.state.auth.isUserLoggedIn()) {
    router.push({name: 'dashboard-sms'})
  } else if (to.meta.authRequired) {
    if (!store.state.auth.isUserLoggedIn()) {
      router.push({name: 'login', query: {to: to.name}})
    } else {
      if(!commons.hasAccess(to.name, to.params.id)){
        router.push({name: 'page-not-authorized'})
      }
    }
  }

  return next()
});

export default router
