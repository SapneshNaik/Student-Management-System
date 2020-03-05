import mock from "@/fake-db/mock.js"
import jwt from 'jsonwebtoken'

const data = {
  checkpointReward: {
    userName: "John",
    progress: "57.6%"
  },
  users: [
    {
      uid: 34,
      displayName: "Howard Potts",
      password: "adminadmin",
      photoURL: require("@/assets/images/portrait/small/avatar-s-5.jpg"),
      email: "admin@admin.com",
      phoneNumber: null,
    }
  ]
}


const jwtConfig = {
    "secret"   : "dd5f3089-40c3-403d-af14-d0c228b05cb4",
    "expireTime": 8000
}


mock.onPost("/api/auth/login").reply((request) => {
  const {email, password} = JSON.parse(request.data)

  let error = "Something went wrong"

  const user = data.users.find(user => user.email === email && user.password === password)

  if (user) {

    try {

      const accessToken = jwt.sign({id: user.uid}, jwtConfig.secret, {expiresIn: jwtConfig.expireTime})

      const userData = Object.assign({}, user, {providerId: "jwt"})

      delete userData.password

      const response = {
        userData : userData,
        accessToken: accessToken
      }

      return [200, response]

    } catch(e) {
      error = e
    }
  }else {
    error = "Email Or Password Invalid"
  }

  return [200, {error}]


})

mock.onPost('/api/auth/register').reply((request) => {
    const {displayName, email, password} = JSON.parse(request.data)
    const isEmailAlreadyInUse = data.users.find((user) => user.email === email)
    const error = {
      email      : isEmailAlreadyInUse ? 'This email is already in use.' : null,
      displayName: displayName === '' ? 'Please enter your name.' : null
    }

    if ( !error.displayName && !error.email ) {

      let userData = {
        email: email,
        password: password,
        displayName: displayName,
        photoURL: require("@/assets/images/portrait/small/avatar-s-5.jpg"),
        phoneNumber: null
      }

      // Add user id
      const length = data.users.length
      let lastIndex = 0
      if(length){
        lastIndex = data.users[length - 1].uid
      }
      userData.uid = lastIndex + 1

      data.users.push(userData)

      const accessToken = jwt.sign({id: userData.uid}, jwtConfig.secret, {expiresIn: jwtConfig.expireTime})

      let user = Object.assign({}, userData)
      delete user['password']
      const response = { userData: user, accessToken: accessToken }

      return [200, response]
    } else {
      return [200, {error}]
    }
})


mock.onPost('/api/auth/refresh-token').reply((request) => {

  const {accessToken} = JSON.parse(request.data)

  try {
    const {id} = jwt.verify(accessToken, jwtConfig.secret)

    let userData = Object.assign({}, data.users.find(user => user.uid === id))

    const newAccessToken = jwt.sign({id: userData.uid}, jwtConfig.secret, {expiresIn: jwtConfig.expiresIn});

    delete userData['password']
    const response = {
      userData: userData,
      accessToken: newAccessToken
    }

    return [200, response]
  } catch (e){
    const error = "Invalid access token"
    return [401, {error}]
  }
})


mock.onGet("/api/user/checkpoint-reward").reply(() => {
  return [200, data.checkpointReward];
});
