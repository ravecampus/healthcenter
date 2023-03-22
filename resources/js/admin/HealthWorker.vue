<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Health Workers</h3>
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
            <div class="col-12">
                <div class="card shadow-sm">
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
                                    <label>Firstname</label>
                                    <input type="text" v-model="post.first_name" class="form-control form-control-user" placeholder="Enter Firstname">
                                    <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                </div>
                                  <div class="form-group mb-3">
                                    <label>Middlename</label>
                                    <input type="text" v-model="post.middle_name" class="form-control form-control-user" placeholder="Enter Middlename">
                                    <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Lastname</label>
                                    <input type="text" v-model="post.last_name" class="form-control form-control-user" placeholder="Enter Lastname">
                                    <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                </div>
                                   <div class="form-group mb-3">
                                    <label>Position</label>
                                    <select class="form-control" v-model="post.position">
                                        <option value="1">Nurse</option>
                                        <option value="2">Midwife</option>
                                    </select>
                                    <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Contact Number</label>
                                    <input type="text" v-model="post.contact_number" class="form-control form-control-user" placeholder="Enter Contact Number">
                                    <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span>
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
            post:{},
            errors:[],
            hworkers:[],
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
               this.$axios.put('api/health-worker/'+this.post.id, this.post).then(res=>{
                   this.btncap = "Save";
                   this.$emit('show',{'message':'Health Worker has been modified!'});
                   this.post = {};
                   this.listOfHWorker();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.post('api/health-worker', this.post).then(res=>{
                   this.btncap = "Save";
                   this.post = {};
                   this.$emit('show',{'message':'Health Worker has been saved!'});
                   this.listOfHWorker();
                   $('.item').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }
          
       },
        listOfHWorker(urls='api/health-worker'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.hworkers = data.data.data;
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
                this.listOfHWorker();
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
        }
    },
    mounted() {
        this.listOfHWorker();
    },
}
</script>

<style>

</style>
