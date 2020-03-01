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

  getUserDataFromRole: function (role, id, state) {

    let all_user_data = null;
    switch (role) {

      case "Admin":
        all_user_data = state.userManagement.admins.find(obj => {
          return obj.user.id === id;
        });

        console.log("found admin" + all_user_data)
        break;

      case "Staff":
        all_user_data = state.userManagement.staffs.find(obj => {
          return obj.user.id === id;
        });
        break;

      case "Student":
        all_user_data = state.userManagement.students.find(obj => {
          return obj.user.id === id;
        });

        break;

      case "Parent":
        all_user_data = state.userManagement.parents.find(obj => {
          return obj.user.id === id;
        });
        break;

      default:
        break;
    }

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

  cleanSource(source) {
    // using native JSON functions removes reactivity
    // so we can clone an object without mutating the original source
    return JSON.parse(JSON.stringify(source));
  },

  clearLocalStorage() {
    localStorage.removeItem("accessToken");
    localStorage.removeItem('userInfo');
    localStorage.removeItem('role_data');
    localStorage.removeItem('perm_data');

    localStorage.removeItem('user_perms');
    localStorage.removeItem('user_roles');
  },

  upsertSort(source, newItem) {
    const i = source.findIndex(_item => _item.user_id === newItem.user_id);
    if (i > -1) {
      // source[i] = newItem;
      for (const property of Object.keys(newItem)) {
        source[i][property] = newItem[property]
      }
    } else {
      source.push(newItem);
    }

    source.sort(this.compare);

  },

  compare(a, b) {
    if (a.user_id < b.user_id) {
      return -1;
    }
    if (a.user_id > b.user_id) {
      return 1;
    }
    return 0;
  }


}
