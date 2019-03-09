<template>
    <div class="card">
        <div class="card-header sm:p-4">
            <h1>Booking Overview</h1>
            <i class="fas fa-calendar-alt text-2xl text-grey-dark"></i>
        </div>
        <div class="card-body p-4 ">
            <div class="flex justify-between">
                <div class="mb-4 ">
                    <div class="w-full flex">
                        <h4 class="block align-middle uppercase text-primary-black">Movements Today</h4>
                    </div>
                    <div class="text-center flex justify-between text-xl">
                        <span class="text-primary-dark">In: <span class="font-semibold text-lg ml-2">{{ overview.today.in}}</span></span>
                        <span class="text-primary-dark">Out: <span class="font-semibold text-lg ml-2">{{ overview.today.out}}</span></span>
                    </div>
                </div>
                <div class="mb-4 block text-center">
                    <h4 class="align-middle uppercase text-primary-black">Vehicles currently in</h4>
                    <span class="text-primary text-2xl">{{ overview.currentCount}}</span>
                </div>
            </div>
            <div class="flex">
                <h4 class="">Movements for the next 7 days.</h4>
            </div>
            <table class="table-auto w-full">
                <thead>
                <tr class="table-row text-center bg-grey-lighter">
                    <template v-for="(date, index) in overview.week">
                        <th class="px-4 py-2 table-cell">{{ index }}</th>
                    </template>
                </tr>
                </thead>
                <tbody>
                <tr class="table-row text-center">
                    <template v-for="date in overview.week">
                        <td class="px-4 py-2 table-cell">
                            <span class="block">In: <b>{{ date.in }}</b></span>
                            <span class="block">Out: <b>{{ date.out }}</b></span>
                        </td>
                    </template>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                overview: null,
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get('/dashboard/booking/overview')
                    .then(response => {
                        this.overview = response.data;
                    })
            }
        }
    }
</script>