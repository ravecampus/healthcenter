<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Make a Service Request?</h4>
                        <button type="button" class="btn btn-info text-white btn-lg" @click="requestService()">
                            <i class="fa fa-send"></i> Proceed
                        </button>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</template>

<script>
export default {
    methods:{
        requestService(){
            this.$router.push({name:'userrequest'});
        }
    }

}
</script>

<style>

</style>
