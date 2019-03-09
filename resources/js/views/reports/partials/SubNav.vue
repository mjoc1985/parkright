<template>
    <nav class="md:block md:w-1/6 md:mr-8 sm:w-full">
        <ul class="list-reset md:mb-8 sm:mt-4 sm:p-4 sm:inline-flex md:block">
            <div class="text-primary-black pb-3 font-bold uppercase">Reports</div>
            <!--<li><router-link :to="{path: '/reports'}" class="py-2"><i class="fas fa-th mr-2"></i>Overview</router-link></li>-->
            <li class="sm:px-4 md:px-0">
                <router-link :to="{path: '/reports/schedule'}" class="py-2"><i class="fas fa-calendar-day mr-2"></i>Daily
                    Schedule
                </router-link>
            </li>
            <li class="sm:px-4 md:px-0">
                <router-link :to="{path: '/reports/bookings/export'}" class="py-2"><i class="fas fa-calendar-day mr-2"></i>Bookings
                    Report
                </router-link>
            </li>

        </ul>
    </nav>
</template>