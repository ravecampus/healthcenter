<template>
    <div class="container-fluid">
        <div class="row page-titles d-print-none">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">View Medication</h3>
            </div>
            <div class="col-md-7 align-self-center">
                
            </div>
        </div>
        <div class="row" v-if="service.id != undefined">
            <div class="col-12 text-center d-none d-print-block">
                <h4>BARANGAY UGALINGAN HEALTH CENTER</h4>
                <h5>Barangay Ugalingan, Carmen North Cotabato</h5>
            </div>
            <div class="col-12 row mt-4 p-4">
               <div class="col-6">
                    <div class="h6"><small>NAME:</small> {{ service.patient.first_name }} {{ service.patient.middle_name }} {{ service.patient.last_name}}</div>
                    <div class="h6"><small>GENDER:</small> {{ extractGender(service.patient.gender) }}</div>
                    <div class="h6"><small>BIRTHDATE:</small> {{ formatDate(service.patient.birthdate) }}</div>
                    <div class="h6"><small>BIRTH PLACE:</small> {{ service.patient.birth_place }}</div>
                    <div class="h6"><small>CONTACT NUMBER:</small> {{ service.patient.contact_number }}</div>
               </div>
               <div class="col-6">
                     <div class="h6"><small>AGE:</small> {{ service.patient.age }}</div>
                     <div class="h6"><small>CIVIL STATUS:</small> {{ extractCS(service.patient.civil_status) }} </div>
                     <div class="h6"><small>PUROK:</small> {{ xtractPurok(service.patient.purok) }}</div>
                     <div class="h6"><small>OCCUPATION:</small> {{ service.patient.occupation }}</div>
                     <div class="h6"><small>EMAIL:</small> {{ service.patient.email }}</div>
               </div>
            </div>
            <div class="col-6 d-flex justify-content-between">
                <div>
                    <div class="h6"><small>MEDICAL SERVICE:</small> {{ service.medical_service.description  }}</div>
                    <div class="h6"><small>CONSULTANT:</small> {{ service.consulted.healthworker.first_name  }} {{ service.consulted.healthworker.last_name }}</div>
                    <!-- <div class="h6"><small>DATE:</small> {{ formatDate(service.consulted.created_at)  }}</div> -->
                </div>
                <div>
                    <button type="button" @click="print()" class="btn btn-info text-white d-print-none">
                        <i class="fa fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                     
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>DIAGNOSIS</th>
                                        <th>SYMTOMS</th>
                                        <th>MEDICINES </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, idx) in diagnosis" :key="idx">
                                        <td>{{ list.diagnosis_name }}</td>
                                        <td>{{ list.symtoms }}</td>
                                        <td> 
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Prescription</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(ls, idxx) in list.medicine_dispense" :key="idxx">
                                                        <td>{{ ls.medicine.medicine_name }} - {{ extractMedicineType(ls.medicine.medicine_type ) }}</td>
                                                        <td>{{ ls.quantity}}</td>
                                                        <td>Take {{ ls.times }} times a {{ ls.every_take }}
                                                            <p>Note: {{ls.note}}</p>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                       </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="4" v-show="!noData(diagnosis)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <button type="button" v-if="diagnosis.length > 0" @click="completeDiagnosis()" class="btn btn-info text-white">Complete</button> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-none d-print-block">
               Printed Date: {{ formatDate(new Date())}}
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            diagnosis:[],
            service :{
                patient:{},
                medical_service:{},
                consulted:{
                    healthworker:{}
                }
            }, puroks:[]
        }
    },
    methods: {
        listDiagnos(){
            let id = this.$route.params.id;
             this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.$axios.get('api/diagnosis/'+id).then(res=>{
                    console.log(res.data)
                    this.diagnosis = res.data;
                });
            });
        },
        getServiceRequest(){
            let id = this.$route.params.id;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/service-request/'+id).then(res=>{
                   this.service = res.data; 
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
         extractGender(num){
            return num == 1 ? "Male" : "Female";
        },
        extractCS(num){
            return num == 1 ? "Single" : num == 2 ? "Married" : num == 3 ? "Legally Separated" : num == 4 ? "Annulled" : num == 5 ? "Widow/er" : "";
        },
         print(){
           window.print();
       },
        listPurok(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/purok').then(res=>{
                   this.puroks = res.data;
               })
           });
       },
       xtractPurok(num){
           let ret ="";
           this.puroks.forEach(val => {
               if(val.id == num){
                   ret = val.purok_name;
               }
           });
           return ret;
       }, 
       noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },

        extractMedicineType(num){
            return num == 1 ? "Tablet" : num == 2 ? "Capsule" : num == 3 ? "Syrup" : num == 4 ? "Suspension" : num == 5 ? "Drops" : num == 6 ? "Powder": ""; 
        },
    },
    mounted() {
        this.listPurok();
        // setTimeout(() => {
            this.listDiagnos();
            this.getServiceRequest()
        // }, 500);
       
    },
}
</script>

<style>

</style>
