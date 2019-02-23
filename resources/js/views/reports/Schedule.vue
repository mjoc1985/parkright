<template>
    <main class="flex w-full">
        <nav class=" lg:block lg:w-1/6 mr-8">
            <ul class="list-reset mb-8">
                <div class="text-primary-black pb-3 font-bold uppercase">Reports</div>
                <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
                <li>
                    <router-link :to="{path: '/reports/schedule'}" class="py-2"><i class="fas fa-calendar-day mr-2"></i>Daily
                        Schedule
                    </router-link>
                </li>

            </ul>
        </nav>
        <div class="flex-1">
            <div class="card ">
                <div class="card-header flex">
                    <h1>Schedules</h1>
                </div>
                <div class="card-body clearfix">
                    <div class="w-full clearfix my-2">
                        <div class="w-1/3 p-4 pl-10 float-left">
                            <h3 class="text-primary-black">Generate List</h3>
                        </div>
                        <div class="w-2/3 p-4 text-primary-black float-left">
                            <div class="w-full">
                                <div class="font-semibold pr-2 clearfix">
                                    <div class="w-3/4 float-left pr-2">
                                        <label>Select Date</label>
                                        <date-picker :config="config" class="form-input" v-model="date"></date-picker>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div> <!-- end card body -->

                <div class="card-footer">
                    <button @click.prevent="preview" class="btn btn-primary">Preview</button>

                </div>
            </div>


        </div>
    </main>
</template>
<script>
    export default {

        data() {
            return {
                date: '',
                config: {
                    altInput:true,
                    altFormat:'l J F, Y',
                    dateFormat: 'd-m-Y'
                }
            }
        },
        created() {

        },
        methods: {
            preview(){
                axios.get('/reports/schedule/preview' + '?date=' + this.date)
                    .then(response => {
                        
                    })
            }
        }
    }
</script>