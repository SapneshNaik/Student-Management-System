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
  }
}
