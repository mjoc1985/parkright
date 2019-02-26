<template>
    <modal name="booking-import-modal" width="800px" height="auto" @before-open="fetchAgents">
        <div class="card">
            <form>
                <div class="card-header">
                    <h1>Import Bookings</h1>
                </div>
                <div class="card-body">
                    <div class="w-full clearfix">
                        <div class="w-1/3 p-4 pl-10 float-left">
                            <div class="text-primary-black font-bold">Agent</div>
                            <p class="text-xs text-grey-darker mt-4">Each agent has a specific file format. Please
                                choose the correct one to avoid upload errors.</p>
                        </div>
                        <div class="w-2/3 p-4 text-primary-black float-left">
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
                        </div>
                    </div>
                </div>
                <div class="card-footer flex justify-between items-center">
                        <p v-if="error" class="text-red font-semibold">{{ errors.msg }}</p>
                    <p v-if="!message"></p>
                    <p v-if="message" class="text-primary-dark font-semibold"><i class="far fa-check-circle mr-2"></i>{{ this.message }}</p>
                        


                        <button id="uploadButton" @click.prevent="launchFilePicker"
                                class="btn btn-primary bg-indigo rounded hover:bg-indigo-dark h-11 text-white font-bold p-3 inline-flex items-center">
                            <!--<svg fill="#FFF" height="18" viewBox="0 0 24 24" width="18"-->
                            <!--xmlns="http://www.w3.org/2000/svg">-->
                            <!--<path d="M0 0h24v24H0z" fill="none"/>-->
                            <!--<path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>-->
                            <!--</svg>-->
                            <i class="fas fa-upload"></i>
                            <span class="ml-2">Upload File</span>
                        </button>
                        <input ref="file" class="cursor-pointer absolute block opacity-0 pin-r pin-t"
                               type="file"
                               @change="onFileChange"

                               multiple>
                    
                </div>
            </form>

        </div>
    </modal>
</template>
<script>
    export default {
        data() {
            return {
                agents: null,
                upload: '',
                agent: 1,
                error: false,
                errors: [],
                message:null
            }
        },
        methods: {
            fetchAgents() {
                this.message = null;
                this.errors = [];
                this.error = false;
                
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
                let button = document.getElementById('uploadButton');
                button.innerHTML = '<i class="fas fa-sync fa-spin mr-2 "></i> Working';
                axios.post('bookings/import', this.formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(success => {
                    this.message = success.data.msg;
                    button.innerHTML = '<i class="fas fa-upload"></i>\n' +
                        '                            <span class="ml-2">Upload File</span>';
                    this.$notify({
                        type: 'success',
                        title: 'Success',
                        text: success.data.msg
                    });
                })
            }
        }
    }
</script>