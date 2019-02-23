<template>
    <nav class="w-full max-w-screen mx-auto px-4">
        <div class="flex py-3 border-b border-grey">

            <div class="flex flex-1">
              <span>
                    <img src="/storage/logo.png" style="max-width: 15rem;">
              </span>

            </div>
            <div class="flex flex-1 items-center">

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
                                :to="{path: '/bookings'}"
                                class="flex items-center no-underline">
                                <i class="fas fa-calendar-alt fill-current mr-2 hover:text-primary text-grey-dark"></i>
                            Bookings
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
            <div class="flex items-center ml-6 pl-6 border-l border-grey">
                <div class="ml-2 flex-1">
                    <div class="leading-tight text-sm font-semibold">{{ $auth.user().name}}</div>
                    <a class="text-primary hover:underline text-sm font-bold leading-tight no-underline block" href="#" @click.prevent="$auth.logout()">Logout</a>
                </div>
                
            </div>

        </div>
    </nav>
</template>
<script>
    export default {}
</script>