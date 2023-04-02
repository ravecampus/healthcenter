<template>
    <div class="container-fluid">
            
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Purok</h3>
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
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(list, indx) in puroks" :key="indx">
                                        <td>{{ indx + 1 }}</td>
                                        <td>{{ list.purok_name }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" @click="editModal(list)" class="btn btn-info btn-sm text-white">
                                                    <i class="fa fa-edit"></i> Edit
                                                </button>
                                           
                                                <!-- <button type="button" @click="deleteModal(list)" class="btn btn-danger btn-sm text-white">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button> -->
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="4" v-show="!noData(puroks)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade purok" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h4>Purok</h4>
                </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label>Name</label>
                                    <input type="text" v-model="post.purok_name" class="form-control form-control-user" placeholder="Enter Purok Name">
                                    <span class="errors-material" v-if="errors.purok_name">{{errors.purok_name[0]}}</span>
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

        <div class="modal fade delete" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
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
            btncap:"Save",
            post:{},
            errors:[],
            puroks:[]

        }
    },
    methods: {
       showModal(){
           this.post = {};
           this.errors = [];
           $('.purok').modal('show');
       },
       editModal(data){
           this.post = data;
           $('.purok').modal('show');           
       },
       saveItem(){
        if(this.post.id > 0){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.put('api/purok/'+this.post.id, this.post).then(res=>{
                   this.btncap = "Save";
                   this.$emit('show',{'message':'Purok has been modified!'});
                   this.post = {};
                   this.listPurok();
                   $('.purok').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.btncap = "Saving...";
               this.$axios.post('api/purok', this.post).then(res=>{
                   this.btncap = "Save";
                   this.post = {};
                   this.$emit('show',{'message':'Purok has been saved!'});
                   this.listPurok();
                   $('.purok').modal('hide');
               }).catch(err=>{
                   this.btncap = "Save";
                   this.errors = err.response.data.errors;
               });
           });
        }
          
       },
       listPurok(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/purok').then(res=>{
                   this.puroks = res.data;
               })
           });
       },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
    },
    mounted() {
        this.listPurok();
    },
}
</script>

<style>

</style>
