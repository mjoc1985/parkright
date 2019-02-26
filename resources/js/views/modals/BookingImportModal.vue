<template>
    <modal name="booking-import-modal" width="800px" height="auto" @before-open="fetchAgents">
        <div class="card">
            <div class="card-header">
                <h1>Import Bookings</h1>
            </div>
            <div class="card-body">
                <div class="w-full border-b border-grey-lighter clearfix my-2">
                    <div class="w-1/3 p-4 pl-10 float-left">
                        <div class="text-primary-black font-bold">Agent</div>
                        <p class="text-xs text-grey-darker mt-4">Each agent has a specific file format. Please choose the correct one to avoid upload errors.</p>
                    </div>
                    <div class="w-2/3 p-4 text-primary-black float-left">
                        <form>
                            <div class="font-semibold">
                                <div class="relative">
                                <select class="form-input" v-model="agent">
                                    <option v-for="agent in agents" :value="agent.id">{{agent.name}}</option>
                                </select>
                                    <div class="form-select-caret">
                                        <i class="fas fa-caret-down"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-8 text-right">
                                <p v-if="error" class="text-pr-red font-semibold">{{ errors.msg }}</p>

                                <button @click.prevent="launchFilePicker"
                                    class="btn bg-indigo rounded hover:bg-indigo-dark h-11 text-white font-bold p-3 inline-flex items-center">
                                <svg fill="#FFF" height="18" viewBox="0 0 24 24" width="18"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                                </svg>
                                <span class="ml-2">Upload File</span>
                            </button>
                            <input ref="file" class="cursor-pointer absolute block opacity-0 pin-r pin-t"
                                   type="file"
                                   @change="onFileChange"

                                   multiple>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</template>
<script>
    export default {
        data() {
            return {
                agents:null,
                upload: '',
                agent: 1,
                error: false,
                errors: [],
            }
        },
        methods: {
            fetchAgents(){
                axios.get('/agents')
                    .then(response => {
                        this.agents = response.data;
                    })
            },
            launchFilePicker() {
                this.$refs.file.click();
            },
            onFileChange(e) {
                if (!e.target.files.length) return;
                this.processFile();
            },
            processFile() {
                this.formData = new FormData();
                this.formData.append('file', this.$refs.file.files[0]);
                this.formData.append('agent', this.agent);
                console.log(this.formData);
                axios.post('bookings/import', this.formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (success) {
                    // this.form.price_list = success.data.prices;
                    // this.form.filename = success.data.filename;
                    // this.days = this.form.price_list.length
                }.bind(this))
            }
        }
    }
</script>