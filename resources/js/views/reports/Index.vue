<template>
    <main class="md:flex sm:block w-full">
        <nav class="md:block md:w-1/6 md:mr-8 sm:w-full">
            <ul class="list-reset mb-8">
                <div class="text-primary-black pb-3 font-bold uppercase">Reports</div>
                <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
                <li><router-link :to="{path: '/reports/schedule'}" class="py-2"><i class="fas fa-calendar-day mr-2"></i>Daily Schedule</router-link></li>

            </ul>  
        </nav>
        <div class="flex-1">
            <div class="card ">
                <div class="card-header flex">
                    <h1>Overview</h1>
                </div>
                <div class="card-body clearfix">


                </div> <!-- end card body -->

                <div class="card-footer">

                </div>
            </div>


        </div>
    </main>
</template>
<script>
    export default {

        data() {
            return {}
        },
        created() {

        },
        methods: {}
    }
</script>