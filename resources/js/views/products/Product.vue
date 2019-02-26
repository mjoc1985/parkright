<template>
    <main v-if="product" class="flex w-full">
        <nav class=" lg:block lg:w-1/6 mr-8">
            <ul class="list-reset mb-8">
                <div class="text-primary-black pb-3 font-bold uppercase">Product</div>
                <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
                <li>
                    <router-link :to="{name: 'product-edit', params:{id:product.id}}" class="py-2"><i
                            class="fas fa-wrench mr-2"></i>Setup
                    </router-link>
                </li>

            </ul>
        </nav>
        <div class="flex-1">
            <div class="card ">
                <div class="card-header flex">
                    <h1>{{product.id}} - {{product.name}}</h1>
                    <router-link class="btn py-2 text-primary" :to="{name: 'product-index'}">Back</router-link>
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
                                <div class="font-semibold w-full ">
                                    <label>Type</label>
                                    <div class="relative">
                                        <select v-model="product.type" class="form-input">
                                            <option value="Park and Ride">Park and Ride</option>
                                            <option value="Undercover M&G">Undercover M&G</option>
                                            <option value="Meet and Greet">Meet and Greet</option>
                                            <option value="Return M&G">Return M&G</option>
                                        </select>
                                        <div class="form-select-caret">
                                            <i class="fas fa-caret-down"></i>
                                        </div>
                                    </div>
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
                product: null
            }
        },
        created() {
            this.fetch()
        },
        methods: {
            fetch() {
                axios.get('products/' + this.$route.params.id + '/edit')
                    .then(response => {
                        this.product = response.data;
                    })
            },
            save() {
                axios.post('products/' + this.product.id + '/update', this.$data.product)
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