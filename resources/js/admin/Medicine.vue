<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Medicines</h3>
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
                        </div>
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
            medicines:[],
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
    },
}
</script>

<style>

</style>
