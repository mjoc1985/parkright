<template>

    <div class="flex-1">
        <div class="card">
            <div class="card-header">
                <h1>Agents</h1>
            </div>
            <div class="card-body md:p-0">
                <div>
                    <table class="table w-full">
                        <thead class="text-grey-darkest text-base bg-grey-lightest">
                        <tr>
                            <th class="pl-10">#</th>
                            <th class="px-2 pl-10 text-left">Agent</th>
                            <th class="px-2 text-left">Slug</th>
                            <th class="px-2 text-left sm:hidden md:block">Email</th>
                            <th class="pr-10">&nbsp</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr class="text-sm border-b border-grey-lighter" v-for="agent in agents">
                            <td class="py-4 pl-10 text-primary-black text-center font-semibold">
                                {{agent.id}}
                            </td>
                            <td class="py-4 pl-10 px-2">
                                <span class="font-semibold text-primary-black">{{agent.name}}</span>
                            </td>
                            <td class="py-4 px-2">
                                <span class="block">{{agent.slug}}</span>

                            </td>
                            <td class="py-4 px-2 md:block sm:hidden">
                                <span class="block">{{agent.email}}</span>
                            </td>

                            <td class="py-4">
                                <router-link :to="{name: 'agents-edit', params:{id:agent.id}}"
                                             class="btn btn-sm text-primary">
                                    Manage
                                </router-link>
                                <!--<button @click.prevent class="btn btn-sm text-primary">Manage</button>-->
                                <!--<button class="btn btn-sm text-primary-dark">Waiver</button>button-->

                                <!--<button class="btn btn-sm text-red">Cancel</button>-->

                            </td>

                        </tr>

                        </tbody>
                    </table>
                    <div v-if="agents == null" class="w-full p-8 text-center text-primary">There are no agents to
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
                agents: null,
            }
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch() {
                axios.get('agents')
                    .then(response => {
                        this.agents = response.data;
                    });
            },
            updateBookings(data) {

                this.bookings = data.data;
                this.setPages(data);


            },
            changePage(page) {
                axios.get(page)
                    .then(response => {
                        this.bookings = response.data.bookings.data;
                        this.setPages(response.data.bookings);

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