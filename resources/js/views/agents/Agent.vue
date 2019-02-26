<template>
    <main v-if="agent" class="flex w-full">
        <nav class=" lg:block lg:w-1/6 mr-8">
            <ul class="list-reset mb-8">
                <div class="text-primary-black pb-3 font-bold uppercase">Agent</div>
                <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
                <li>
                    <router-link :to="{name: 'agents-edit', params:{id:agent.id}}" class="py-2"><i
                            class="fas fa-wrench mr-2"></i>Setup
                    </router-link>
                </li>
                <li>
                    <router-link :to="{name: 'agents-products', params:{id:agent.id}}" class="py-2"><i
                            class="fas fa-car mr-2"></i>Products
                    </router-link>
                </li>

            </ul>
        </nav>
        <div class="flex-1">
            <div class="card ">
                <div class="card-header flex">
                    <h1>{{agent.id}} - {{agent.name}}</h1>
                    <router-link class="btn py-2 text-primary" :to="{name: 'agents-index'}">Back</router-link>
                </div>
                <div class="card-body clearfix">
                    <div class="w-full clearfix my-2">
                        <div class="w-1/3 p-4 pl-10 float-left">
                            <h3 class="text-primary-black">Agent Setup</h3>
                        </div>
                        <div class="w-2/3 p-4 text-primary-black float-left">
                            <div class="w-full flex justify-between">
                                <div class="font-semibold w-2/3 pr-2">
                                    <label>Name</label>
                                    <input v-model="agent.name" type="text" placeholder="Agent name" class="form-input">
                                </div>
                                <div class="font-semibold w-1/3 pl-2">
                                    <label>Slug</label>
                                    <input v-model="agent.slug" type="text" class="form-input">
                                </div>
                            </div>

                            <div class="w-full flex justify-between mt-4">
                                <div class="font-semibold w-2/3 pr-2">
                                    <label>Email</label>
                                    <input v-model="agent.email" type="text" placeholder="Agent name" class="form-input">
                                </div>
                                
                            </div>

                            
                        </div>

                    </div>

                </div> <!-- end card body -->

                <div class="card-footer">

                    <button @click.prevent="save" class=" btn btn-primary">Save</button>

                </div>
            </div>


        </div>
    </main>
</template>
<script>
    export default {

        data() {
            return {
                agent: null
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            fetch() {
                axios.get('agents/' + this.$route.params.id + '/edit')
                    .then(response => {
                        this.agent = response.data;
                    })
            },
            save() {
                axios.post('agents/' + this.agent.id + '/update', this.$data.agent)
                    .then(response => {
                        this.$notify({
                            type: 'success',
                            title: 'Success',
                            text: response.data.msg
                        })
                    })
            }
        }
    }
</script>