<template>
    <nav class="w-full max-w-screen mx-auto md:px-4">
        <div class="md:flex sm:flex py-3 border-b border-grey">

            <div class="md:flex md:flex-1 sm:flex-1 sm:pl-4">
              <span>
                    <img src="/storage/logo.png" style="max-width: 15rem;">
              </span>

            </div>
            <template>
                <div class="sm:flex md:hidden mr-10 relative">
                    <button @click="mobileMenu = !mobileMenu" class="flex flex-1 text-3xl relative"><i class="fas fa-bars"></i></button>
                </div>

                <div v-if="mobileMenu" style="top:86px" class="absolute w-full text-center mb-10 bg-white h-screen z-30">
                    <ul class="inline-block text-center list-reset p-4">
                        <li>
                            <router-link
                                    :to="{path: '/'}"
                                    class="flex items-center no-underline p-2">
                                <i class="fas fa-tachometer-alt fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Dashboard
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                    :to="{path: '/agents'}"
                                    class="flex items-center no-underline p-2">
                                <i class="fas fa-users fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Agents
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                    :to="{path: '/bookings'}"
                                    class="flex items-center no-underline p-2">
                                <i class="fas fa-calendar-alt fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Bookings
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                    :to="{path: '/products'}"
                                    class="flex items-center no-underline p-2">
                                <i class="fas fa-car fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Products
                            </router-link>
                        </li>
                        <li>

                            <router-link
                                    :to="{path: '/reports/schedule'}"
                                    class="flex items-center no-underline p-2">

                                <i class="fas fa-chart-line fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Reports

                            </router-link>
                        </li>
                        <div class="leading-tight text-sm font-semibold mt-8">{{ $auth.user().name}}</div>
                        <a class="text-primary hover:underline text-sm font-bold leading-tight no-underline block"
                           href="#"
                           @click.prevent="$auth.logout()">Logout</a>


                    </ul>
                    

                </div>
            </template>

            <template>
                <div class="sm:hidden md:flex md:flex-1 items-center">


                    <ul class="flex flex-1 justify-between list-reset">
                        <li>
                            <router-link
                                    :to="{path: '/'}"
                                    class="flex items-center no-underline">
                                <i class="fas fa-tachometer-alt fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Dashboard
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                    :to="{path: '/agents'}"
                                    class="flex items-center no-underline">
                                <i class="fas fa-users fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Agents
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                    :to="{path: '/bookings'}"
                                    class="flex items-center no-underline">
                                <i class="fas fa-calendar-alt fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Bookings
                            </router-link>
                        </li>
                        <li>
                            <router-link
                                    :to="{path: '/products'}"
                                    class="flex items-center no-underline">
                                <i class="fas fa-car fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Products
                            </router-link>
                        </li>
                        <li>

                            <router-link
                                    :to="{path: '/reports/schedule'}"
                                    class="flex items-center no-underline">

                                <i class="fas fa-chart-line fill-current mr-2 hover:text-primary text-grey-dark"></i>
                                Reports

                            </router-link>
                        </li>


                    </ul>

                </div>

                <div class="sm:hidden  md:flex items-center ml-6 pl-6 border-l border-grey">
                    <div class="ml-2 flex-1">
                        <div class="leading-tight text-sm font-semibold">{{ $auth.user().name}}</div>
                        <a class="text-primary hover:underline text-sm font-bold leading-tight no-underline block"
                           href="#"
                           @click.prevent="$auth.logout()">Logout</a>
                    </div>
                </div>
            </template>

        </div>
    </nav>
</template>
<script>
    export default {
        data(){
            return{
                mobileMenu: false
            }
        },
        watch: {
            '$route' () {
                this.mobileMenu = false
            }
        }
    }
</script>