<template>
    <div id="main-wrapper">
        <header class="topbar d-print-none">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                            <b>
                                <h4 class="dark-logo"><strong>HC</strong> &nbsp;</h4>
                            <!-- <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" /> -->
                            <!-- <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" /> -->
                        </b>
                        <span>
                            <small>Health Center</small>
                            <!-- <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-text.png" class="light-logo" alt="homepage" /> -->
                        </span>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark"
                                href="javascript:void(0)"><i class="fa fa-bars"></i></a> </li>
                        <li class="nav-item hidden-xs-down search-box">
                            <h4 class="nav-link hidden-sm-down waves-effect waves-dark">BARANGAY UGALINGAN</h4>
                             <small>Carmen, North Cotabato</small>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" @click="profile()" href=""
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    :src="'/profile.png'" alt="user" class="" /> <span
                                    class="hidden-md-down">{{ user.first_name}} {{ user.last_name }} &nbsp;</span> </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'dashboard'}" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'profile'}" aria-expanded="false"><i
                                    class="fa fa-user-circle-o"></i><span class="hide-menu">Profile</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'purok'}" aria-expanded="false"><i
                                    class="fa fa-gear"></i><span class="hide-menu">Purok</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'medicalservice'}" aria-expanded="false"><i
                                    class="fa fa-gear"></i><span class="hide-menu">Medical Service</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'medicines'}" aria-expanded="false"><i
                                    class="fa fa-medkit"></i><span class="hide-menu">Medicines</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'healthworker'}" aria-expanded="false"><i
                                    class="fa fa-users"></i><span class="hide-menu">Health Workers</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'schedule'}" aria-expanded="false"><i
                                    class="fa fa-calendar"></i><span class="hide-menu">Schedule</span></router-link>
                        </li>
                        <li> 
                            <router-link class="waves-effect waves-dark" :to="{name:'patients'}" aria-expanded="false">
                                <i class="fa fa-users"></i><span class="hide-menu">Patients</span>
                            </router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'servicerequest'}" aria-expanded="false"><i
                                    class="fa fa-user-md"></i><span class="hide-menu">Service Request</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'completed'}" aria-expanded="false"><i
                            class="fa fa-file"></i><span class="hide-menu">Report</span></router-link>
                        </li>
                         <li> <router-link class="waves-effect waves-dark" :to="{name:'users'}" aria-expanded="false"><i
                            class="fa fa-users"></i><span class="hide-menu">Users</span></router-link>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="#" @click="logout()" aria-expanded="false"><i
                                    class="fa fa-question-circle"></i><span class="hide-menu">Logout</span></a>
                        </li>
                    </ul>
                    
                </nav>
            </div>
            
        </aside>
        <flashmessage :message="message" :status="status"></flashmessage>
        <div class="page-wrapper n-pad-0">
            <router-view @show="flashMessage"></router-view>

            <footer class="footer d-print-none"> © 2023 winsdev <a href="#"></a> </footer>

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
        profile(){
            this.$router.push({name:'profile'});
        }
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
