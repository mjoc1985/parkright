<template>
    <div v-if="booking" class="flex-1">
        <div class="card ">
            <div class="card-header sm:p-4 flex">
                <h1>{{booking.ref}} - {{booking.booking_data.first_name}} {{booking.booking_data.last_name}}</h1>
                <span class="sm:hidden md:inline font-bold text-grey-dark">{{booking.agent.name}}</span>
                <router-link class="btn py-2 text-primary" :to="{name: 'booking-index'}">Back</router-link>
            </div>
            <div class="card-body clearfix">
                <div class="w-full border-b- border-grey-lighter\ clearfix my-2">
                    <div class="w-1/3 p-4 md:pl-10 float-left">
                        <h3 class="text-primary-dark">Product Details</h3>
                    </div>
                    <div class="w-2/3 p-4 text-primary-black float-left">
                        <div class="w-full md:flex sm:block justify-between">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Product</label>
                                <input v-model="booking.product.name" type="text" class="form-input">

                            </div>
                            <div class="font-semibold sm:w-full md:w-1/4 md:pl-2 md:pr-2">
                                <label>Price Paid</label>
                                <input v-model="booking.booking_data.price_paid" type="text" class="form-input">

                            </div>
                            <div class="font-semibold sm:w-full md:w-1/4 md:pl-2">
                                <label>Earnings</label>
                                <input type="text" class="form-input" :value="booking.booking_data.price_paid / 100 * 70">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full border-b border-grey-lighter clearfix my-2">
                    <div class="w-1/3 p-4 md:pl-10 float-left">
                        <h3 class="text-primary-dark">Customer Details</h3>
                    </div>
                    <div class="w-2/3 p-4 text-primary-black float-left">
                        <div class="w-full md:flex sm:block justify-between">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>First Name</label>
                                <input v-model="booking.booking_data.first_name" type="text" class="form-input">

                            </div>
                            <div class=" font-semibold sm:w-full md:w-1/2 md:pl-2">
                                <label>Last Name</label>
                                <input v-model="booking.booking_data.last_name" type="text" class="form-input">
                            </div>
                        </div>

                        <div class="w-full md:flex sm:block justify-between md:mt-4">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Phone</label>
                                <input v-model="booking.booking_data.phone" type="text" class="form-input">

                            </div>
                            <div class=" font-semibold sm:w-full md:w-1/2 md:pl-2">
                                <label>Mobile</label>
                                <input v-model="booking.booking_data.mobile" type="text" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="full border-b border-grey-lighter clearfix mb-2 mt-2">
                    <div class="w-1/3 p-4 md:pl-10 float-left">
                        <h3 class="text-primary-dark">Travel Details</h3>
                    </div>
                    <div class="w-2/3 p-4 text-primary-dark float-left">
                        <div class="w-full md:flex sm:block justify-between">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Arrival Date</label>
                                <input v-model="booking.booking_data.arrival_date" type="text" class="form-input">

                            </div>
                            <div class=" font-semibold sm:w-full md:w-1/2 md:pl-2">
                                <label>Arrival Time</label>
                                <input v-model="booking.booking_data.arrival_time" type="text" class="form-input">
                            </div>
                        </div>

                        <div class="w-full md:flex sm:block justify-between md:mt-4">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Return Date</label>
                                <input v-model="booking.booking_data.return_date" type="text" class="form-input">

                            </div>
                            <div class=" font-semibold sm:w-full md:w-1/2 md:pl-2">
                                <label>Return Time</label>
                                <input v-model="booking.booking_data.return_time" type="text" class="form-input">
                            </div>
                        </div>

                        <div class="w-full md:flex sm:block justify-between md:mt-4">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Outbound Flight</label>
                                <input v-model="booking.booking_data.flight_out" type="text" class="form-input">

                            </div>
                            <div class=" font-semibold sm:w-full md:w-1/2 md:pl-2">
                                <label>Return Flight</label>
                                <input v-model="booking.booking_data.flight_in" type="text" class="form-input">
                            </div>
                        </div>


                    </div>
                </div>

                <div class="full border-b border-grey-lighter clearfix mt-2">
                    <div class="w-1/3 p-4 md:pl-10 float-left">
                        <h3 class="text-primary-dark">Vehicle Details</h3>
                    </div>
                    <div class="w-2/3 p-4 text-primary-dark float-left">
                        <div class="w-full md:flex sm:block justify-between">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Vehicle </label>
                                <input v-model="booking.booking_data.vehicle" type="text" class="form-input">

                            </div>
                            <div class=" font-semibold sm:w-full md:w-1/2 md:pl-2">
                                <label>Vehicle Reg</label>
                                <input v-model="booking.booking_data.vehicle_reg" type="text" class="form-input">
                            </div>
                        </div>

                        <div class="w-full md:flex sm:block justify-between md:mt-4">
                            <div class="font-semibold sm:w-full md:w-1/2 md:pr-2">
                                <label>Vehicle Colour</label>
                                <input v-model="booking.booking_data.vehicle_colour" type="text" class="form-input">
                            </div>
                        </div>

                    </div>
                </div>


            </div> <!-- end card body -->

            <div class="card-footer">

                <button id="submit" @click.prevent="save" class=" btn btn-primary w-48">Save Booking</button>

            </div>
        </div>


    </div>
</template>
<script>
    export default {

        data() {
            return {
                booking: null
            }
        },
        created() {
            this.fetchBooking()
        },
        methods: {
            fetchBooking() {
                axios.get('bookings/' + this.$route.params.id + '/edit')
                    .then(response => {
                        this.booking = response.data;
                    })
            },
            save() {
                let saveButton = document.getElementById('submit');
                let buttonContent = saveButton.innerHTML;
                saveButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                axios.post('bookings/' + this.booking.id + '/update', this.$data.booking)
                    
                    .then(response => {
                        saveButton.innerHTML = buttonContent;
                        this.$notify({
                            //title: 'Success',
                            type: response.data.status,
                            text: response.data.msg
                        })
                    })
            }
        }
    }
</script>