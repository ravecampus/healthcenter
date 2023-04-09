<template>
    <div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                            <b>
                                <h4 class="dark-logo"><strong>HC</strong> &nbsp;</h4>
                            <!-- <img src="assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
                            <img src="assets/images/logo-light-icon.png" alt="homepage" class="light-logo" /> -->
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
                        <li> <router-link class="waves-effect waves-dark" :to="{name:'login'}" aria-expanded="false">
                                <i class="fa fa-sign-in"></i><span class="hide-menu">Login</span>
                            </router-link>
                        </li>
                        <li> 
                            <router-link class="waves-effect waves-dark" :to="{name:'signup'}" aria-expanded="false">
                                <i class="fa fa-registered"></i><span class="hide-menu">Register</span>
                            </router-link>
                        </li>
                       
                    </ul>
                   
                </nav>
            </div>
            
        </aside>
        
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row d-flex justity-content-between">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img :src="'../cover.jpg'"
                        class="img-fluid" alt="Sample image">
                    </div>
                </div>
            </div>

            <footer class="footer"> © 2023 winsdev <a href="#"></a> </footer>

        </div>
    </div>

</template>

<script>
export default {
    data(){
        return{

        }
    },
    mounted() {
        if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            if(user.role == 1 || user.role == 2){
                this.$router.push({name:'admin'})
            }else {
                this.$router.push({name:'user'})
            }
        }
        
    },
}
</script>

<style>

</style>
