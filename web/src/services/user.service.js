import axios from 'axios'
const API_URL = process.env.VUE_APP_ROOT_API

class UserService {
  async updateProfile(data) {
    return await axios.post(API_URL + 'updateprofile', data)
  }
}

export default new UserService()
