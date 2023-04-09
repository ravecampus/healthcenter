<template>
    <div id="main-wrapper">
        <header class="topbar d-print-none">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <b>
                            <h4 class="dark-logo"><strong>HC</strong> &nbsp;</h4>
                        </b>
                        <span>
                            <small>Health Center</small>
                        </span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                href="javascript:void(0)"><i class="fa fa-bars"></i></a> </li>
                        <li class="hidden-xs-down search-box"> 
                            <h4 class="nav-link hidden-sm-down waves-effect waves-dark">BARANGAY UGALINGAN</h4>
                             <small>Carmen, North Cotabato</small>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    :src="'/profile.png'" alt="user" class="" /> <span
                                    class="hidden-md-down">{{ user.first_name}} {{ user.last_name }} &nbsp;</span> </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item">
                                    <a href="#" @click="logout()">Logout</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    
        <aside class="left-sidebar d-print-none">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'userhome'}" aria-expanded="false"><i
                                    class="fa fa-home"></i><span class="hide-menu">Home</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'userprofile'}" aria-expanded="false"><i
                                    class="fa fa-user-circle-o"></i><span class="hide-menu">Profile</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'userrequest'}" aria-expanded="false"><i
                                    class="fa fa-send"></i><span class="hide-menu">Request</span></router-link>
                        </li>
                       <li> <router-link class="waves-effect waves-dark" :to="{name:'usermedication'}" aria-expanded="false"><i
                                    class="fa fa-medkit"></i><span class="hide-menu">Medication</span></router-link>
                        </li>
                    </ul>
                    
                </nav>
            </div>
            
        </aside>
        <flashmessage :message="message" :status="status"></flashmessage>
        <div class="page-wrapper n-pad-0">
            <router-view @show="flashMessage"></router-view>

            <footer class="footer d-print-none"> © 2023 winsdev<a href="#"></a> </footer>

        </div>
    </div>

</template>

<script>
import FlashMessage from '../page/FlashMessage.vue';
export default {
    components:{
        flashmessage: FlashMessage,
    },
    data(){
        return{
            message:"",
            status:0,
            user:{},
            title:""
        }
    },
    methods:{
        flashMessage(data){
                this.showMessage(data)
        },
        showMessage(data){
                this.message = data.message;
                $('.fm-body').show();
                setTimeout(() => {
                    $('.fm-body').fadeOut("slow");
                }, 700);
        },
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
    },
    mounted(){
        this.title = window.Title.app_name;
        if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            this.user = user;
        }
    }
}
</script>

<style>

</style>
