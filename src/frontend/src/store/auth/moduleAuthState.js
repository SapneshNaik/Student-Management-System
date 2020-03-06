export default {
    isUserLoggedIn: () => {
      if(localStorage.getItem("accessToken")) {
        return true;
      }

      return false;
    },
}
