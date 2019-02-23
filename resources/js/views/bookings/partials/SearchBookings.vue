<template>
    <div class="w-1/2">
        <input v-on:keyup.enter="search" v-model="query" type="text" class="form-input" placeholder="Search bookings">
        
    </div>
</template>
<script>
    export default {
        data(){
            return {
                query: '',
                bookings:[]
            }
        },
        methods:{
            search(){
                let query = this.query;
                if (query) {
                     query = '?query=' + query;
                }
                axios.get('bookings' + query)
                    .then(response => {
                        this.bookings = response.data.bookings;
                        this.$emit('bookings', this.bookings)
                    });
            }
        }
    }
</script>