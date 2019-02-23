<template>
    <form>
        <label class="mr-2 text-grey-darker" for="">Upload bookings</label>
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
        <p v-if="error" class="text-pr-red font-semibold">{{ errors.msg }}</p>

    </form>
</template>
<script>
    export default {
        data() {
            return {
                upload: '',
                agent:1,
                error:false,
                errors:[],
            }
        },
        methods: {
            launchFilePicker() {
                this.$refs.file.click();
            },
            onFileChange(e) {
                if (!e.target.files.length) return;
                this.processFile();
            },
            processFile(){
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