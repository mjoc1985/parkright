<template>

        <div class="md:container sm:w-full mx-auto p-8">
            <div class="py-10 text-center">
                <img style="max-width: 20rem" src="/storage/logo.png" alt="">
            </div>
            <div class="mx-auto max-w-sm">
                <div class="bg-white rounded shadow">
                    <div class="border-b py-8 font-bold text-black text-center text-xl tracking-widest uppercase">
                        Welcome back!
                    </div>
                    
                    <div class="p-2  bg-grey-lightest text-center" v-if="error">
                        <p class="rounded text-white bg-red-light font-semibold">{{ errors.msg }}</p>
                    </div>

                    <form class="bg-grey-lightest px-10 py-10">

                        <div class="mb-3">
                            <input class="border w-full p-3" v-model="email" name="email" type="text" placeholder="E-Mail">
                        </div>
                        <div class="mb-6">
                            <input class="border w-full p-3" v-model="password" name="password" type="password" placeholder="**************">
                        </div>
                        <div class="flex">
                            <button @click.prevent="login" class="bg-primary hover:bg-primary-dark w-full p-4 text-sm text-white uppercase font-bold tracking-wider">
                                Login
                            </button>
                        </div>
                    </form>

                    <div class="border-t px-10 py-6">
                        <div class="flex justify-between">
                            <a href="#" class="text-primary text-sm hover:text-primary-dark no-underline">Powered by <span class="font-bold text-base">ParkRight</span></a>
                            <a href="#" class="text-grey-darkest hover:text-black no-underline">Forgot Password?</a>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
</template>
<script>
    export default {
        data() {
            return {
                email: null,
                password: null,
                error: false,
                errors: []
            }
        },
        
        methods: {
            login() {
                let app = this;
                this.$auth.login({
                    params: {
                        email: app.email,
                        password: app.password
                    },
                    success: function () {
                        // let user = app.$auth.user();
                        // app.$emit('auth-user', user)
                    },
                    error: function (error) {
                        app.error = true;
                        app.errors = error.response.data;
                    },
                    rememberMe: true,
                    redirect: '/',
                    fetchUser: true,
                    
                });
            }
        }

    }
</script>