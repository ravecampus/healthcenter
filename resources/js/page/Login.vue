<template>
    <!-- <div class="container"> -->
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img :src="'../cover.jpg'"
                    class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form>
                    <h3 class="text-center">{{ title }}</h3>
                    <div class="divider d-flex align-items-center my-4">
                        <h4 class="text-center fw-bold mx-3 mb-0">SIGN IN</h4>
                    </div>
                    <div class="alert alert-danger p-0" v-if="errors.errs">
                        <div class="alert errors-material m-0">
                            <div v-if="errors.errs"><strong>*</strong>{{errors.errs[0]}}</div>
                        </div>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="form3Example3" @keyup.enter="login" v-model="post.username" class="form-control form-control-lg"
                        placeholder="Enter a valid username" />
                        <label class="form-label" for="form3Example3">Username</label>
                        <div>
                            <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                        </div>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input type="password" id="form3Example4" @keyup.enter="login"  v-model="post.password" class="form-control form-control-lg"
                        placeholder="Enter password" />
                        <label class="form-label" for="form3Example4">Password</label>
                        <div>
                            <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Checkbox -->
                        <div class="form-check mb-0">
                        <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3" />
                        <label class="form-check-label" for="form2Example3">
                            Remember me
                        </label>
                        </div>
                        <!-- <a href="#!" class="text-body">Forgot password?</a> -->
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="button" class="btn btn-info text-white btn-lg"
                        :disabled="btndis" @click="login()"
                        style="padding-left: 2.5rem; padding-right: 2.5rem;">{{ btncap }}</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? 
                            <router-link :to="{name:'signup'}"
                            class="link-danger">Register</router-link></p>
                    </div>

                    </form>
                </div>
                </div>
            </div>

        </section>
    <!-- </div> -->
</template>

<script>
export default {
      data(){
        return{
            post:{},
            errors:[],
            btncap:'SIGN IN',
            btndis:false,
            title:'',
            school:{}
        }
    },
    methods:{
        login(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true;
                this.btncap = "SIGNING..."
                this.$axios.post('api/auth-signin', this.post).then(res=>{
                    this.btndis = false;
                    let data = res.data;
                    if(data.role == 1 ||data.role == 2){
                        window.location.href="/admin";
                    }else{
                        window.location.href="/student";
                    }
                    this.btncap = "SIGN IN";
                }).catch(err=>{
                    this.btndis = false;
                    this.btncap = "SIGN IN";
                    this.errors = err.response.data.errors
                });
            });
        },
       
    },
    mounted() {
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
