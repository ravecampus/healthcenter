import {createWebHistory, createRouter} from "vue-router";

import Home from '../page/Home';

import Admin from '../admin/Mainpage';
import ServiceRequest from '../admin/ServiceRequest';
import MedicalService from '../admin/MedicalService';
import HealthWorker from '../admin/HealthWorker';
import Schedule from '../admin/Schedule';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,

    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                name: 'medicalservice',
                path: 'medical-service',
                component: MedicalService,
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
            }
        ]
    },
  
    

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const openRoutes = [
    'home',
    'admin',
    'medicalservice',
    'servicerequest',
    'healthworker',
    'schedule',
    
];

const userRoutes = [

    
   
];
const adminRoutes = [

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