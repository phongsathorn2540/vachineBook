<template>
  <div class="container">
    <div class="d-flex justify-content-center mt-5">
      <div class="row">
        <div class="col-4">
          <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">ยอดจองทั้งหมด</div>
            <div class="card-body">
              <h5 class="card-title">{{ stats.totalBooking }}</h5>
              <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">ยอดจองที่ยกเลิก</div>
            <div class="card-body">
              <h5 class="card-title">{{ stats.cancelBooking }}</h5>
              <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">ฉีดแล้ว</div>
            <div class="card-body">
              <h5 class="card-title">{{ stats.successBooking }}</h5>
              <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
            </div>
          </div>
        </div>

        <div class="col-12">
          <Form @submit="searchBooking">
            ค้นหาหมายเลขการจอง <Field name="booking_id" type="text" class="form-control" />
            <button type="submit" class="btn btn-success mt-2">ค้นหา</button>
          </Form>
        </div>
        <div class="col-12 mt-4" v-if="searchBookingStatus">
          <div class="row">
            <div class="col-6">
              <h2>หมายเลขการจอง {{ bookingDetail.id }}</h2>
            </div>
            <div class="col-6">
              <h2><span class="badge bg-secondary"> สถานะ </span> {{ bookingDetail.booking_status }}</h2>
            </div>
            <div class="col-12">
              <h3>
                <span class="badge rounded-pill bg-dark"> วันที่จอง {{ bookingDetail.booking_date }} </span>
              </h3>
            </div>
            <div class="col-6">ชื่อนามสกุล</div>
            <div class="col-6">{{ bookingDetail.user.name + bookingDetail.user.lastname }}</div>
            <div class="col-6">หมายเลข 13 หลัก</div>
            <div class="col-6">{{ bookingDetail.user.id_card }}</div>
            <div class="col-6">Email</div>
            <div class="col-6">{{ bookingDetail.user.email }}</div>
            <div class="col-6">เบอร์โทร</div>
            <div class="col-6">{{ bookingDetail.user.phone }}</div>
            <div class="col-6">วันเกิด</div>
            <div class="col-6">{{ bookingDetail.user.birthday }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Form, Field } from 'vee-validate'
import bookingService from '../services/booking.service'
export default {
  components: {
    Form,
    Field
  },
  data() {
    return {
      stats: {},
      bookingDetail: {},
      searchBookingStatus: false
    }
  },
  async created() {
    const stats = await bookingService.stats()
    this.stats = stats.data.message
  },
  methods: {
    async searchBooking(data) {
      console.log('searchBooking')
      const bookingDetail = await bookingService.searchBooking(data.booking_id)
      console.log(bookingDetail)
      if (bookingDetail.data.status === 'Success') {
        this.bookingDetail = bookingDetail.data.message
        this.searchBookingStatus = true
      }
    }
  }
}
</script>
