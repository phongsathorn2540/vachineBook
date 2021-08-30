<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <div class="card mt-5" style="max-width:450px">
          <div class="card-body">
            <div class="row">
              <div class="col-4">
                <button type="button" class="btn btn-dark btn-sm mb-4" data-bs-toggle="modal" data-bs-target="#updateProfile">อัพเดทโปรไฟล์</button>
              </div>
              <div class="col-4">
                <button type="button" class="btn btn-dark btn-sm mb-4" v-on:click="updateIdCard">อัพเดทหมายเลข 13 หลัก</button>
              </div>
              <div class="col-4">
                <button type="button" class="btn btn-dark btn-sm mb-4" v-on:click="updateEmail">อัพเดทอีเมล</button>
              </div>
            </div>
            <div class="row" v-if="dataReady">
              <div class="col-12">คุณ {{ data.profile.name + ' ' + data.profile.lastname }}</div>
              <div class="col-12 mt-2">เบอร์ {{ data.profile.phone }}</div>
              <div class="col-12 mt-2">Email {{ data.profile.email }}</div>
              <div class="col-12 mt-2">วันเกิด {{ data.profile.birthday }}</div>
              <div class="col-12 mt-2">เลข 13 หลัก {{ data.profile.id_card }}</div>
              <div class="col-12"><hr /></div>
              <div class="col-6 mt-2"><button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#BookingVachine">จองคิวฉีดวัคซีน</button></div>
              <div class="col-6 mt-2"><button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#BookingDetail">ดูรายละเอียดการจอง</button></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="BookingVachine" tabindex="-1" aria-labelledby="BookingVachineLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="BookingVachineLabel">จองวัคซีน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <Form @submit="booking">
          <div class="modal-body">เลือกวัน <Field name="booking_date" type="date" class="form-control" /></div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">จอง</button>
          </div>
        </Form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="BookingDetail" tabindex="-1" aria-labelledby="BookingDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="BookingVachineLabel">รายละเอียดการจองวัคซีน</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-4">
              หมายเลขจอง
            </div>
            <div class="col-4">
              วันที่
            </div>
            <div class="col-4">
              สถานะ
            </div>
          </div>
          <div class="row" v-for="bookingDetail of data.booking" :key="bookingDetail">
            <div class="col-4">
              {{ bookingDetail.id }}
            </div>
            <div class="col-4">
              {{ bookingDetail.booking_date }}
            </div>
            <div class="col-4">
              {{ bookingDetail.booking_status }}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="updateProfile" tabindex="-1" aria-labelledby="updateProfileLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateProfileLabel">อัพเดทโปรไฟล์</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <Form @submit="updateProfile">
          <div class="modal-body">
            <div class="mb-3">
              <label for="name" class="form-label">ชื่อ</label>
              <Field type="text" class="form-control" name="name" placeholder="กรอกชื่อของท่าน" required />
            </div>
            <div class="mb-3">
              <label for="lastname" class="form-label">นามสกุล</label>
              <Field type="text" class="form-control" name="lastname" placeholder="กรอกนามสกุลของท่าน" required />
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">วันเกิด</label>
              <Field type="date" class="form-control" name="birthday" required />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">บันทึก</button>
          </div>
        </Form>
      </div>
    </div>
  </div>
</template>

<script>
import { Form, Field } from 'vee-validate'
import Swal from 'sweetalert2'
import bookingService from '../services/booking.service'
import userService from '../services/user.service'
export default {
  components: {
    Form,
    Field
  },
  data() {
    return {
      dataReady: false,
      data: {}
    }
  },
  async created() {
    const phone = JSON.parse(localStorage.getItem('Phone'))
    if (!phone) {
      this.$router.push('/')
    } else {
      console.log(phone.phone)
      const bookingDetail = await bookingService.bookingDetail(phone.phone)
      if (bookingDetail.data.status != null) {
        console.log(bookingDetail.data.message.profile)
        this.data = bookingDetail.data.message
        this.dataReady = true
      }
    }
  },
  methods: {
    async booking(data) {
      console.log('booking')
      const phone = JSON.parse(localStorage.getItem('Phone'))
      const booking = {
        phone: phone.phone,
        booking_date: data.booking_date
      }
      const createBooking = await bookingService.createBooking(booking)
      if (createBooking.data.status === 'Success') {
        Swal.fire({
          title: 'Success!',
          text: createBooking.data.message,
          icon: 'success',
          confirmButtonText: 'Cool'
        })
      } else {
        Swal.fire({
          title: 'Fail!',
          text: createBooking.data.message,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      }
    },
    async updateEmail() {
      const { value: email } = await Swal.fire({
        title: 'UPDATE EMAIL',
        input: 'text',
        inputLabel: 'กรอก EMAIL',
        inputPlaceholder: 'EMAIL'
      })
      if (email) {
        const data = {
          email: email
        }
        const checkemail = await bookingService.checkemail(data)
        if (checkemail.data.status === 'Success') {
          const phone = JSON.parse(localStorage.getItem('Phone'))
          const dataUpdate = {
            phone: phone.phone,
            email: email
          }
          const update = await bookingService.updateemail(dataUpdate)
          if (update.data.status === 'Success') {
            Swal.fire({
              title: 'OK!',
              text: update.data.message,
              icon: 'success',
              confirmButtonText: 'OK'
            })
          }
        } else {
          Swal.fire({
            title: 'ERROR!',
            text: checkemail.data.message,
            icon: 'error',
            confirmButtonText: 'OK'
          })
        }
      }
    },
    async updateIdCard() {
      const { value: idcard } = await Swal.fire({
        title: 'UPDATE ID CARD',
        input: 'text',
        inputLabel: 'กรอกหมายเลข 13 หลัก',
        inputPlaceholder: 'ID CARD NUMBER'
      })
      if (idcard) {
        console.log('check id card')
        const data = {
          id_card: idcard
        }
        const checkid = await bookingService.checkid(data)
        if (checkid.data.status === 'Success') {
          const phone = JSON.parse(localStorage.getItem('Phone'))
          const dataUpdate = {
            phone: phone.phone,
            id_card: idcard
          }
          const update = await bookingService.updateid(dataUpdate)
          if (update.data.status === 'Success') {
            Swal.fire({
              title: 'OK!',
              text: update.data.message,
              icon: 'success',
              confirmButtonText: 'OK'
            })
          }
        } else {
          Swal.fire({
            title: 'ERROR!',
            text: checkid.data.message,
            icon: 'error',
            confirmButtonText: 'OK'
          })
        }
      }
    },
    async updateProfile(data) {
      const phone = JSON.parse(localStorage.getItem('Phone'))
      const profile = {
        phone: phone.phone,
        name: data.name,
        lastname: data.lastname,
        email: data.email,
        id_card: data.id_card,
        birthday: data.birthday
      }
      const updateProfile = await userService.updateProfile(profile)
      if (updateProfile.data.status === 'Success') {
        Swal.fire({
          title: 'Success!',
          text: updateProfile.data.message,
          icon: 'success',
          confirmButtonText: 'Cool'
        })
      } else {
        Swal.fire({
          title: 'Fail!',
          text: updateProfile.data.message,
          icon: 'error',
          confirmButtonText: 'Cool'
        })
      }
    }
  }
}
</script>
