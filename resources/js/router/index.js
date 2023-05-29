import {createWebHistory, createRouter} from "vue-router";

import Home from '../page/Home';
import Login from '../page/Login';
import Signup from '../page/Signup';

import Admin from '../admin/Mainpage';
import ServiceRequest from '../admin/ServiceRequest';
import MedicalService from '../admin/MedicalService';
import HealthWorker from '../admin/HealthWorker';
import Schedule from '../admin/Schedule';
import Profile from '../admin/Profile';
import Medicine from '../admin/Medicine';
import Patient from '../admin/Patient';
import Consultation from '../admin/Consultation';
import Purok from '../admin/Purok';
import Completed from '../admin/CompletedSR';
import ViewCompleted from '../admin/ViewComplete';
import PreviousMedication from '../admin/PreviousMedication';
import Dashboard from '../admin/Dashboard';
import Users from '../admin/Users';

import User from '../user/Mainpage';
import UserProfile from '../user/Profile';
import UserRequest from '../user/Request';
import UserMedication from '../user/Medication';
import ViewMedication from '../user/ViewMedication';
import UserHome from '../user/Home';



export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'signup',
        path: '/signup',
        component: Signup,
    },
    {
        name: 'user',
        path: '/user',
        component: User,
        children:[
            {
                name:'userhome',
                path:'',
                component: UserHome,
            },
            {
                name: 'userprofile',
                path: 'profile',
                component: UserProfile,
            },
            {
                name: 'userrequest',
                path: 'request',
                component: UserRequest,
            },
            {
                name: 'usermedication',
                path: 'medication',
                component: UserMedication,
            },
            {
                name: 'userviewmedication',
                path: 'view-medication/:id',
                component: ViewMedication,
            }
        ]

    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                name: 'dashboard',
                path: '',
                component: Dashboard,
            },
            {
                name: 'users',
                path: 'users',
                component: Users,
            },
            {
                name: 'medicalservice',
                path: 'medical-service',
                component: MedicalService,
            },
            {
                name: 'purok',
                path: 'purok',
                component: Purok,
            },
            {
                name: 'servicerequest',
                path: 'service-request',
                component: ServiceRequest,
            },
            {
                name: 'healthworker',
                path: 'health-workers',
                component: HealthWorker,
            },
            {
                name: 'schedule',
                path: 'schedule',
                component: Schedule,
            },
            {
                name: 'profile',
                path: 'profile',
                component: Profile,
            },
            {
                name: 'medicines',
                path: 'medicines',
                component: Medicine,
            },
            {
                name: 'patients',
                path: 'patients',
                component: Patient,
            },
            {
                name: 'consultation',
                path: 'consultation/:id',
                component: Consultation,
            },
            {
                name: 'completed',
                path: 'report',
                component: Completed,
            },
            {
                name: 'viewcompleted',
                path: 'view-completed/:id',
                component: ViewCompleted,
            },
            {
                name: 'previousmedication',
                path: 'previous-medication/:id',
                component: PreviousMedication,
            },

        ]
    },
  
    

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const openRoutes = [
    'login',
    'signup',
    'home',
];

const userRoutes = [
    'usermedication',
    'userviewmedication',
    'user',
    'userprofile',
    'userrequest',
    'userhome'
];
const adminRoutes = [
    'admin',
    'medicalservice',
    'servicerequest',
    'healthworker',
    'schedule',
    'profile',
    'medicines',
    'patients',
    'consultation',
    'purok',
    'completed',
    'viewcompleted',
    'previousmedication',
    'dashboard',
    'users'
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && (user.role == 1 || user.role == 2)){
            return next();
        }else if(userRoutes.includes(to.name) && user.role == 0){
            return next();
        }
    }
    if(openRoutes.includes(to.name)){
        return next();
    }else{
        return next({name:'home'});
    }
    
   
});

export default router;