<template>
    <!-- <div class="container"> -->
        <section class="vh-100 mb-5">
            <div class="container-fluid h-custom mb-5">
                <div class="row d-flex justify-content-center align-items-center h-100">
              
                <div class="col-md-8 col-lg-8 col-xl-8 offset-xl-1">
                    <form>
                    <h3 class="text-center">{{ title }}</h3>
                    <div class="divider d-flex align-items-center my-4 mb-4">
                        <h4 class="text-center fw-bold mx-3 mb-0">SIGN UP</h4>
                    </div>
                    <div class="alert alert-danger p-0" v-if="errors.errs">
                        <div class="alert errors-material m-0">
                            <div v-if="errors.errs"><strong>*</strong>{{errors.errs[0]}}</div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.first_name" class="form-control"
                            placeholder="Enter First name" />
                            <label class="form-label" for="form3Example3">First name</label>
                            <div>
                                <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.middle_name" class="form-control"
                            placeholder="Enter Middle name" />
                            <label class="form-label" for="form3Example3">Middle name</label>
                            <div>
                                <span class="errors-material" v-if="errors.middle_name">{{errors.middle_name[0]}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.last_name" class="form-control"
                            placeholder="Enter Last name" />
                            <label class="form-label" for="form3Example3">Last name</label>
                            <div>
                                <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <select @keyup.enter="signup" v-model="post.gender" class="form-control">
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                            <label class="form-label" for="form3Example3">Gender</label>
                            <div>
                                <span class="errors-material" v-if="errors.gender">{{errors.gender[0]}}</span>
                            </div>
                        </div>
                         <div class="form-outline mb-4 col-6">
                            <select @keyup.enter="signup" v-model="post.civil_status" class="form-control">
                                <option :value="1">Single</option>
                                <option :value="2">Married</option>
                                <option :value="3">Legally Separated</option>
                                <option :value="4">Annulled</option>
                                <option :value="5">Widow/er</option>
                            </select>
                            <label class="form-label" for="form3Example3">Civil Status</label>
                            <div>
                                <span class="errors-material" v-if="errors.civil_status">{{errors.civil_status[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.occupation" class="form-control"
                            placeholder="Enter Occupation" />
                            <label class="form-label" for="form3Example3">Occupation</label>
                            <div>
                                <span class="errors-material" v-if="errors.occupation">{{errors.occupation[0]}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-outline mb-4 col-6">
                            <Datepicker v-model="post.birthdate" :format="format"  placeholder="Birthdate" :change="setAge()"/>
                            <label class="form-label" for="form3Example3">Birthdate</label>
                            <div>
                                <span class="errors-material" v-if="errors.birthdate">{{errors.birthdate[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.birth_place" class="form-control"
                            placeholder="Enter Birth Place" />
                            <label class="form-label" for="form3Example3">Birth Place</label>
                            <div>
                                <span class="errors-material" v-if="errors.birth_place">{{errors.birth_place[0]}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" readonly @keyup.enter="signup" v-model="post.age" class="form-control"
                            placeholder="Enter Contact Number">
                            <label class="form-label" for="form3Example3">Age</label>
                            <div>
                                <span class="errors-material" v-if="errors.age">{{errors.age[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.contact_number" class="form-control"
                            placeholder="Enter Contact Number">
                            <label class="form-label" for="form3Example3">Contact Number</label>
                            <div>
                                <span class="errors-material" v-if="errors.contact_number">{{errors.contact_number[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <!-- <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.purok" class="form-control"
                            placeholder="Enter Purok" /> -->
                            <select class="form-control" v-model="post.purok">
                                <option v-for="(ls, idx) in puroks" :key="idx" :value="ls.id">{{ ls.purok_name }}</option>
                            </select>
                            <label class="form-label" for="form3Example3">Purok</label>
                            <div>
                                <span class="errors-material" v-if="errors.purok">{{errors.purok[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-4 col-6">
                            <input type="text" id="form3Example3" @keyup.enter="signup" v-model="post.email" class="form-control"
                            placeholder="Enter a Email" />
                            <label class="form-label" for="form3Example3">Email</label>
                            <div>
                                <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    
                    <!-- Password input -->
                    
                    <div class="row">
                        <div class="form-outline mb-4 col-6">
                            <input type="email" id="form3Example3" @keyup.enter="signin" v-model="post.username" class="form-control"
                            placeholder="Enter a valid username" />
                            <label class="form-label" for="form3Example3">Username</label>
                            <div>
                                <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                            </div>
                        </div>
                        <div class="col-6"></div>

                        <div class="form-outline mb-3 col-6">
                            <input type="password" id="form3Example4" @keyup.enter="signin"  v-model="post.password" class="form-control"
                            placeholder="Enter password" />
                            <label class="form-label" for="form3Example4">Password</label>
                            <div>
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                        </div>
                        <div class="form-outline mb-3 col-6">
                            <input type="password" id="form3Example4" @keyup.enter="signin"  v-model="post.password_confirmation" class="form-control"
                            placeholder="Enter password confirmation" />
                            <label class="form-label" for="form3Example4">Password Confirmation</label>
                            <div>
                                <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                            </div>
                        </div>
                    </div>
                     <div class="text-center text-lg-start mt-4 pt-2 mb-5">
                            <button type="button" class="btn btn-info text-white btn-lg"
                            :disabled="btndis" @click="signup()"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ btncap }}</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Have you already account? 
                                <router-link :to="{name:'login'}"
                                class="link-danger">Login</router-link></p>
                        </div>

                    </form>
                </div>
                </div>
            </div>

        </section>
    <!-- </div> -->
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
            errors:[],
            btncap:'SUBMIT',
            btndis:false,
            title:'',
            school:{},
            puroks:[]
        }
    },
    methods:{
        signup(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap = "Submitting ...";
                this.btndis = true;
                this.$axios.post('api/auth', this.post).then(res=>{
                    this.btncap = "Submit";
                    this.btndis = false;
                    this.post = {};
                    this.$router.push({name:'login'});
                }).catch(err=>{
                    this.btncap = "Submit";
                    this.btndis = false;
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
        listPurok(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
               this.$axios.get('api/purok').then(res=>{
                   this.puroks = res.data;
               })
           });
       },
       
    },
    mounted() {
        this.listPurok();
        this.title = window.Title.app_name;
         if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            this.auth = true;
            if(user.role == 1 || user.role == 2){
                // this.$router.push({name:'dashboard'})
            }else {
            //    this.$router.push({name:'studenthome'})
			}
        }
       
    },
}
</script>

<style>

</style>
