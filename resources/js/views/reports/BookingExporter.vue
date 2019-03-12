<template>
    <main class="md:flex sm:block w-full">
            <sub-nav></sub-nav>
        <div class="flex-1">
            <div class="flex-1 ">
                <div class="card mb-4 ">
                    <div class="card-header sm:p-4 flex">
                        <h1>Bookings Report</h1>
                    </div>
                    <div class="card-body clearfix">
                        <div class="w-full clearfix my-2">
                            <div class="w-1/3 p-4 md:pl-10 float-left">
                                <h3 class="text-primary-black">Export Bookings</h3>
                            </div>
                            <div class="w-2/3 p-4 text-primary-black float-left">
                                <template v-if="filterOptions">
                                    <div class="w-full">
                                        <div class="font-semibold clearfix">
                                            <div class="md:w-3/4 float-left md:pr-2 sm:w-full ">
                                                <label>Agent</label>
                                                <div class="relative">
                                                    <select v-model="filter.agent" class="form-input">
                                                        <option value="">All</option>
                                                        <option v-for="agent in filterOptions.agents" :value="agent.slug">{{ agent.name }}</option>
                                                    </select>
                                                    <div class="form-select-caret"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="font-semibold clearfix">
                                            <div class="md:w-3/4 float-left md:pr-2 sm:w-full ">
                                                <label>Product</label>
                                                <div class="relative">
                                                    <select v-model="filter.product" class="form-input">
                                                        <option value="">All</option>
                                                        <option v-for="product in filterOptions.products" :value="product.id">{{ product.name }}</option>
                                                    </select>
                                                    <div class="form-select-caret"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="font-semibold clearfix">
                                            <div class="md:w-3/4 float-left md:pr-2 sm:w-full ">
                                                <label>Service Type</label>
                                                <div class="relative">
                                                    <select v-model="filter.service" class="form-input">
                                                        <option value="">All</option>
                                                        <option v-for="service in filterOptions.serviceType" :value="service">{{ service }}</option>
                                                    </select>
                                                    <div class="form-select-caret"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="w-full">
                                    <div class="font-semibold clearfix">
                                        <div class="md:w-3/4 float-left md:pr-2 sm:w-full ">
                                            <label>Select Start Date</label>
                                            <date-picker :config="config" class="form-input"
                                                         v-model="dateFrom"></date-picker>
                                        </div>
                                    </div>
                                    <div class="font-semibold clearfix">
                                        <div class="md:w-3/4 float-left md:pr-2 sm:w-full ">
                                            <label>Select End Date</label>
                                            <date-picker :config="config" class="form-input"
                                                         v-model="dateTo"></date-picker>
                                        </div>
                                    </div>
                                    <div class="font-semibold clearfix">
                                        <div class="md:w-3/4 float-left md:pr-2 sm:w-full ">
                                            <label>Report Type</label>
                                            <div class="relative">
                                                <select class="form-input" name="type" v-model="type">
                                                    <option value="in">Incoming</option>
                                                    <option value="out">Outgoing</option>
                                                    <option value="both">Incoming & Outgoing</option>
                                                </select>
                                                <div class="form-select-caret"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div> <!-- end card body -->

                    <div class="card-footer sm:block">
                        <button @click.prevent="preview" class="btn btn-primary md:inline sm:block sm:my-2 md:w-auto sm:w-full"><i class="fas fa-eye mr-2"></i>Preview</button>

                        <!--<button @click.prevent="waiver" class="btn btn-primary md:inline sm:block sm:my-2 md:w-auto sm:w-full"><i class="fas fa-file-download mr-2"></i>Waivers</button>-->

                        <button @click.prevent="download" class="btn btn-primary md:inline sm:block sm:my-2 md:w-auto sm:w-full"><i class="fas fa-download mr-2"></i>Download Schedule</button>


                    </div>
                </div>
                <preview :view-data="this.previewData"></preview>

            </div>


        </div>
    </main>
</template>
<script>
    import Preview from '../reports/Preview'
    import SubNav from '../../views/reports/partials/SubNav';
    export default {
        components: {Preview, SubNav},
        data() {
            return {
                dateFrom: '',
                dateTo: '',
                config: {
                    altInput: true,
                    altFormat: 'l J F, Y',
                    dateFormat: 'd-m-Y'
                },
                type: 'both',
                previewData: {
                    dateFrom: null,
                    dateTo: null,
                    view: null
                },
                filterOptions: {},
                filter:{
                    agent: '',
                    product: '',
                    service: ''
                }
            }
        },
        created() {
            this.fetch();

        },
        methods: {
            buildQuery(){
                let query = new FormData();

                query.append('dateFrom', this.dateFrom);
                query.append('dateTo', this.dateTo);

                query.append('type', this.type);

                if (this.filter.agent){
                    query.append('agent', this.filter.agent);
                }
                if (this.filter.product){
                    query.append('product', this.filter.product);
                }
                if (this.filter.service) {
                    query.append('service', this.filter.service);
                }
                return new URLSearchParams(query).toString();
            },
            download() {
                axios.get('/reports/bookings/export?' + this.buildQuery(), {responseType: 'arraybuffer'})
                    .then(response => {
                        console.log(response);
                        const blob = new Blob([response.data], {type: 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                        let link = document.createElement('a');
                        console.log(blob);
                        console.log(link);
                        console.log(link.download);
                        link.href = window.URL.createObjectURL(blob);
                        link.download = this.type + '_' + this.dateFrom + '_' + this.dateTo + '.xls';
                        link.click();
                    })
            },
            preview() {
                axios.get('/reports/bookings/preview?' + this.buildQuery())
                    .then(response => {
                        this.previewData.dateFrom = this.dateFrom;
                        this.previewData.dateTo = this.dateTo;
                        this.previewData.view = response.data
                    })
            },
            fetch(){
                axios.get('/reports/schedule/filterData')
                    .then(response => {
                        this.filterOptions = response.data;
                    })
            }
        }
    }
</script>