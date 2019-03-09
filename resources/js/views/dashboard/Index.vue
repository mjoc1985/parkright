<template>
    <main class="w-full">
        <div class="w-full sm:block md:flex md:justify-between">
            <div class="md:w-1/2 sm:w-full md:mr-2 py-2">
                <Revenue></Revenue>
            </div>
            <div class="md:w-1/2 sm:w-full md:ml-2 py-2">
                <commission></commission>
            </div>
        </div>
        <div class="w-full mt-16">
            <booking-overview></booking-overview>
        </div>
    </main>
</template>
<script>
    import Revenue from '../dashboard/modules/Revenue';
    import Commission from '../dashboard/modules/Commission';
    import BookingOverview from '../dashboard/modules/BookingOverview';

    export default {
        components: {
            Revenue,
            Commission,
            BookingOverview
        },

        data() {
            return {}
        }

    }
</script>