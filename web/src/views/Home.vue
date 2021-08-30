<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <div class="card mt-5" style="max-width:400px">
          <div class="card-body">
            <div class="row">
              <div class="col-12 mb-2">
                <h1>vacineBooking</h1>
              </div>
              <Form @submit="createOTP">
                <div class="col-12 mb-2">
                  <Field name="phone" class="form-control form-control-sm" style="max-width:350px" type="text" placeholder="กรอกหมายเลขโทรศัพท์" />
                </div>
                <div class="col-5">
                  <button type="submit" class="btn btn-primary btn-dark mt-2">ลงทะเบียน</button>
                </div>
                <div class="col-5">
                  <button type="button" class="btn btn-primary btn-dark mt-2" v-on:click="login">เข้าสู่ระบบ</button>
                </div>
              </Form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { Form, Field } from 'vee-validate'
import Swal from 'sweetalert2'
import BookingService from '../services/booking.service'

export default {
  name: 'Login',
  components: {
    Form,
    Field
  },
  data() {
    return {
      loading: false,
      message: ''
    }
  },
  created() {},
  methods: {
    async login() {
      let phone = document.getElementsByName('phone')[0].value
      const data = {
        phone: phone
      }
      const response = await BookingService.checkPhone(data)
      if (response.data.status === 'Success') {
        Swal.fire({
          title: 'Error!',
          text: response.data.message,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      } else {
        const loginbyOTP = await BookingService.loginbyOTP(data)
        console.log(loginbyOTP)
        if (loginbyOTP.data.status === 'Success') {
          const { value: otp } = await Swal.fire({
            title: 'VERIFY OTP',
            input: 'text',
            inputLabel: 'ref code is ' + loginbyOTP.data.message.ref_code + 'otp number is ' + loginbyOTP.data.message.otp_num,
            inputPlaceholder: 'VERIFY OTP'
          })

          if (otp) {
            const dataConfirm = {
              phone: data,
              ref_code: loginbyOTP.data.message.ref_code,
              otp_num: otp
            }
            const comfirmOTP = await BookingService.confirmOTP(dataConfirm)
            if (comfirmOTP.data.status === 'Success') {
              localStorage.setItem('Phone', JSON.stringify(data))
              this.$router.push('/profile')
            } else {
              Swal.fire({
                title: 'Error!',
                text: 'has something worng',
                icon: 'error',
                confirmButtonText: 'Cool'
              })
            }
          }
        }
      }
    },
    async createOTP(data) {
      const response = await BookingService.checkPhone(data)
      if (response.data.status === 'Fail') {
        Swal.fire({
          title: 'Error!',
          text: response.data.message,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      }
      const createOTP = await BookingService.createOTP(data)
      if (createOTP.data.status === 'Success') {
        const { value: otp } = await Swal.fire({
          title: 'VERIFY OTP',
          input: 'text',
          inputLabel: 'ref code is ' + createOTP.data.message.ref_code + 'otp number is ' + createOTP.data.message.otp_num,
          inputPlaceholder: 'VERIFY OTP'
        })

        if (otp) {
          const dataConfirm = {
            phone: data,
            ref_code: createOTP.data.message.ref_code,
            otp_num: otp
          }
          const comfirmOTP = await BookingService.confirmOTP(dataConfirm)
          if (comfirmOTP.data.status === 'Success') {
            localStorage.setItem('Phone', JSON.stringify(data))
            this.$router.push('/profile')
          } else {
            Swal.fire({
              title: 'Error!',
              text: 'has something worng',
              icon: 'error',
              confirmButtonText: 'Cool'
            })
          }
        }
      }
    }
  }
}
</script>
<style scoped>
a {
  color: #fff;
}
</style>
