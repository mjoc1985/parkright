<template>

    <div class="flex-1">
        <div class="card">
            <div class="card-header sm:p-4">
                <h1>Products</h1>
            </div>
            <div class="card-body p-0">
                <div>
                    <table class="table w-full">
                        <thead class="text-grey-darkest text-base bg-grey-lightest">
                        <tr>
                            <th class="pl-10">#</th>
                            <th class="px-2 pl-10 text-left">Product Name</th>
                            <th class="px-2 text-left">Type</th>
                            <th class="pr-10">&nbsp</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr class="text-sm border-b border-grey-lighter" v-for="product in products">
                            <td class="py-4 pl-10 text-primary-black text-center font-semibold">
                                {{product.id}}
                            </td>
                            <td class="py-4 pl-10 px-2">
                                <span class="font-semibold text-primary-black">{{product.name}}</span>
                            </td>
                            
                            <td class="py-4 px-2">
                                <span class="block">{{product.type}}</span>
                            </td>

                            <td class="py-4">
                                <router-link :to="{name: 'product-edit', params:{id:product.id}}"
                                             class="btn btn-sm text-primary"><i class="fas fa-edit sm:inline md:hidden"></i>
                                    <span class="sm:hidden md:inline">Manage</span>
                                </router-link>
                                <!--<button @click.prevent class="btn btn-sm text-primary">Manage</button>-->
                                <!--<button class="btn btn-sm text-primary-dark">Waiver</button>button-->

                                <!--<button class="btn btn-sm text-red">Cancel</button>-->

                            </td>

                        </tr>

                        </tbody>
                    </table>
                    <div v-if="products == null" class="w-full p-8 text-center text-primary">There are no agents to
                        show.
                    </div>

                </div>
            </div>
            <div class="card-footer p-4 flex font-semibold">

            </div>
        </div>


    </div>
</template>
<script>

    export default {

        data() {
            return {
                page: {
                    current: null,
                    next: null,
                    previous: null,
                    last: null,
                    first: null,
                    count: null
                },
                products: null,
            }
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get('products')
                    .then(response => {
                        this.products = response.data;
                    });
            },
            
            changePage(page) {
                axios.get(page)
                    .then(response => {
                        // this.bookings = response.data.bookings.data;
                        // this.setPages(response.data.bookings);

                    })
            },
            setPages(data) {
                this.page.current = data.current_page;
                this.page.next = data.next_page_url;
                this.page.previous = data.prev_page_url;
                this.page.last = data.last_page_url;
                this.page.first = data.first_page_url;
                this.page.count = data.last_page;


            }
        }
    }
</script>