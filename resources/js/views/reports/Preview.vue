<template>
    <div v-if="this.viewData.date != null" class="flex-1">
        <div class="card text-sm">
            <div class="card-header flex">
                <h1>Preview for {{this.viewData.date}}</h1>
            </div>
            <div class="card-body clearfix">
                <div class="w-full clearfix my-2">
                    <div class="p-4"><p v-html="this.viewData.view"></p></div>
                </div>


            </div> <!-- end card body -->

            <div class="card-footer">
                

            </div>
        </div>


    </div>
</template>
<script>
    export default {
        props:['viewData'],
        data(){
            return {
                show: false
            }
        },
        watch:{
          viewData: function(){
              this.show = true
          } 
        },
        methods:{
            
        }
    }
</script>