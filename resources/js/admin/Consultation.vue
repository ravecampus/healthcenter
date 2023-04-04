<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Consultation</h3>
            </div>
            <!-- <div class="col-md-7 align-self-center">
                <button type="button" @click="showModal()" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white">
                    <i class="fa fa-plus"></i> Check Up
                </button>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" v-if="cons" @click="consult()" class="btn btn-info text-white">
                            {{btncap}}
                        </button>
                        <button type="button" v-if="!cons"  @click="showModal()" class="btn btn-info text-white">
                           <i class="fa fa-plus"></i> Add Diagnosis
                        </button>
                        <div class="table-responsive mt-5" v-if="!cons">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>DIAGNOSIS</th>
                                        <th>SYMTOMS</th>
                                        <th>MEDICINES </th>
                                        <!-- <th>PRESCRIPTION</th> -->
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, idx) in diagnosis" :key="idx">
                                        <td>{{ list.diagnosis_name }}</td>
                                        <td>{{ list.symtoms }}</td>
                                        <td> 
                                            <div class="d-flex justify-content-between">
                                                 <h5>List of Items</h5>
                                                <button type="button" @click="showModalMed(list)" class="btn btn-sm btn-info text-white">add</button>
                                               
                                            </div>
                                            <hr class="mb-0">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Quantity</th>
                                                        <th>Prescription</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(ls, idxx) in list.medicine_dispense" :key="idxx">
                                                        <td>{{ ls.medicine.medicine_name }} - {{ extractMedicineType(ls.medicine.medicine_type ) }}</td>
                                                        <td>{{ ls.quantity}}</td>
                                                        <td>Take {{ ls.times }} times a {{ ls.every_take }}
                                                            <p>Note: {{ls.note}}</p>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button type="button" @click="editDM(ls)" class="btn btn-info text-white btn-sm">
                                                                    <i class="fa fa-pencil"></i> Edit
                                                                </button>
                                                                 <button type="button" @click="deteleDM(ls)" class="btn btn-danger text-white btn-sm">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                       </td>
                                        <td>
                                            <button type="button" @click="editModal(list)" class="btn btn-info text-white btn-sm">
                                                <i class="fa fa-pencil"></i> Edit
                                            </button>
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
                        <button type="button" v-if="diagnosis.length > 0" @click="completeDiagnosis()" class="btn btn-info text-white">Complete</button>
                    </div>
                </div>
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
            errors:[],
            cons:true,
            btncap:"Consult?",
            btncap1:"Save",
            btncap2:"Save",
            btncom:"Complete",
            diagnosis:[],
            medicines:[],
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
                this.$axios.delete('api/service-request-complete/'+id).then(res=>{
                    this.$emit('show',{'message':'Medicine has been Deleted!'});
                    this.btncom = "Complete";
                    // this.listDiagnos();
                    // $('.delete').modal('hide');
                });
            });
        }
        

    },
    mounted() {
        let id = this.$route.params.id;
        this.checkConsult(id);
        this.listDiagnos(id);
        this.listMedicine();
    },

}
</script>

<style>

</style>
