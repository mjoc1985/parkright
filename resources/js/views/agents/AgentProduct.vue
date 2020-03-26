<template>
    <main v-if="agent" class="md:flex sm:block w-full">
        <nav class=" sm:block md:block md:w-1/6 sm:w-full mr-8">
            <ul class="list-reset md:mb-8 sm:mt-4 sm:p-4 sm:inline-flex md:block">
                <div class="text-primary-black pb-3 font-bold uppercase">Product</div>
                <li class="sm:px-4">
                    <router-link :to="{name: 'agents-edit', params:{id:agent.id}}" class="py-2"><i
                        class="fas fa-wrench mr-2"/>Setup
                    </router-link>
                </li>
                <li class="sm:px-4">
                    <router-link :to="{name: 'agents-products-index', params:{id:agent.id}}" class="py-2"><i
                        class="fas fa-car mr-2"/>Products
                    </router-link>
                </li>
            </ul>
        </nav>
        <div class="md:flex-1">
            <div class="card ">
                <div class="card-header sm:p-4 flex">
                    <h1>{{agent.name}} - Edit {{product.name}} product</h1>
                </div>
                <div class="card-body clearfix">
                    <div class="w-full clearfix my-2">
                        <div class="w-1/3 p-4 md:pl-10 float-left">
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
                product: null,
                agent: null,
                products: null
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            fetch() {
                axios.all([
                    axios.get('agents/' + this.$route.params.id + '/edit'),
                    axios.get('agents/products/' + this.$route.params.product + '/edit'),
                    axios.get('products')
                ])
                    .then(axios.spread(function (agent, product, products) {
                        this.product = product.data;
                        this.agent = agent.data;
                        this.products = products.data;
                    }.bind(this)))
            },
            save() {
                axios.patch('agents/products/' + this.product.id + '/update', this.$data.product)
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
