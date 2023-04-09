<template>
     <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Medication</h3>
            </div>
            <div class="col-md-7 align-self-center">
                
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                <tbody>
                                    <tr class="tr-shadow" v-for="(list, idx) in medications" :key="idx">
                                        <td>{{ formatDate(list.created_at) }}</td>
                                        <td>{{ list.medical_service.description }}</td>
                                        <td>{{ list.schedule.healthworker.first_name }} {{ list.schedule.healthworker.last_name }}</td>
                                        <td>
                                            <div v-if="list.consulted != null">
                                            {{ formatDate(list.consulted.created_at) }}
                                            </div>
                                        </td>
                                        <td class="text-warning">
                                            <strong> {{ xtractStatus(list.status) }} </strong>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-info text-white btn-sm" v-if="list.status == 1" @click="viewMedication(list)" data-toggle="tooltip" title="Consult">
                                                    <i class="fa fa-eye"></i> View
                                                </button>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="11" v-show="!noData(medications)">
                                            No Result Found!
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                </tbody>
                            </data-table>
                        </div>
                        <div>
                            <pagination :pagination="pagination"
                                @prev="listOfMedication(pagination.prevPageUrl)"
                                @next="listOfMedication(pagination.nextPageUrl)"
                                v-show="noData(medications)">
                            </pagination>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
     </div>
</template>

<script>
import DataTable from '../table/DataTable';
import PaginationVue from '../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        
        let sortOrders = {};
        let columns =[
        {label:'DATE REQUESTED', name:null},
        {label:'MEDICAL SERVICES', name:null},
        {label:'CONSULTANT', name:null},
        {label:'DATE CONSULTED', name:null},
        {label:'STATUS', name:null},
        {label:'ACTION', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            medications:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            tableData:{
                length:10,
                search:'',
                draw: 0,
            },
            pagination:{
                lastPage:'',
                currentPage:'',
                total:'',
                lastPageUrl:'',
                nextPageurl:'',
                prevPageUrl:'',
                from:'',
                to:''
            }
        }
    },
    methods: {
          listOfMedication(urls='api/user-medication'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.medications = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                
                }).catch(err=>{
                
                });
            });
        },
        configPagination(data){
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key){
            if(key != null){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.listOfMedication();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        xtractStatus(num){
            return num == 0 ? "Pending" : num == 1 ?  "Completed" : num == 2 ? "Cancelled": num == 3 ? "Absent" : "";
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        viewMedication(data){
            this.$router.push({name:'userviewmedication', params:{'id':data.id}});
        },
        
    },
    mounted() {
        this.listOfMedication();
    },
}
</script>

<style>

</style>
