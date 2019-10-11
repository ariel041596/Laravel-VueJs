<template>
  <div class>
    <!-- /.row -->

    <!-- div for  isAdminOrUserOrAuthor-->
    <div class="row mt-2" v-if="$gate.isAdminOrUserOrAuthor()">
      <div class="col-md-12">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box" id="totalpar">
                  <div class="inner">
                    <h3>150</h3>

                    <p>Total PAR</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <router-link to="/assets" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>
                      53
                      <!-- <sup style="font-size: 20px">%</sup> -->
                    </h3>

                    <p>Total ICS</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <router-link to="/inventory" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>44</h3>

                    <p>For Disposal</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clipboard"></i>
                  </div>
                  <router-link to="/iirup" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>65</h3>

                    <p>Disposed</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-trash"></i>
                  </div>
                  <router-link to="/assets" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                  <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">
                      <i class="fas fa-clipboard mr-1"></i>
                      Pendings
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content p-0">
                      <!-- Morris chart - Sales -->
                      <div
                        class="chart tab-pane active"
                        id="revenue-chart"
                        style="position: relative; height: 300px;"
                      ></div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- /.card -->
              </section>
              <!-- /.Left col -->
              <!-- right col (We are only adding the ID to make the widgets sortable)-->
              <section class="col-lg-5 connectedSortable">
                <!-- Calendar -->
                <div id="calendar" class="card">
                  <div id="calendar-header" class="card-header no-border">
                    <h3 class="card-title text-white">
                      <i id="calendar-icon" class="fas fa-calendar-times"></i>&nbsp;
                      Calendar
                    </h3>
                  </div>
                  <div>
                    <calendar ref="calendar" />
                  </div>
                </div>
                <!-- /.card -->
              </section>
              <!-- right col -->
            </div>
            <!-- /.row (main row) -->
          </div>
          <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
      </div>
    </div>
    <!-- end div for isAdminOrUserOrAuthor -->
    <div v-if="!$gate.isAdminOrUserOrAuthor()">
      <NotFound></NotFound>
    </div>
  </div>
</template>

<script>
import { Calendar } from "vue-sweet-calendar";
import "vue-sweet-calendar/dist/SweetCalendar.css";
export default {
  name: "app",
  data: function() {
    return {
      showDate: new Date()
    };
  },
  components: {
    Calendar
  }
};
</script>

<style scoped>
#calendar-icon {
  color: white;
}
#calendar-header {
  background: rgb(68, 83, 184);
}
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  /* color: #2c3e50; */
  height: 67vh;
  width: 90vw;
  margin-left: auto;
  margin-right: auto;
}
#totalpar {
  background-color: #15aabf;
  color: aliceblue;
}
</style>
