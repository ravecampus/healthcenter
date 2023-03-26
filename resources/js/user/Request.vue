<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Request Medication</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <!-- <button type="button" @click="showModal()" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white">
                    <i class="fa fa-plus"></i> Add Item
                </button> -->
            </div>
        </div>
    
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group col-6">
                            <label for="example-email" class="col-md-12">Medical Service</label>
                            <div class="col-md-12">
                                <select class="form-control" v-model="post.medical_service">
                                    <option v-for="(ls, idx) in medical_services" :key="idx" :value="ls.id">{{ ls.description }}</option>
                                </select>
                            </div>

                            <span class="errors-material" v-if="errors.medical_service">{{errors.medical_service[0]}}</span>
                        </div>
                        <div class="form-group col-6">
                            <label for="example-email" class="col-md-12">Schedule</label>
                            <!-- <div class="col-md-12">
                                <select class="form-control" v-model="post.medical_service">
                                    <option v-for="(ls, idx) in medical_services" :key="idx" :value="ls.id">{{ ls.description }}</option>
                                </select>
                            </div> -->
                            <table class="table table-stripped">
                                <tbody>
                                    <tr v-for="(ls, idx) in schedules" :key="idx">
                                        <td></td>
                                        <td>{{ extractTime(ls.start_time) }} - {{  extractTime(ls.end_time)}} | {{ xtractDay(ls.day) }}</td>
                                        <td> {{ ls.healthworker.first_name}} {{ ls.healthworker.last_name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <span class="errors-material" v-if="errors.medical_service">{{errors.medical_service[0]}}</span>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">List of Items</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="col-6"> 
                            <input type="text" class="form-control" v-model="tableData.search" @input="listOfItem()" placeholder="Search...">
                        </div>
                        <div class="table-responsive">
                            <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                <tbody>
                                    <tr class="tr-shadow" v-for="(list, idx) in medicines" :key="idx">
                                        <td class="text-info">
                                            <strong>
                                            {{ list.medicine_name }}
                                            </strong>
                                        </td>
                                        <td>{{ extractMedicineType(list.medicine_type) }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="btn btn-info text-white btn-sm" data-toggle="tooltip" @click="editModal(list)" title="Edit">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="4" v-show="!noData(medicines)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                </tbody>
                            </data-table>
                            <div>
                                <pagination :pagination="pagination"
                                    @prev="listOfItem(pagination.prevPageUrl)"
                                    @next="listOfItem(pagination.nextPageUrl)"
                                    v-show="noData(medicines)">
                                </pagination>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade item" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Doctors</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Medicine name</label>
                                    <input type="text" v-model="post.medicine_name" class="form-control form-control-user" placeholder="Medicine Name">
                                    <span class="errors-material" v-if="errors.medicine_name">{{errors.medicine_name[0]}}</span>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label>Medicine Type</label>
                                    <select class="form-control" v-model="post.medicine_type">
                                        <option value="1">Tablet</option>
                                        <option value="2">Capsule</option>
                                        <option value="3">Syrup</option>
                                        <option value="4">Suspension</option>
                                        <option value="5">Drops</option>
                                        <option value="6">Powder</option>
                                    </select>
                                    <span class="errors-material" v-if="errors.medicine_type">{{errors.medicine_type[0]}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="saveItem()" class="btn btn-info text-white">
                            <i class="fa fa-save"></i>
                            {{ btncap }}
                        </button>
                        <!-- <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button> -->
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){

        let sortOrders = {};
        let columns =[
        {label:'MEDICINE NAME', name:null},
        {label:'MEDICINE TYPE', name:null},
        {label:'Action', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btncap:"Save",
            post:{},
            errors:[],
            medical_services:[],
            medicines:[],
            schedules:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                filter:1,
            },
            pagination:{
                lastPage:'',
                currentPage:'',
                total:'',
                lastPageUrl:'',
                nextPageurl:'',
                prevPageUrl:'',
                from:'',
                to:''
            },

        }
    },
    methods: {
        listMedicalService(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/medical-service').then(res=>{
                   this.medical_services = res.data;
               })
           });
       },
        lisOfSchedule(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/list-schedule').then(res=>{
                   this.schedules = res.data;
               })
           });
       },
        extractTime(time){
          // Check correct time format and split into components
            time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) { // If time format correct
                time = time.slice (1);  // Remove full string match value
                time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                time[0] = +time[0] % 12 || 12; // Adjust hours
            }
            return time.join (''); // return adjusted time or original string
        },
        xtractDay(data){
            let data_ = JSON.parse(data);
            let txt = "";
            data_.sort((a, b) => a - b);
            data_.forEach(val=>{
                if(val == 1){
                    txt += "M";
                }
                if(val==2){
                    txt += "T";
                }
                if(val==3){
                    txt += "W";
                }
                if(val==4){
                    txt += "TH";
                }
                if(val==5){
                    txt += "F";
                }
                if(val==6){
                    txt += "S";
                }
            });

            return txt;
        },

       showModal(){
           this.post = {};
           this.errors = [];
           $('.item').modal('show');
       },
       editModal(data){
           this.post = data;
           $('.item').modal('show');           
       },
       saveItem(){
        if(this.post.id > 0){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.put('api/medicine/'+this.post.id, this.post).then(res=>{
                   this.btncap = "Save";
                   this.$emit('show',{'message':'Medicine has been modified!'});
                   this.post = {};
                   this.listOfItem();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.post('api/medicine', this.post).then(res=>{
                   this.btncap = "Save";
                   this.post = {};
                   this.$emit('show',{'message':'Medicine has been saved!'});
                   this.listOfItem();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }
          
       },
        listOfItem(urls='api/medicine'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.medicines = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                
                }).catch(err=>{
                
                });
            });
        },
        configPagination(data){
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key){
            if(key != null){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.listOfItem();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        extractPostion(num){
            return num == 1 ? "Nurse" : "Midwife";
        },
        extractMedicineType(num){
            return num == 1 ? "Tablet" : num == 2 ? "Capsule" : num == 3 ? "Syrup" : num == 4 ? "Suspension" : num == 5 ? "Drops" : num == 6 ? "Powder": ""; 
        }
    },
    mounted() {
        this.listOfItem();
        this.listMedicalService();
        this.lisOfSchedule();
    },
}
</script>

<style>

</style>
