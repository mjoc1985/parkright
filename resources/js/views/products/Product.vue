<template>
    <main v-if="product" class="md:flex sm:block w-full">
        <nav class=" md:block md:w-1/6 sm:w-full md:mr-8">
            <ul class="list-reset md:mb-8 sm:mt-4 sm:p-4 sm:inline-flex md:block">
                <div class="text-primary-black pb-3 font-bold uppercase">Product</div>
                <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
                <li class="sm:px-4 md:px-0">
                    <router-link :to="{name: 'product-edit', params:{id:product.id}}" class="py-2"><i
                            class="fas fa-wrench mr-2"></i>Setup
                    </router-link>
                </li>

            </ul>
        </nav>
        <div class="flex-1">
            <div class="card ">
                <div class="card-header sm:p-4 flex">
                    <h1>{{product.id}} - {{product.name}}</h1>
                    <router-link class="btn py-2 text-primary" :to="{name: 'product-index'}">Back</router-link>
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
                                <div class="font-semibold w-full ">
                                    <label>Type</label>
                                    <div class="relative">
                                        <select v-model="product.type" class="form-input">
                                            <option value="Park and Ride">Park and Ride</option>
                                            <option value="Undercover MG">Undercover M&G</option>
                                            <option value="Meet and Greet">Meet and Greet</option>
                                            <option value="Return MG">Return M&G</option>
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