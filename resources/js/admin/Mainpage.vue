<template>
    <div id="main-wrapper">
        <header class="topbar">
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
                        <li class="nav-item hidden-xs-down search-box"> <a
                                class="nav-link hidden-sm-down waves-effect waves-dark" href="javascript:void(0)"><i
                                    class="fa fa-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a
                                    class="srh-btn"><i class="fa fa-times"></i></a> </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown u-pro">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href=""
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    :src="'/profile.png'" alt="user" class="" /> <span
                                    class="hidden-md-down">{{ user.first_name}} {{ user.last_name }} &nbsp;</span> </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown"></ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
    
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li> <a class="waves-effect waves-dark" href="index.html" aria-expanded="false"><i
                                    class="fa fa-tachometer"></i><span class="hide-menu">Dashboard</span></a>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'profile'}" aria-expanded="false"><i
                                    class="fa fa-user-circle-o"></i><span class="hide-menu">Profile</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'medicalservice'}" aria-expanded="false"><i
                                    class="fa fa-gear"></i><span class="hide-menu">Medical Service</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'medicines'}" aria-expanded="false"><i
                                    class="fa fa-gear"></i><span class="hide-menu">Medicines</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'healthworker'}" aria-expanded="false"><i
                                    class="fa fa-users"></i><span class="hide-menu">Health Workers</span></router-link>
                        </li>
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'schedule'}" aria-expanded="false"><i
                                    class="fa fa-calendar"></i><span class="hide-menu">Schedule</span></router-link>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="map-google.html" aria-expanded="false"><i
                                    class="fa fa-globe"></i><span class="hide-menu">Map</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="pages-blank.html" aria-expanded="false"><i
                                    class="fa fa-bookmark-o"></i><span class="hide-menu">Blank</span></a>
                        </li>
                        <li> <a class="waves-effect waves-dark" href="#" @click="logout()" aria-expanded="false"><i
                                    class="fa fa-question-circle"></i><span class="hide-menu">Logout</span></a>
                        </li>
                    </ul>
                    <div class="text-center mt-4">
                        <a href="https://www.wrappixel.com/templates/adminwrap/"
                            class="btn waves-effect waves-light btn-info hidden-md-down text-white"> Upgrade to Pro</a>
                    </div>
                </nav>
            </div>
            
        </aside>
        <flashmessage :message="message" :status="status"></flashmessage>
        <div class="page-wrapper">
            <router-view @show="flashMessage"></router-view>

            <footer class="footer"> © 2021 Adminwrap by <a href="https://www.wrappixel.com/">wrappixel.com</a> </footer>

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
