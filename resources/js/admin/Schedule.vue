<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Schedule</h3>
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol> -->
            </div>
            <!-- <div class="col-md-7 align-self-center">
                <button type="button" @click="showModal()" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white">
                    <i class="fa fa-plus"></i> Add Item
                </button>
            </div> -->
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4>Add Schedule</h4>
                        <hr>
                        <div class="form-group row">
                            <div class="col-3 text-right">
                                <label class="">
                                    Asigned Health Worker:
                                </label>
                               
                            </div>
                            <div class="col-6">
                                <select class="form-control form-control-sm" v-model="post.health_worker_id" @change="filterUser(post.health_worker_id)">
                                    <option v-for="(lis, idx) in healthworkers" :key="idx" :value="lis.id">{{ lis.first_name }} {{ lis.last_name}}</option>
                                </select>
                            </div>
                            <span class="errors-material" v-if="errors.health_worker_id">{{errors.health_worker_id[0]}}</span>
                        </div>
                        <div class="form-group row">
                            <div class="col-3 text-right">
                                <label>
                                   Position:
                                </label>
                               
                            </div>
                            <div class="col-6">
                                <input type="text" readonly v-model="post.position" class="form-control form-control-sm">
                            </div>
                            <span class="errors-material" v-if="errors.position">{{errors.position[0]}}</span>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-12"><strong>Day/s</strong></label>
                            <div class="col-md-8 p-0">
                                <li class="form-check form-check-inline" v-for="(ls,idx) in days" :key="idx" >
                                    <input type="checkbox" class="form-check-input"  :id="'day'+idx" v-model="post.day" :value="ls.val" >
                                    <label class="form-check-label" :for="'day'+idx">
                                        {{ ls.name }}
                                    </label>
                                    
                                </li>
                              
                                <span class="errors-material" v-if="errors.day">{{errors.day[0]}}</span>
                            </div>
                        </div>
                          <hr>
                        <div class=" row">
                            <div class="form-group col-md-6">
                                <label class="control-label">Start time:</label>
                                <Datepicker class="form-control-sm" v-model="post.start_time" :is-24="false" time-picker mode-height="120" />
                                <span class="errors-material" v-if="errors.start_time">{{errors.start_time[0]}}</span>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="control-label">End time: </label>
                                <Datepicker class="form-control-sm" v-model="post.end_time" :is-24="false" time-picker mode-height="120" />
                                <span class="errors-material" v-if="errors.end_time">{{errors.end_time[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="post.visible" :value="1" id="visible">
                                <label class="form-check-label" for="visible">
                                   Visible
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="post.visible" :value="2" id="hidden">
                                <label class="form-check-label" for="hidden">
                                   Hide
                                </label>
                            </div>
                            <span class="errors-material" v-if="errors.visible">{{errors.visible[0]}}</span>
                        </div>
                        <hr>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info text-white" @click="saveItem()">
                                <i class="fa fa-save"></i>
                                {{ btncap }}
                            </button>
                            <button type="button" class="btn btn-info text-white">
                                <i class="fa fa-file"></i>
                                New
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <!-- <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title">List of Items</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="table-responsive">
                            <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                <tbody>
                                    <tr class="tr-shadow" v-for="(list, idx) in hworkers" :key="idx">
                                        <td class="text-info">
                                            <strong>
                                            {{ list.last_name}}, {{ list.first_name }} {{ list.middle_name }}
                                            </strong>
                                        </td>
                                        <td>{{ extractPostion(list.position) }}</td>
                                        <td>{{ list.contact_number }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="btn btn-info text-white btn-sm" data-toggle="tooltip" @click="editModal(list)" title="Edit">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="4" v-show="!noData(hworkers)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                </tbody>
                            </data-table>
                            <div>
                                <pagination :pagination="pagination"
                                    @prev="listOfHWorker(pagination.prevPageUrl)"
                                    @next="listOfHWorker(pagination.nextPageUrl)"
                                    v-show="noData(hworkers)">
                                </pagination>
                            </div>

                        </div>
                    </div>
                </div> -->
            </div>
        </div>

    
        <!-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List of Items</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, indx) in medical_services" :key="indx">
                                        <td>{{ indx + 1 }}</td>
                                        <td>{{ list.description }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" @click="editModal(list)" class="btn btn-info btn-sm text-white">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="4" v-show="!noData(medical_services)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="modal fade medical-service" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Medical Service</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Description</label>
                                    <input type="text" v-model="post.description" class="form-control form-control-user" placeholder="Enter Description">
                                    <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span>
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
    data(){
        let sortOrders = {};
        let columns =[
        {label:'Fullname', name:null},
        {label:'Position', name:null},
        {label:'Contact Number', name:null},
        {label:'Action', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btncap:"Save",
            post:{
                day:[]
            },
            errors:[],
            healthworkers:[],
            days:[
                {'name':'M - Monday', 'val':1},
                {'name':'T - Tuesday', 'val':2},
                {'name':'W - Wednesday', 'val':3},
                {'name':'TH - Thursday', 'val':4},
                {'name':'F - Friday', 'val':5},
                {'name':'S - Saturday', 'val':6},
            ],
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
   
       saveItem(){
        this.post.days = JSON.stringify(this.post.day);
        console.log(this.post)
        // if(this.post.id > 0){
        //     this.$axios.get('sanctum/csrf-cookie').then(response=>{
        //        this.btncap = "Saving...";
        //        this.$axios.put('api/medical-service/'+this.post.id, this.post).then(res=>{
        //            this.btncap = "Save";
        //            this.$emit('show',{'message':'Medical Service has been modified!'});
        //            this.post = {};
        //            this.listMedicalService();
        //            $('.medical-service').modal('hide');
        //        }).catch(err=>{
        //            this.btncap = "Save";
        //            this.errors = err.response.data.errors;
        //        });
        //    });
        // }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.post('api/schedule', this.post).then(res=>{
                   this.btncap = "Save";
                   this.post = {};
                   this.$emit('show',{'message':'Schedule has been saved!'});
                //    this.listMedicalService();
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        // }
          
       },
       listOfSchedule(urls='api/schedule'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.schedules = data.data.data;
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
                this.listOfSchedule();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },

        listHealthWorker(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/list-health-worker').then(res=>{
                   this.healthworkers = res.data;
               })
           });
        },
        filterUser(id){
                this.healthworkers.forEach(val => {
                    if(id == val.id){
                        this.post.position = this.extractPostion(val.position);
                    }
                });
        },
        extractPostion(num){
            return num == 1 ? "Nurse" : "Midwife";
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

    },
    mounted() {
        // this.listMedicalService();
        this.listHealthWorker();
    },
}
</script>

<style>

</style>
