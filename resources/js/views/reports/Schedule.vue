<template>
    <main class="md:flex sm:block w-full">
        <sub-nav></sub-nav>
        <div class="flex-1">
            <div class="flex-1 ">
                <div class="card mb-4 ">
                    <div class="card-header sm:p-4 flex">
                        <h1>Schedules</h1>
                    </div>
                    <div class="card-body clearfix">
                        <div class="w-full clearfix my-2">
                            <div class="w-1/3 p-4 md:pl-10 float-left">
                                <h3 class="text-primary-black">Generate List</h3>
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
                                            <label>Select Date</label>
                                            <date-picker :config="config" class="form-input"
                                                         v-model="date"></date-picker>
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
                        <button id="previewButton" @click.prevent="preview" class="btn btn-primary md:inline sm:block sm:my-2 md:w-40 sm:w-full"><i class="fas fa-eye mr-2"></i>Preview</button>

                        <button id="waiverButton" @click.prevent="waiver" class="btn btn-primary md:inline sm:block sm:my-2 md:w-40 sm:w-full"><i class="fas fa-file-download mr-2"></i>Waivers</button>

                        <button id="downloadButton" @click.prevent="download" class="btn btn-primary md:inline sm:block sm:my-2 md:w-64 sm:w-full"><i class="fas fa-download mr-2"></i>Download Schedule</button>


                    </div>
                </div>
                <preview :view-data="this.previewData"></preview>

            </div>


        </div>
    </main>
</template>
<script>
    import Preview from '../reports/Preview';
    import SubNav from '../reports/partials/SubNav';

    export default {
        components: {Preview, SubNav},
        data() {
            return {
                date: '',
                config: {
                    altInput: true,
                    altFormat: 'l J F, Y',
                    dateFormat: 'd-m-Y'
                },
                type: 'both',
                previewData: {
                    date: null,
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
                
                query.append('date', this.date);
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
                let button        = document.getElementById('downloadButton');
                let buttonContent = button.innerHTML;
                button.innerHTML  = '<i class="fa fa-spinner fa-spin"></i>';
                
                axios.get('/reports/schedule/export?' + this.buildQuery(), {responseType: 'arraybuffer'})
                    .then(response => {
                       button.innerHTML = buttonContent;
                        const blob = new Blob([response.data], {type: 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                        let link = document.createElement('a');
                        console.log(blob);
                        console.log(link);
                        console.log(link.download);
                        link.href = window.URL.createObjectURL(blob);
                        link.download = this.type + '_' + this.date + '.xls';
                        link.click();
                    })
            },
            preview() {
                let button        = document.getElementById('previewButton');
                let buttonContent = button.innerHTML;
                button.innerHTML  = '<i class="fa fa-spinner fa-spin"></i>';
                axios.get('/reports/schedule/preview?' + this.buildQuery())
                    .then(response => {
                        button.innerHTML = buttonContent;
                        this.previewData.date = this.date;
                        this.previewData.view = response.data
                    })
            }, 
            waiver(){
                let button        = document.getElementById('waiverButton');
                let buttonContent = button.innerHTML;
                button.innerHTML  = '<i class="fa fa-spinner fa-spin"></i>';
                axios.get('/reports/schedule/waivers' + '?waiverDate=' + this.date + '&type=in', {responseType: 'blob'})
                    .then(response => {
                        button.innerHTML = buttonContent;
                        const blob = new Blob([response.data], {type: 'application/pdf'});
                        let link = document.createElement('a');
                        console.log(blob);
                        console.log(link);
                        console.log(link.download);
                        link.href = window.URL.createObjectURL(blob);
                        link.download = this.date + '_waivers.pdf';
                        link.click();
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