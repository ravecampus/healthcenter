<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Patients</h3>
                <!-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active">Blank Page</li>
                </ol> -->
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
                            <input type="text" class="form-control" v-model="tableData.search" @input="listOfPatient()" placeholder="Search...">
                        </div>
                        <div class="table-responsive">
                            <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                <tbody>
                                    <tr class="tr-shadow" v-for="(list, idx) in patients" :key="idx">
                                        <td class="text-info">
                                            <strong>
                                            {{ list.last_name}}, {{ list.first_name }} {{ list.middle_name }}
                                            </strong>
                                        </td>
                                        <td>{{ extractGender(list.gender) }}</td>
                                        <td>{{ extractCS(list.civil_status) }}</td>
                                        <td>{{ list.occupation }}</td>
                                        <td>{{ formatDate(list.birthdate) }}</td>
                                        <td>{{ list.birth_place }}</td>
                                        <td>{{ list.age }}</td>
                                        <td>{{ list.contact_number }}</td>
                                        <td>{{ xtractPurok(list.purok) }}</td>
                                        <td>{{ list.email }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <button class="btn btn-info text-white btn-sm" data-toggle="tooltip" @click="editModal(list)" title="Edit">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="11" v-show="!noData(patients)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                </tbody>
                            </data-table>
                        </div>
                        <div>
                            <pagination :pagination="pagination"
                                @prev="listOfPatient(pagination.prevPageUrl)"
                                @next="listOfPatient(pagination.nextPageUrl)"
                                v-show="noData(patients)">
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade item" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Patients</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 row">
                                <div class="form-group mb-3 col-6">
                                    <label>Firstname</label>
                                    <input type="text" v-model="post.first_name" class="form-control form-control-user" placeholder="Enter Firstname">
                                    <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Middlename</label>
                                    <input type="text" v-model="post.middle_name" class="form-control form-control-user" placeholder="Enter Middlename">
                                    <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Lastname</label>
                                    <input type="text" v-model="post.last_name" class="form-control form-control-user" placeholder="Enter Lastname">
                                    <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Gender</label>
                                    <select class="form-control" v-model="post.gender">
                                        <option value="1">Male</option>
                                        <option value="2">Femle</option>
                                    </select>
                                    <span class="errors-material" v-if="errors.gender">{{errors.gender[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Civil Status</label>
                                    <select class="form-control" v-model="post.civil_status">
                                        <option :value="1">Single</option>
                                        <option :value="2">Married</option>
                                        <option :value="3">Legally Separated</option>
                                        <option :value="4">Annulled</option>
                                        <option :value="5">Widow/er</option>
                                    </select>
                                    <span class="errors-material" v-if="errors.civil_status">{{errors.civil_status[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Occupation</label>
                                    <input type="text" v-model="post.occupation" class="form-control form-control-user" placeholder="Enter Lastname">
                                    <span class="errors-material" v-if="errors.occupation">{{errors.occupation[0]}}</span>
                                </div>
                                 <div class="form-group mb-3 col-6">
                                    <label>Birthdate</label>
                                    <Datepicker v-model="post.birthdate" :format="format"  placeholder="Birthdate" :change="setAge()"/>
                                    <span class="errors-material" v-if="errors.birthdate">{{errors.birthdate[0]}}</span>
                                </div>
                                 <div class="form-group mb-3 col-6">
                                    <label>Birth Place</label>
                                    <input type="text" v-model="post.birth_place" class="form-control form-control-user" placeholder="Enter Lastname">
                                    <span class="errors-material" v-if="errors.birth_place">{{errors.birth_place[0]}}</span>
                                </div>
                                 <div class="form-group mb-3 col-6">
                                    <label>Age</label>
                                    <input type="text" v-model="post.age"  readonly class="form-control form-control-user" placeholder="Enter Contact Number">
                                    <span class="errors-material" v-if="errors.age">{{errors.age[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Contact Number</label>
                                    <input type="text" v-model="post.contact_number" class="form-control form-control-user" placeholder="Enter Contact Number">
                                    <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Purok</label>
                                    <select class="form-control" v-model="post.purok">
                                        <option v-for="(ls, idx) in puroks" :key="idx" :value="ls.id">{{ ls.purok_name }}</option>
                                    </select>
                                    <span class="errors-material" v-if="errors.purok">{{errors.purok[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Email</label>
                                    <input type="text" v-model="post.email" class="form-control form-control-user" placeholder="Enter Contact Number">
                                    <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-12 row" v-if="post.id == null">
                                <div class="form-group mb-3 col-6">
                                    <label>Username</label>
                                    <input type="text" v-model="post.username" class="form-control form-control-user" placeholder="Enter Username">
                                    <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Password</label>
                                    <input type="password" v-model="post.password" class="form-control form-control-user" placeholder="Enter Password">
                                    <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                </div>
                                <div class="form-group mb-3 col-6">
                                    <label>Password Confirmation</label>
                                    <input type="password" v-model="post.password_confirmation" class="form-control form-control-user" placeholder="Enter Password Confirmation">
                                    <!-- <span class="errors-material" v-if="errors">{{errors.password_confirmation[0]}}</span> -->
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
        {label:'FULLNAME', name:null},
        {label:'GENDER', name:null},
        {label:'CIVIL STATUS', name:null},
        {label:'OCCUPATION', name:null},
        {label:'BIRTHDATE', name:null},
        {label:'BIRTH PLACE', name:null},
        {label:'AGE', name:null},
        {label:'CONTACT NUMBER', name:null},
        {label:'PUROK', name:null},
        {label:'EMAIL', name:null},
        {label:'ACTION', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            btncap:"Save",
            post:{},
            errors:[],
            puroks:[],
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
               this.$axios.put('api/patient/'+this.post.id, this.post).then(res=>{
                   this.btncap = "Save";
                   this.$emit('show',{'message':'Patient has been modified!'});
                   this.post = {};
                   this.listOfPatient();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.post('api/patient',this.post).then(res=>{
                   this.btncap = "Save";
                   this.post = {};
                   this.$emit('show',{'message':'Patient has been saved!'});
                   this.listOfPatient();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }
          
       },
        listOfPatient(urls='api/patient'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.patients = data.data.data;
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
                this.listOfPatient();
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
       }
    },
    mounted() {
        this.listOfPatient();
        this.listPurok();
    },
}
</script>

<style>

</style>
