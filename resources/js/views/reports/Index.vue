<template>
    <main class="md:flex sm:block w-full">
        <sub-nav></sub-nav>

        <div class="flex-1">
            <div class="card ">
                <div class="card-header flex">
                    <h1>Overview</h1>
                </div>
                <div class="card-body clearfix">   


                </div> <!-- end card body -->

                <div class="card-footer">

                </div>
            </div>


        </div>
    </main>
</template>
<script>
    import SubNav from '../../views/reports/partials/SubNav'
    export default {
    components:{SubNav},
        data() {
            return {}
        },
        created() {

        },
        methods: {}
    }
</script>