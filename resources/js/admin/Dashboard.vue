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
    </div>
</template>

<script>
export default {
    data(){
      return {
        dashdata:{}
      }
    },methods: {
      dashBoard(){
        this.$axios.get('sanctum/csrf-cookie').then(res=>{
            this.$axios.get('api/dashboard').then(res=>{
              this.dashdata = res.data;
            });
        });
      }
    },
    mounted() {
      this.dashBoard();
    },
}
</script>

<style>

</style>
