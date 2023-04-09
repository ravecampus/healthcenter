<template>
    <div class="container-fluid">
            
        <div class="row page-titles d-print-none mb-0">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Consultation</h3>
               
            </div>
        </div>
        <div class="row mt-0" v-if="service.id != undefined">
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
               <hr>
                <div class="col-6 d-flex justify-content-between">
                    <div>
                        <div class="h6"><small>MEDICAL SERVICE:</small> {{ service.medical_service.description  }}</div>
                        <div class="h6"><small>CONSULTANT:</small> {{ service.consulted.healthworker.first_name  }} {{ service.consulted.healthworker.last_name }}</div>
                        <div class="h6"><small>DATE:</small> {{ formatDate(service.consulted.created_at)  }}</div>
                     </div>
                     <div>
                        <button type="button" @click="print()" class="btn btn-info text-white d-print-none">
                            <i class="fa fa-print"></i> Print
                        </button>
                     </div>
               </div>
           
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                     
                        <div class="table-responsive" v-if="!cons">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>DIAGNOSIS</th>
                                        <th>SYMTOMS</th>
                                        <th>MEDICINES </th>
                                        <!-- <th>PRESCRIPTION</th> -->
                                        <!-- <th>ACTION</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, idx) in diagnosis" :key="idx">
                                        <td>{{ list.diagnosis_name }}</td>
                                        <td>{{ list.symtoms }}</td>
                                        <td> 
                                            <div class="d-flex justify-content-between">
                                                 <!-- <h5>List of Items</h5> -->
                                                <!-- <button type="button" @click="showModalMed(list)" class="btn btn-sm btn-info text-white">add</button> -->
                                               
                                            </div>
                                            <!-- <hr class="mb-0"> -->
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Prescription</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(ls, idxx) in list.medicine_dispense" :key="idxx">
                                                        <td>{{ ls.medicine.medicine_name }} - {{ extractMedicineType(ls.medicine.medicine_type ) }}</td>
                                                        <td>{{ ls.quantity}}</td>
                                                        <td>Take {{ ls.times }} times a {{ ls.every_take }}
                                                            <p>Note: {{ls.note}}</p>
                                                        </td>
                                                        <!-- <td>
                                                            <div class="btn-group">
                                                                <button type="button" @click="editDM(ls)" class="btn btn-info text-white btn-sm">
                                                                    <i class="fa fa-pencil"></i> Edit
                                                                </button>
                                                                 <button type="button" @click="deteleDM(ls)" class="btn btn-danger text-white btn-sm">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                       </td>
                                        <!-- <td>
                                            <button type="button" @click="editModal(list)" class="btn btn-info text-white btn-sm">
                                                <i class="fa fa-pencil"></i> Edit
                                            </button>
                                        </td> -->
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

         <div class="modal fade item">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Medical Diagnosis</h6>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Diagnosis Name</label>
                                    <input type="text" v-model="post.diagnosis_name" class="form-control form-control-user" placeholder="Enter Diagnosis Name">
                                    <span class="errors-material" v-if="errors.diagnosis_name">{{errors.diagnosis_name[0]}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Symtoms</label>
                                    <textarea v-model="post.symtoms" class="form-control form-control-user" placeholder="Enter Symtoms">
                                    </textarea>
                                    <span class="errors-material" v-if="errors.symtoms">{{errors.symtoms[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="saveDiagnosis()" class="btn btn-info text-white btn-block" >{{ btncap1 }}</button>  
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade item-2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Medical Diagnosis</h6>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label>Medicines</label>
                                    <select class="form-control" v-model="post_.medicine_id">
                                        <option v-for="(ls,idx) in medicines" :key="idx" :value="ls.id">
                                            {{ ls.medicine_name }} - {{extractMedicineType(ls.medicine_type) }}
                                        </option>
                                    </select>
                                    <!-- <input type="text" v-model="post.diagnosis_name" class="form-control form-control-user" placeholder="Enter Diagnosis Name"> -->
                                    <span class="errors-material" v-if="errors.medicine_id">{{errors.medicine_id[0]}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Total of Medicine (Quantity)</label>
                                    <input type="number" v-model="post_.quantity" class="form-control form-control-user" placeholder="Enter Quantity">
                                    <span class="errors-material" v-if="errors.quantity">{{errors.quantity[0]}}</span>
                                </div>
                                <hr class="mb-0">
                                <small>Prescription</small>
                                <div class="row mb-3 mt-3">
                                    <div class="form-group col-6">
                                        <label># of times taking medicine</label>
                                        <input type="number" v-model="post_.times" class="form-control form-control-user" placeholder="Enter Times">
                                        <span class="errors-material" v-if="errors.times">{{errors.times[0]}}</span>
                                    </div>
                               
                                    <div class="form-group col-6">
                                        <label>Per</label>
                                        <select class="form-control" v-model="post_.every_take">
                                            <option :value="'Minute'">Minute</option>
                                            <option :value="'Hour'">Hour</option>
                                            <option :value="'Day'">Day</option>
                                            <option :value="'Month'">Month</option>
                                        </select>
                                        <span class="errors-material" v-if="errors.every_take">{{errors.every_take[0]}}</span>
                                    </div>
                                </div>
                                 <div class="form-group mb-3">
                                    <label>Note</label>
                                    <textarea class="form-control" v-model="post_.note" placeholder="Please leave a note.."></textarea>
                                    <span class="errors-material" v-if="errors.note">{{errors.note[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="saveMedineDis()" class="btn btn-info text-white btn-block" >{{ btncap2 }}</button>  
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade delete" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Delete</h4>
                </div>
                    <div class="modal-body">
                        <h4>Do you want to delete?</h4>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="delConfirm()" class="btn btn-danger btn-sm text-white">
                            <i class="fa fa-check"></i>
                           Yes
                        </button>
                        <button type="button" @click="cancel()" class="btn btn-info btn-sm text-white">
                            <i class="fa fa-times"></i>
                           No
                        </button>
        
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
            post:{},
            post_:{
                medicine:{}
            },
            service:{
                patient:{},
                medical_service:{},
                consulted:{
                    healthworker:{}
                }
            },
            errors:[],
            cons:true,
            btncap:"Consult?",
            btncap1:"Save",
            btncap2:"Save",
            btncom:"Complete",
            diagnosis:[],
            medicines:[],
            puroks:[],
        }
    },
    methods: {

        showModal(){
            $('.item').modal('show');
        },
        editModal(data){
            this.post = data;
            $('.item').modal('show');
        },
        showModalMed(data){
            this.post_ = {};
            this.post_.diagnos_id = data.id;
            $('.item-2').modal('show');
        },
        editDM(data){
            this.post_ = data;
            $('.item-2').modal('show');
        },
        deteleDM(data){
            this.post_ = data;
            $('.delete').modal('show');
        },
        cancel(){
            $('.delete').modal('hide');
        },
        consult(){
            if(this.cons){
                this.post.service_request = this.$route.params.id;
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap = "Generating...";
                    this.$axios.post('api/consultation', this.post).then(res=>{
                        this.btncap = "Consult?";
                        this.$emit('show',{'message':'Consulation has been Generated!'});
                        this.post = {};
                        this.errors = [];
                        // this.listOfSchedule();
                        let id = this.$route.params.id;
                        this.checkConsult(id);
                    });
                });
            }
        },
        checkConsult(id){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/check-consult/'+id).then(res=>{
                   this.cons = res.data;
               });
           });
        },
        saveDiagnosis(){
            let id = this.$route.params.id;
            if(this.post.id > 0){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap1 = "Saving...";
                    this.$axios.put('api/diagnosis/'+this.post.id,this.post).then(res=>{
                        this.btncap1 = "Save";
                        this.$emit('show',{'message':'Diagnosis has been Modefied!'});
                        this.post = {};
                        this.errors = [];
                        this.listDiagnos(id);
                        $('.item').modal('hide');
                    }).catch(err=>{
                        this.btncap1 = "Save";
                        this.errors = err.response.data.errors;
                    })
                });
            }else{
                this.post.service_request = this.$route.params.id;
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap1 = "Saving...";
                    this.$axios.post('api/diagnosis',this.post).then(res=>{
                        this.btncap1 = "Save";
                        this.$emit('show',{'message':'Diagnosis has been Added!'});
                        this.post = {};
                        this.errors = [];
                        this.listDiagnos(id);
                        $('.item').modal('hide');
                    }).catch(err=>{
                        this.btncap1 = "Save";
                        this.errors = err.response.data.errors;
                    })
                });
            }
            
        },
        listDiagnos(id){
             this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.$axios.get('api/diagnosis/'+id).then(res=>{
                    this.diagnosis = res.data;
                });
            });
        },
        listMedicine(){
             this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.$axios.get('api/medicine-list').then(res=>{
                    this.medicines = res.data;
                });
            });
        },
        // listMedicineDispense(){
        //      this.$axios.get('sanctum/csrf-cookie').then(response => {
        //         this.$axios.get('api/medicine-dispense').then(res=>{
        //             this.medicine_dispenses = res.data;
        //         });
        //     });
        // },
         extractMedicineType(num){
            return num == 1 ? "Tablet" : num == 2 ? "Capsule" : num == 3 ? "Syrup" : num == 4 ? "Suspension" : num == 5 ? "Drops" : num == 6 ? "Powder": ""; 
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },

        saveMedineDis(){
            let id = this.$route.params.id;
            if(this.post_.id > 0){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap2 = "Saving...";
                    this.$axios.put('api/medicine-dispense/'+this.post_.id,this.post_).then(res=>{
                        this.btncap2 = "Save";
                        this.$emit('show',{'message':'Medicine has been Modefied!'});
                        this.post_ = {};
                        this.errors = [];
                        this.listDiagnos(id);
                        $('.item-2').modal('hide');
                    }).catch(err=>{
                        this.btncap2 = "Save";
                        this.errors = err.response.data.errors;
                    })
                });
            }else{
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap2 = "Saving...";
                    this.$axios.post('api/medicine-dispense',this.post_).then(res=>{
                        this.btncap2 = "Save";
                        this.$emit('show',{'message':'Medicine has been Added!'});
                        this.post_ = {};
                        this.errors = [];
                        this.listDiagnos(id);
                        $('.item-2').modal('hide');
                    }).catch(err=>{
                        this.btncap2 = "Save";
                        this.errors = err.response.data.errors;
                    })
                });
            }
            
        },
        delConfirm(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.delete('api/medicine-dispense/'+this.post_.id).then(res=>{
                    this.$emit('show',{'message':'Medicine has been Deleted!'});
                    this.post_ = {
                        medicine:{}
                    };
                    this.listDiagnos();
                    $('.delete').modal('hide');
                });
            });
        },
        completeDiagnosis(){
            let id = this.$route.params.id;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncom = "Completing...";
                this.$axios.get('api/service-request-complete/'+id).then(res=>{
                    this.$emit('show',{'message':'Service Request has been Completed!'});
                    this.btncom = "Complete";
                    // this.listDiagnos();
                    // $('.delete').modal('hide');
                    this.$router.push({name:'completed'});
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
        extractGender(num){
            return num == 1 ? "Male" : "Female";
        },
        extractCS(num){
            return num == 1 ? "Single" : num == 2 ? "Married" : num == 3 ? "Legally Separated" : num == 4 ? "Annulled" : num == 5 ? "Widow/er" : "";
        },
        setAge(){
            if(this.post.birthdate != null){
                let cy = new Date().getFullYear();
                let by = new Date(this.post.birthdate).getFullYear();
                let age = cy - by;
                let res = isNaN(age) ? 0 : age;
                this.post.age = res;
            }else{
                this.post.age = 0;
            }
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
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
       print(){
           window.print();
       }
        

    },
    mounted() {
        this.listPurok();
        let id = this.$route.params.id;
        this.checkConsult(id);
        this.listDiagnos(id);
        this.listMedicine();
        this.getServiceRequest();
       
    },

}
</script>

<style>

</style>
