<template>
    <div id="app" class="min-h-screen flex flex-col">
        <nav-bar v-if="this.$auth.ready() && this.$auth.check()"></nav-bar>
        <login v-if="this.$auth.ready() && !this.$auth.check()"></login>

        <div class="flex-1">
            <div class="w-full max-w-screen mx-auto px-4 flex py-8">
                <router-view v-on:loaded=" loading = !loading"></router-view>
                <notifications :duration=5000 :speed=600 classes="vue-notification animated slideInRight"></notifications>

            </div>   
        </div>
        <modals-container></modals-container>

    </div>
</template>
<script>
    import NavBar from './partials/Nav';
    import Login from '../views/Login'

    export default {
        // name: 'App',
        components: {NavBar, Login},
        data() {
            return {
                loading: false,
                //user: this.$auth.user()
            }
        },


    }
</script>