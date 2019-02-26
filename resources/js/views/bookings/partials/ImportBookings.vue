<template>
    <div>
        <button @click="$modal.show('booking-import-modal')"
                class="btn bg-indigo rounded hover:bg-indigo-dark h-11 text-white font-bold p-3 inline-flex items-center">
            <svg fill="#FFF" height="18" viewBox="0 0 24 24" width="18"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
            </svg>
            <span class="ml-2">Upload Bookings</span>
        </button>
        <booking-import-modal></booking-import-modal>
    </div>
</template>
<script>
    import BookingImportModal from '../../modals/BookingImportModal'

    export default {
        components: {BookingImportModal}
    }
</script>

