<template>
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Profile</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <!-- <a href="https://www.wrappixel.com/templates/adminwrap/"
                    class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down text-white"> Upgrade to
                    Pro</a> -->
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <center class="mt-4"> 
                            <img :src="'/profile.png'" class="img-circle" width="150" />
                            <h4 class="card-title mt-2">{{ post.first_name }} {{ post.last_name }}</h4>
                            <!-- <h6 class="card-subtitle">Accoubts Manager Amix corp</h6> -->
                            <div class="row text-center justify-content-md-center">
                                <div class="col-12">
                                    <a href="" class="link"><i
                                            class="fa fa-lock"></i>
                                        <font class="font-medium"> 
                                            Change Password</font>
                                    </a></div>
                                <!-- <div class="col-4"><a href="javascript:void(0)" class="link"><i
                                            class="fa fa-camera"></i>
                                        <font class="font-medium">54</font>
                                    </a></div> -->
                            </div>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material mx-2 row">
                            <div class="form-group col-6">
                                <label class="col-md-12">First name</label>
                                <div class="col-md-12">
                                    <input type="text" v-model="post.first_name" placeholder=""
                                        class="form-control form-control-line">
                                </div>
                                <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Middle name</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.middle_name"
                                        class="form-control form-control-line">
                                </div>
                                <span class="errors-material" v-if="errors.middle_name">{{errors.middle_name[0]}}</span>

                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Last name</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.last_name"
                                        class="form-control form-control-line">
                                </div>
                                <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>

                            </div>
                            <div class="form-group col-12">
                                <label for="example-email" class="col-md-12">Position</label>
                                <div class="col-md-12">
                                    <select class="form-control form-control-line" v-model="post.position">
                                        <option value="1">Nurse</option>
                                        <option value="2">Midwife</option>
                                    </select>
                                </div>
                                <span class="errors-material" v-if="errors.position">{{errors.position[0]}}</span>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Contact Number</label>
                                <div class="col-md-12">
                                    <input type="text"
                                        class="form-control form-control-line">
                                </div>
                                <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button class="btn btn-success">{{ btncap }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal fade change-pass">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6>Change Password</h6>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" v-model="pass.password" class="form-control" placeholder="New Password">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" v-model="pass.password_confirmation" class="form-control" placeholder="Password Confirmation">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="changePassword()" class="btn btn-primary btn-block" >Save</button>  
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
            pass:{}, 
            errors:[],
            teachers:[],
            auth:false,
            btncap:"Update Profile",
        }
    },
    methods: {
        showPassword(){
            this.pass.id = this.post.id;
            $('.change-pass').modal('show');
        },
        changePassword(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    // this.btncap = "Saving..."
                    this.$axios.post('api/auth-password/',this.pass).then(res=>{
                        this.pass = { };
                        // this.$emit('show',{'message':'Password has been changed!'});
                         $('.change-pass').modal('hide');
                        this.errors = [];
                        this.post = window.Laravel.user;
                    }).catch(err=>{
                        // this.btncap = "Save Changes"
                        this.errors = err.response.data.errors
                    });
                });
        }
   
        
    },
    mounted(){
        if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            this.post = user;
        }
    }
}
</script>

<style>

</style>
