import axios from 'axios'
const API_URL = process.env.VUE_APP_ROOT_API

class BookingService {
  async createOTP(data) {
    return await axios.post(API_URL + '/createotp', data)
  }
  async checkPhone(data) {
    return await axios.post(API_URL + 'checkphone', data)
  }
  async createBooking(data) {
    return await axios.post(API_URL + 'booking', data)
  }

  async confirmOTP(data) {
    return await axios.post(API_URL + 'confirmotp', data)
  }

  async checkid(data) {
    return await axios.post(API_URL + 'checkidcard', data)
  }
  async updateid(data) {
    return await axios.post(API_URL + 'updateidcard', data)
  }

  async checkemail(data) {
    return await axios.post(API_URL + 'checkemail', data)
  }
  async updateemail(data) {
    return await axios.post(API_URL + 'updateemail', data)
  }

  async loginbyOTP(data) {
    return await axios.post(API_URL + 'loginbyotp', data)
  }

  async bookingDetail(data) {
    return await axios.get(API_URL + 'booking/' + data)
  }

  async searchBooking(data) {
    return await axios.get(API_URL + 'bookingdetail/' + data)
  }

  async stats() {
    return await axios.get(API_URL + 'stats')
  }
}

export default new BookingService()
