import state from "./store/state";
import constants from "./constants";

export default {
  getBaseUserModel: function (role) {
    return {
      email: "",
      login_id: "",
      phone_number: "",
      alternate_phone_number: "",
      password: "",
      password_confirmation: "",
      base_role: role
    }
  },

  getAddressModel: function (type) {
    return {
      address: "",
      pin_code: "",
      city: "",
      district: "",
      state: "",
      country: "",
      type: type
    }
  },

  getUserDataFromRole: function (role, id, state) {

    let all_user_data = null;
    switch (role) {

      case "Admin":
        all_user_data = state.userManagement.admins.find(obj => {
          return obj.user.id == id;
        });
        break;

      case "Staff":
        all_user_data = state.userManagement.staffs.find(obj => {
          return obj.user.id == id;
        });
        break;

      case "Student":
        all_user_data = state.userManagement.students.find(obj => {
          return obj.user.id == id;
        });

        break;

      case "Parent":
        all_user_data = state.userManagement.parents.find(obj => {
          return obj.user.id == id;
        });
        break;

      case "Role":
        all_user_data = state.userManagement.roles.find(obj => {
          return obj.id == id;
        });
        break;

      default:
        break;
    }

    console.log("found " + role + "  " + all_user_data)

    return all_user_data;

  },

  mergeByProperty: function (target, source, prop) {
    source.forEach(sourceElement => {
      let targetElement = target.find(targetElement => {
        return sourceElement[prop] === targetElement[prop];
      });
      targetElement ? Object.assign(targetElement, sourceElement) : target.push(sourceElement);
    })
  },

  removeObjectByProperty: function (target, id, prop) {
    const i = target.findIndex(_item => _item[prop] === id);

    if (i > -1) {
      target.splice(i, 1)
    } else {
      throw "Object with " + prop + " not found in array"
    }
  },

  getBaseParentProfile() {
    return {
      staff_id: "",
      father_full_name: "",
      mother_full_name: "",
      father_qualification: "",
      mother_qualification: "",
      father_contact_number: "",
      mother_contact_number: "",
      father_profession: "",
      mother_profession: "",
      father_designation: "",
      mother_designation: "",
      father_net_annual_income: "",
      mother_net_annual_income: "",
      father_pan: "",
      mother_pan: "",
      is_father_alumni: false,
      is_mother_alumni: false,
      father_joining_year: "",
      mother_joining_year: "",
      father_leaving_year: "",
      mother_leaving_year: "",
    }
  },

  cloneObject(source) {
    return JSON.parse(JSON.stringify(source));
  },


  upsertSort(source, newItem, prop = "user_id") {
    const i = source.findIndex(_item => _item[prop] === newItem[prop]);
    if (i > -1) {
      for (const property of Object.keys(newItem)) {
        source[i][property] = newItem[property]
      }
    } else {
      source.push(newItem);
    }
  },

  compare(prop = "user_id") {
    return function (a, b) {
      if (a[prop] < b[prop]) {
        return -1;
      }
      if (a[prop] > b[prop]) {
        return 1;
      }
      return 0;
    }
  },


  filterNavMenuItems(menu, permissions) {

    return menu.filter((menuItem) => {
      if (menuItem.url) {
        switch (menuItem.name) {
          case "Register Admin":
            return permissions.includes(constants.PERMISSIONS.REGISTER_ADMIN)
              && permissions.includes(constants.PERMISSIONS.VIEW_ALL_ROLES);

          case "Register Staff":
            return permissions.includes(constants.PERMISSIONS.REGISTER_STAFF)
              && permissions.includes(constants.PERMISSIONS.VIEW_ALL_ROLES);

          case "Register Student":
            return permissions.includes(constants.PERMISSIONS.REGISTER_STUDENT)
              && permissions.includes(constants.PERMISSIONS.REGISTER_PARENT);

          case "View Admins":
            return permissions.includes(constants.PERMISSIONS.VIEW_ALL_ADMINS);

          case "View Staff":
            return permissions.includes(constants.PERMISSIONS.VIEW_ALL_STAFF);

          case "View Students":
            return permissions.includes(constants.PERMISSIONS.VIEW_ALL_STUDENTS);

          case "View Parents":
            return permissions.includes(constants.PERMISSIONS.VIEW_ALL_PARENTS);

          case "Create Role":
            return permissions.includes(constants.PERMISSIONS.EDIT_ALL_ROLES)
              && permissions.includes(constants.PERMISSIONS.VIEW_ALL_PERMISSIONS);

          case "View Roles":
            return permissions.includes(constants.PERMISSIONS.VIEW_ALL_ROLES);

          case "View Permissions":
            return permissions.includes(constants.PERMISSIONS.VIEW_ALL_PERMISSIONS);

          default:
            return false;
        }
      } else if (menuItem.submenu) {
        return (menuItem.submenu = this.filterNavMenuItems(menuItem.submenu, permissions)).length
      } else {
        return true;
      }

    });
  },


  isOwnResource(id) {
    return id == state.AppActiveUser.id;
  },

  hasAccess(name, id) {
    console.log(state.AppActiveUser)
    // console.log("checking access to " + name + " with id " + id + " for " + state.AppActiveUser.name);
    switch (name) {

      case "dashboard-sms":
        return true;

      case "sms-user-profile":
        if (this.isOwnResource(id)) {
          return true;
        } else {
          return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_USERS);

        }

      case "sms-user-profile-edit":
        if (this.isOwnResource(id)) {
          return true;
        } else {
          return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.EDIT_ALL_USERS)
        }

      case "sms-register-admin":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.REGISTER_ADMIN);

      case "sms-register-student":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.REGISTER_STUDENT);

      case "sms-register-staff":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.REGISTER_STAFF);

      case "sms-view-admins":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_ADMINS);

      case "sms-view-parents":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_PARENTS);

      case "sms-view-staff":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_STAFF);

      case "sms-view-students":
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_STUDENTS);

      case 'sms-role-create':
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.EDIT_ALL_ROLES);

      case 'sms-role-list':
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_ROLES);

      case 'sms-perm-list':
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_PERMISSIONS);

      case 'sms-role-specific-view':
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.VIEW_ALL_ROLES);

      case 'sms-edit-role':
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.EDIT_ALL_ROLES);

      case 'sms-delete-role':
        return state.AppActiveUser.all_permissions.some(perm => perm.name === constants.PERMISSIONS.DELETE_ALL_ROLES);

      default:
        return false;
    }
  }


}
