<template>
    <div class="flex-1">
        <div class="card">
            <div class="card-header sm:p-4">
                <h1>Bookings</h1>
                <search-bookings @bookings="updateBookings"></search-bookings>
                <template>
                <import-button class="sm:hidden md:inline"></import-button>
                </template>
            </div>
            <div class="card-body p-0">
                <div>
                    <table class="table w-full">
                        <thead class="text-grey-darkest text-base bg-grey-lightest">
                        <tr>
                            <th class="md:pl-10"># Ref</th>
                            <th class="md:px-2 md:pl-10 text-left">Cust<span class="sm:hidden md:inline">omer</span></th>
                            <th class="px-2">Arr<span class="sm:hidden md:inline">iving</span></th>
                            <th class="px-2">Depart<span class="sm:hidden md:inline">ing</span></th>
                            <th class="px-2">Veh<span class="sm:hidden md:inline">icle</span></th>
                            <th class="px-2 sm:hidden md:block">Agent/Product</th>
                            <th class="pr-10">&nbsp</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr class="md:text-sm border-b border-grey-lighter sm:text-xs " v-for="booking in bookings">
                            <td class="md:py-4 md:pl-10 text-primary-black text-center font-semibold w-32">
                                {{booking.ref}}
                                <span v-if="booking.status === 'booked'" class="py-1 px-2 font-bold rounded text-center text-xs text-green uppercase bg-green-lightest">{{booking.status}}</span>
                                <span v-else-if="booking.status != 'booked'" class="py-1 px-2 font-bold rounded text-center text-xs text-red uppercase bg-red-lightest">{{booking.status}}</span>
                            </td>
                            <td class="md:py-4 md:pl-10 md:px-2 w-40">
                                <span class="font-semibold text-primary-black">{{booking.booking_data.first_name}} {{booking.booking_data.last_name}}</span>
                                <span class="block text-xs">{{booking.booking_data.mobile}}</span>
                            </td>
                            <td class="md:py-4 px-2 text-center w-32">
                                <span class="block">{{booking.booking_data.arrival_date}}</span>
                                <span class="block">{{booking.booking_data.arrival_time}}</span>

                            </td>
                            <td class="md:py-4 px-2 text-center w-32">
                                <span class="block">{{booking.booking_data.return_date}}</span>
                                <span class="block">{{booking.booking_data.return_time}}</span>

                            </td>
                            <td class="md:py-4 px-2 text-center w-40">
                                <span class="block font-semibold">{{booking.booking_data.vehicle_reg}}</span>

                                <span class="block text-xs">{{booking.booking_data.vehicle_colour}} {{booking.booking_data.vehicle}}</span>

                            </td>
                            <td class="md:py-4 md:table-cell sm:hidden px-2 w-48 font-semibold text-primary-black text-center">
                                {{booking.agent.name}}
                                <span class="block text-xs text-center text-primary">{{booking.product.name}}</span>
                            </td>


                            <td class="md:py-4">
                                <router-link :to="{name: 'booking-edit', params:{id:booking.id}}"
                                             class="btn btn-sm text-primary"><i class="fas fa-edit sm:inline md:hidden"></i>
                                    <span class="sm:hidden md:inline">Manage</span></router-link>
                                <!--<button @click.prevent class="btn btn-sm text-primary">Manage</button>-->
                                <!--<button class="btn btn-sm text-primary-dark">Waiver</button>button-->

                                <!--<button class="btn btn-sm text-red">Cancel</button>-->

                            </td>
                            
                        </tr>

                        </tbody>
                    </table>
                    <div v-if="bookings == null" class="w-full p-8 text-center text-primary">There are no bookings to
                        show.
                    </div>

                </div>
            </div>
            <div class="card-footer p-4 flex font-semibold">
                <div class="flex flex-1">
                    <a class="mr-2 text-primary" v-if="page.previous" href="#"
                       @click.prevent="changePage(page.previous)">Previous</a>
                    <a class="mr-2 text-primary" v-if="page.next" href="#" @click.prevent="changePage(page.next)">Next</a>

                </div>
                <div class="flex text-primary-dark">
                    <span>Page: {{page.current}} of {{page.count}}</span>
                </div>
            </div>
        </div>


    </div>
</template>
<script>
    import ImportButton from '../bookings/partials/ImportBookings';
    import SearchBookings from '../bookings/partials/SearchBookings'

    export default {
        components: {ImportButton, SearchBookings},
        data() {
            return {
                page: {
                    current: null,
                    next: null,
                    previous: null,
                    last: null,
                    first: null,
                    count: null
                },
                bookings: null,
            }
        },
        mounted() {
            this.fetchBookings();
        },
        methods: {
            fetchBookings() {
                axios.get('bookings')
                    .then(response => {
                        let bookingCollection = response.data.bookings.data;

                        if (bookingCollection.length > 0) {
                            this.bookings = response.data.bookings.data;
                            this.setPages(response.data.bookings);

                        }
                    });
            },
            updateBookings(data) {

                this.bookings = data.data;
                this.setPages(data);


            },
            changePage(page) {
                axios.get(page)
                    .then(response => {
                        this.bookings = response.data.bookings.data;
                        this.setPages(response.data.bookings);

                    })
            },
            setPages(data) {
                this.page.current = data.current_page;
                this.page.next = data.next_page_url;
                this.page.previous = data.prev_page_url;
                this.page.last = data.last_page_url;
                this.page.first = data.first_page_url;
                this.page.count = data.last_page;


            }
        }
    }
</script>