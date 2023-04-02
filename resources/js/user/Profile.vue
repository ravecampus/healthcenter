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
                <div class="card shadow-sm">
                    <div class="card-body">
                        <center class="mt-4"> 
                            <img :src="'/profile.png'" class="img-circle" width="150" />
                            <h4 class="card-title mt-2">{{ post.first_name }} {{ post.last_name }}</h4>
                            <!-- <h6 class="card-subtitle">Accoubts Manager Amix corp</h6> -->
                            <div class="row text-center justify-content-md-center">
                                <div class="col-12">
                                    <a href="#" @click="showPassword()" class="link"><i
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
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small>Personal Information:</small>
                        <form class="form-horizontal mx-2 row mt-3">
                            <div class="form-group col-6">
                                <label class="col-md-12">First name</label>
                                <div class="col-md-12">
                                    <input type="text" v-model="post.first_name" placeholder=""
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Middle name</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.middle_name"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.middle_name">{{errors.middle_name[0]}}</span>

                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Last name</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.last_name"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>

                            </div>
                            <div class="form-group col-6">
                                <label for="example-email" class="col-md-12">Gender</label>
                                <div class="col-md-12">
                                    <select class="form-control" v-model="post.gender">
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                                <span class="errors-material" v-if="errors.gender">{{errors.gender[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label for="example-email" class="col-md-12">Gender</label>
                                <div class="col-md-12">
                                    <select class="form-control" v-model="post.civil_status">
                                        <option :value="1">Single</option>
                                        <option :value="2">Married</option>
                                        <option :value="3">Legally Separated</option>
                                        <option :value="4">Annulled</option>
                                        <option :value="5">Widow/er</option>
                                    </select>
                                </div>
                                <span class="errors-material" v-if="errors.civil_status">{{errors.civil_status[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Occapation</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.occupation"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.occupation">{{errors.occupation[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Birthdate</label>
                                <div class="col-md-12">
                                    <Datepicker v-model="post.birthdate" :format="format" placeholder="Birthdate" :change="setAge()"/>
                                </div>
                                <span class="errors-material" v-if="errors.birthdate">{{errors.birthdate[0]}}</span>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Birth Place</label>
                                <div class="col-md-12">
                                    <input type="text" v-model="post.birth_place"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.birth_place">{{errors.birth_place[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Age</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.age"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.age">{{errors.age[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Contact Number</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" v-model="post.contact_number"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Purok</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Enter Purok" v-model="post.purok"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.purok">{{errors.purok[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Enter Email" v-model="post.purok"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.purok">{{errors.purok[0]}}</span>
                            </div>
                            <div class="form-group col-6">
                                <label class="col-md-12">Username</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Enter Username" v-model="post.username"
                                        class="form-control">
                                </div>
                                <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="button" @click="saveProfile()" class="btn btn-info text-white">{{ btncap }}</button>
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
                            <button type="button" @click="changePassword()" class="btn btn-info text-white btn-block" >Save</button>  
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

export default {
    components:{
        Datepicker,
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
        saveProfile(){
            if(this.post.id > 0){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap = "Processing...."
                    this.$axios.put('api/user-auth/'+this.post.id, this.post).then(res=>{
                        this.btncap = "Update Profile"
                        this.$emit('show',{'message':'Profile has been modified!'});
                        this.errors = [];
                        this.post = window.Laravel.user;
                    }).catch(err=>{
                        this.btncap = "Update Profile"
                        this.errors = err.response.data.errors
                    });
                });
            }
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
