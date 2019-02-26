<template>
    <main v-if="agent" class="flex w-full">
        <nav class=" lg:block lg:w-1/6 mr-8">
            <ul class="list-reset mb-8">
                <div class="text-primary-black pb-3 font-bold uppercase">Product</div>
                <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
                <li>
                    <router-link :to="{name: 'agents-edit', params:{id:agent.id}}" class="py-2"><i
                            class="fas fa-wrench mr-2"></i>Setup
                    </router-link>
                </li>
                <li>
                    <router-link :to="{name: 'agents-products-index', params:{id:agent.id}}" class="py-2"><i
                            class="fas fa-car mr-2"></i>Products
                    </router-link>
                </li>

            </ul>
        </nav>
        <div class="flex-1">
            <div class="card ">
                <div class="card-header flex">
                    <h1>{{agent.name}} - Create product</h1>
                </div>
                <div class="card-body clearfix">
                    <div class="w-full clearfix my-2">
                        <div class="w-1/3 p-4 pl-10 float-left">
                            <h3 class="text-primary-black">Product Setup</h3>
                        </div>
                        <div class="w-2/3 p-4 text-primary-black float-left">
                            <div class="w-full flex justify-between">
                                <div class="font-semibold w-full">
                                    <label>Name</label>
                                    <input v-model="product.name" type="text" placeholder="Product name"
                                           class="form-input">
                                </div>
                            </div>
                            <div class="w-full flex justify-between mt-4">
                                <div class="font-semibold w-full">
                                    <label>Linked Product</label>
                                    <div class="relative">
                                    <select v-model="product.product_id" class="form-input">
                                        <option v-for="prod in products" :value="prod.id">{{prod.name}}</option>
                                    </select>
                                        <div class="form-select-caret"><i class="fas fa-caret-down"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between mt-4">
                                <div class="font-semibold w-full">
                                    <label>Agent Product Code/Id</label>
                                    <input v-model="product.agent_code" type="text" placeholder="Product code"
                                           class="form-input">
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
                agent: null,
                product: {
                    name: null,
                    agent_code: null,
                    agent_id: null,
                    product_id: 1
                },
               
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            fetch() {
                axios.all([
                    axios.get('agents/' + this.$route.params.id + '/edit'),
                    axios.get('products')
                ])
                    .then(axios.spread(function (agentRepsonse, productResponse) {
                        this.products = productResponse.data;
                        this.agent = agentRepsonse.data;
                        this.product.agent_id = this.agent.id;
                    }.bind(this)))
                    
            },
            save() {
                axios.post('agents/products/store', this.$data.product)
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