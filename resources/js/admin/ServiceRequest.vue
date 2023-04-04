<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Service Request</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <button type="button" @click="showModal()" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white">
                    <i class="fa fa-plus"></i> Add Item
                </button>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">List of Items</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="col-6"> 
                            <input type="text" class="form-control" v-model="tableData.search" @input="listOfServices()" placeholder="Search...(Last name, First name, Middle name)">
                        </div>
                        <div class="table-responsive">
                            <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                <tbody>
                                    <tr class="tr-shadow" v-for="(list, idx) in service_request" :key="idx">
                                        <td class="text-info">
                                            <strong>
                                            {{ list.last_name}}, {{ list.first_name }} {{ list.middle_name }}
                                            </strong>
                                        </td>
                                        <td>{{ list.medical_service.description }}</td>
                                        <td>{{extractTime(list.schedule.start_time) }} - {{ extractTime(list.schedule.end_time) }} |  {{xtractDay(list.schedule.day)}}</td>
                                        <td>{{ list.schedule.healthworker.first_name }} {{ list.schedule.healthworker.last_name }}</td>
                                        <td>{{ list.message }}</td>
                                        <td>{{ formatDate(list.created_at) }}</td>
                                        <td>{{ list.status }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-info text-white btn-sm" @click="consultation(list)" data-toggle="tooltip" title="Consult">
                                                    <i class="fa fa-user-md"></i> Consultation
                                                </button>
                                                 <button class="btn btn-warning text-white btn-sm" @click="showModalAbsent(list)" data-toggle="tooltip" title="Consult">
                                                    <i class="fa fa-times"></i> Absent
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="11" v-show="!noData(service_request)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                </tbody>
                            </data-table>
                        </div>
                        <div>
                            <pagination :pagination="pagination"
                                @prev="listOfServices(pagination.prevPageUrl)"
                                @next="listOfServices(pagination.nextPageUrl)"
                                v-show="noData(service_request)">
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade item" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Service Request</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group mb-3">
                                <label>Patient</label>
                                <select class="form-control" v-model="post.patient">
                                    <option v-for="(ls, idx) in patients" :key="idx" :value="ls.id">{{ ls.first_name }} {{ ls.last_name }}</option>
                                </select>
                                <span class="errors-material" v-if="errors.patient">{{errors.patient[0]}}</span>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Medical Service</label>
                                <div class="col-md-12">
                                    <select class="form-control" v-model="post.medical_service">
                                        <option v-for="(ls, idx) in medical_services" :key="idx" :value="ls.id">{{ ls.description }}</option>
                                    </select>
                                </div>

                                <span class="errors-material" v-if="errors.medical_service">{{errors.medical_service[0]}}</span>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Schedule</label>
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>TIME|DAYS</th>
                                            <th>HEALTH WORKER</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(ls, idx) in schedules" :key="idx">
                                            <td>
                                                <!-- <div class="form-group"> -->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" v-model="post.schedule" :value="ls.id" :id="'schd'+ls.id">
                                                        <label class="form-check-label" :for="'schd'+ls.id">
                                                        </label>
                                                    </div>
                                                <!-- </div> -->
                                            </td>
                                            <td>{{ extractTime(ls.start_time) }} - {{  extractTime(ls.end_time)}} | {{ xtractDay(ls.day) }}</td>
                                            <td> {{ ls.healthworker.first_name}} {{ ls.healthworker.last_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <span class="errors-material" v-if="errors.schedule">{{errors.schedule[0]}}</span>
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

        <div class="modal fade absent">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Service Request</h6>
                    </div>
                    <div class="modal-body">
                       <h4>Do you want to Mark Absent?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="confirmMark()" class="btn btn-warning text-white btn-block" >Yes</button>  
                        <button type="button" @click="cancel()" class="btn btn-info text-white btn-block" >No</button>  
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import { ref } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

export default {
    components:{
        Datepicker,
        dataTable:DataTable,
        pagination:PaginationVue
    },
    setup() {
        // In case of a range picker, you'll receive [Date, Date]
        const format = (d) => {
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();

            return  month+ "-" + day  + "-" + year;
        }
        return {
            format,
        }
    },
    data(){

        let sortOrders = {};
        let columns =[
        {label:'PATIENT', name:null},
        {label:'MEDICAL SERVICES', name:null},
        {label:'SCHEDULE', name:null},
        {label:'HEALTHWORKER', name:null},
        {label:'MESSAGE', name:null},
        {label:'DATE', name:null},
        {label:'STATUS', name:null},
        {label:'ACTION', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btncap:"Save",
            post:{},
            errors:[],
            diagnosis:[],
            service_request:[],
            medical_services:[],
            schedules:[],
            patients:[],
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
        cancel(){
            $('.absent').modal('hide');
        },
        showModalAbsent(data){
            $('.absent').modal('show');
            this.post = data;
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
        // if(this.post.id > 0){
        //     this.$axios.get('sanctum/csrf-cookie').then(response=>{
        //        this.btncap = "Saving...";
        //        this.$axios.put('api/patient/'+this.post.id, this.post).then(res=>{
        //            this.btncap = "Save";
        //            this.$emit('show',{'message':'Patient has been modified!'});
        //            this.post = {};
        //            this.listOfPatient();
        //            $('.item').modal('hide');
        //        }).catch(err=>{
        //            this.btncap = "Save";
        //            this.errors = err.response.data.errors;
        //        });
        //    });
        // }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.post('api/add-service-request',this.post).then(res=>{
                   this.btncap = "Save";
                   this.post = {};
                   this.$emit('show',{'message':'Service Request has been saved!'});
                   this.listOfServices();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        // }
          
       },
        listOfServices(urls='api/service-request'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.service_request = data.data.data;
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
                this.listOfServices();
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
         formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        consultation(data){
            this.$router.push({name:'consultation', params:{'id':data.id}});
        },
        confirmMark(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.post('api/mark-absent',this.post).then(res=>{
                   this.post = {};
                   this.$emit('show',{'message':'Service Request has been mark as absent!'});
                   this.listOfServices();
                   $('.absent').modal('hide');
               });
           });
        },
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
       lisOfPatient(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/patient-list').then(res=>{
                   this.patients = res.data;
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

    },
    mounted() {
        this.listOfServices();
        this.listMedicalService();
        this.lisOfSchedule();
        this.lisOfPatient();
    },
}
</script>

<style>

</style>
