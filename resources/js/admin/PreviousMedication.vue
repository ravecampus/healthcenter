<template>
     <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Previous Medication</h3>
            </div>
            <!-- <div class="col-md-7 align-self-center">
                <button type="button" @click="showModal()" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white">
                    <i class="fa fa-plus"></i> Add Item
                </button>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ patient.first_name }} {{ patient.middle_name }} {{ patient.last_name }}</h4>
                        <hr>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between" v-for="(list, idx) in medications" :key="idx">
                                <div class="h6">
                                    <small>Date consulted: </small>
                                    {{ formatDate(list.consulted.created_at) }}
                                </div>
                                <div class="h6">
                                    <small>Medical Service: </small>
                                    {{ list.medical_service.description }}
                                </div>
                                <div class="h6">
                                    <small>Consultant: </small>
                                    {{ list.consulted.healthworker.first_name }}
                                </div>
                                <button type="button" class="btn btn-sm btn-info text-white" @click="viewMedication(list)">
                                    <i class="fa fa-eye"></i> View
                                </button>
                            </li>
                            <li class="list-group-item" v-show="!noData(medications)"> 
                                <div>
                                    No Result Found!
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
     </div>
</template>

<script>
export default {
    data(){
        return{
            medications:[],
            patient:{}
        }
    },
    methods: {
        listPreviousMedication(){
            let id = this.$route.params.id;
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.$axios.get('api/previous-med/'+id).then(res=>{
                    this.medications = res.data;
                });
            });
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        viewMedication(data){
            this.$router.push({name:'viewcompleted', params:{'id':data.id}});
        },
        getPatient(id){
            this.$axios.get('sanctum/csrf-cookie').then(res=>{
                this.$axios.get('api/user-auth/'+id).then(res=>{
                    this.patient = res.data;
                });
            });

        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
    },
    mounted(){
        this.listPreviousMedication();
        let id = this.$route.params.id;
        this.getPatient(id);

    }
}
</script>

<style>

</style>
