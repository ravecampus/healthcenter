<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 col-md-6">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="d-flex p-10 no-block">
                    <div class="align-self-center display-6 m-r-20">
                      <i class="text-info fa fa-users"></i>
                    </div>
                    <div class="align-slef-center">
                      <h2 class="m-b-0">
                        {{dashdata.patient }}
                        <small><i class="ti-angle-down text-danger"></i></small>
                      </h2>
                      <h6 class="text-muted m-b-0">Patients</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="d-flex p-10 no-block">
                    <div class="align-self-center display-6 m-r-20">
                      <i class="text-primary fa fa-home"></i>
                    </div>
                    <div class="align-slef-center">
                      <h2 class="m-b-0">
                        {{ dashdata.purok }}
                        <small><i class="ti-angle-down text-danger"></i></small>
                      </h2>
                      <h6 class="text-muted m-b-0">Puroks</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6">
              <div class="card shadow-sm">
                <div class="card-body">
                  <div class="d-flex p-10 no-block">
                    <div class="align-self-center display-6 m-r-20">
                      <i class="text-warning fa fa-user-md"></i>
                    </div>
                    <div class="align-slef-center">
                      <h2 class="m-b-0">
                        {{ dashdata.hworker }}
                        <small><i class="ti-angle-down text-danger"></i></small>
                      </h2>
                      <h6 class="text-muted m-b-0">Health Workers</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>


        </div>
        <div class="row">
          <div class="col-12">
              <div class="card shadow">
                <div class="card-body ">
                  <h4>Service Request</h4>


                  <div class="table-responsive">
                      <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                          <tbody>
                              <tr class="tr-shadow" v-for="(list, idx) in service_request" :key="idx">
                                  <td>
                                      <div class="btn-group">
                                          <button class="btn btn-info text-white btn-sm" @click="consultation(list)" data-toggle="tooltip" title="Consult">
                                              <i class="fa fa-user-md"></i> Consultation
                                          </button>
                                            <!-- <button class="btn btn-warning text-white btn-sm" @click="showModalAbsent(list)" data-toggle="tooltip" title="Consult">
                                              <i class="fa fa-times"></i> Absent
                                          </button>
                                          <button class="btn btn-danger text-white btn-sm" @click="cancelService(list)" data-toggle="tooltip" title="Consult">
                                              <i class="fa fa-times"></i> Cancel
                                          </button> -->
                                      </div>
                                  </td>
                                  <td class="text-info">
                                      <strong>
                                      {{ list.last_name}}, {{ list.first_name }} {{ list.middle_name }}
                                      </strong>
                                  </td>
                                  <td>{{ list.medical_service.description }}</td>
                                  <td>{{extractTime(list.schedule.start_time) }} - {{ extractTime(list.schedule.end_time) }} |  {{xtractDay(list.schedule.day)}}, {{ formatDate(list.schedule.schedule_date)}}</td>
                                  <td>{{ list.schedule.healthworker.first_name }} {{ list.schedule.healthworker.last_name }}</td>
                                  <td>{{ list.message }}</td>
                                  <td>{{ formatDate(list.created_at) }}</td>
                                  <!-- <td class="text-warning">
                                      <strong> {{ xtractStatus(list.status) }} </strong>
                                  </td> -->
                              </tr>
                              <tr> 
                                  <td colspan="11" v-show="!noData(service_request)">
                                      No Result Found!
                                  </td>
                              </tr>
                              <tr class="spacer"></tr>
                          </tbody>
                      </data-table>
                  </div>
                  <div>
                      <pagination :pagination="pagination"
                          @prev="listOfServices(pagination.prevPageUrl)"
                          @next="listOfServices(pagination.nextPageUrl)"
                          v-show="noData(service_request)">
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
        {label:'ACTION', name:null},
        {label:'PATIENT', name:null},
        {label:'MEDICAL SERVICES', name:null},
        {label:'SCHEDULE', name:null},
        {label:'HEALTHWORKER', name:null},
        {label:'MESSAGE', name:null},
        {label:'DATE', name:null},
        // {label:'STATUS', name:null},
      
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
      return {
        dashdata:{},
        service_request:[],
        columns:columns,
        sortOrders:sortOrders,
        sortKey:'created_at',
        tableData:{
            draw:0,
            length:10,
            search:'',
            column:0,
            archive:0,
            dir:'desc',
            filter:1,
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
        },

      }
    },
    methods: {
      dashBoard(){
        this.$axios.get('sanctum/csrf-cookie').then(res=>{
            this.$axios.get('api/dashboard').then(res=>{
              this.dashdata = res.data;
            });
        });
      },
      listOfServices(urls='api/service-request'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.service_request = data.data.data;
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
                this.listOfServices();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
                 extractTime(time){
          // Check correct time format and split into components
            time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

            if (time.length > 1) { // If time format correct
                time = time.slice (1);  // Remove full string match value
                time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                time[0] = +time[0] % 12 || 12; // Adjust hours
            }
            return time.join (''); // return adjusted time or original string
        },
        xtractDay(data){
            let data_ = JSON.parse(data);
            let txt = "";
            data_.sort((a, b) => a - b);
            data_.forEach(val=>{
                if(val == 1){
                    txt += "M";
                }
                if(val==2){
                    txt += "T";
                }
                if(val==3){
                    txt += "W";
                }
                if(val==4){
                    txt += "TH";
                }
                if(val==5){
                    txt += "F";
                }
                if(val==6){
                    txt += "S";
                }
            });

            return txt;
        },
         formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        xtractStatus(num){
            return num == 0 ? "Pending" : num == 1 ?  "Completed" : num == 2 ? "Cancelled": num == 3 ? "Absent" : "";
        },
        consultation(data){
            this.$router.push({name:'consultation', params:{'id':data.id}});
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },

    },
    mounted() {
      this.dashBoard();
      this.listOfServices();
    },
}
</script>

<style>

</style>
