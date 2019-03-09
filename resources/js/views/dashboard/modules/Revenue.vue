<template>
    <div class="card w-full">
        <div class="card-header sm:p-4">
            <h1>Revenue</h1>
            <i class="fas fa-chart-line text-2xl text-grey-dark"></i>

        </div>
        <div class="card-body p-4">
            <template v-if="revenue">
                <div class="w-full flex justify-between mb-4">
                    <div class="items-center flex flex-1">
                        <span class="font-semibold mr-2 text-primary-black">Total</span>
                        <span class="text-primary-dark text-2xl mr-4">£{{ revenue.total }}</span>
                        <span class="text-sm text-primary">(Includes forward revenue)</span>
                    </div>
                </div>
                <div class="w-full flex justify-between text-center">
                    <div>
                        <span class="block font-semibold text-primary-dark">This Week</span>
                        <span class="block text-primary">£{{ revenue.week }}</span>
                    </div>
                    <div class="grid">
                        <span class="block font-semibold text-primary-dark">This Month</span>
                        <span class="block text-primary">£{{ revenue.month }}</span>
                    </div>
                    <div class="grid">
                        <span class="block font-semibold text-primary-dark">This Year</span>
                        <span class="block text-primary">£{{ revenue.year }}</span>
                    </div>
                </div>
            </template>
        </div>
    </div>

</template>
<script>
    export default {
        data() {
            return {
                revenue: null
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get('/dashboard/revenue')
                    .then(response => {
                        this.revenue = response.data;
                    })
            }
        }
    }

</script>