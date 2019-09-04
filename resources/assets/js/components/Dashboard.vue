<template>
  <div class>
    <!-- /.row -->
    <div class="row mt-2">
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
                <div class="small-box bg-info">
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
                  <router-link to="/assets" class="nav-link small-box-footer">
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

                    <p>RPCPPE</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clipboard"></i>
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
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>65</h3>

                    <p>IIRUP</p>
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
                      <i class="fas fa-chart-pie mr-1"></i>
                      Sales
                    </h3>
                    <ul class="nav nav-pills ml-auto p-2">
                      <li class="nav-item">
                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                      </li>
                    </ul>
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
                      <div
                        class="chart tab-pane"
                        id="sales-chart"
                        style="position: relative; height: 300px;"
                      ></div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- TO DO List -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-clipboard mr-1"></i>
                      To Do List
                    </h3>

                    <div class="card-tools">
                      <ul class="pagination pagination-sm">
                        <li class="page-item">
                          <a href="#" class="page-link">&laquo;</a>
                        </li>
                        <li class="page-item">
                          <a href="#" class="page-link">1</a>
                        </li>
                        <li class="page-item">
                          <a href="#" class="page-link">2</a>
                        </li>
                        <li class="page-item">
                          <a href="#" class="page-link">3</a>
                        </li>
                        <li class="page-item">
                          <a href="#" class="page-link">&raquo;</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <ul class="todo-list">
                      <li>
                        <!-- drag handle -->
                        <span class="handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <!-- checkbox -->
                        <input type="checkbox" value name />
                        <!-- todo text -->
                        <span class="text">Design a nice theme</span>
                        <!-- Emphasis label -->
                        <small class="badge badge-danger">
                          <i class="far fa-clock"></i> 2 mins
                        </small>
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                        <span class="handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" value name />
                        <span class="text">Make the theme responsive</span>
                        <small class="badge badge-info">
                          <i class="far fa-clock"></i> 4 hours
                        </small>
                        <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                        <span class="handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" value name />
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-warning">
                          <i class="far fa-clock"></i> 1 day
                        </small>
                        <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                        <span class="handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" value name />
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-success">
                          <i class="far fa-clock"></i> 3 days
                        </small>
                        <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                        <span class="handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" value name />
                        <span class="text">Check your messages and notifications</span>
                        <small class="badge badge-primary">
                          <i class="far fa-clock"></i> 1 week
                        </small>
                        <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                        <span class="handle">
                          <i class="fas fa-ellipsis-v"></i>
                          <i class="fas fa-ellipsis-v"></i>
                        </span>
                        <input type="checkbox" value name />
                        <span class="text">Let theme shine like a star</span>
                        <small class="badge badge-secondary">
                          <i class="far fa-clock"></i> 1 month
                        </small>
                        <div class="tools">
                          <i class="fas fa-edit"></i>
                          <i class="fas fa-trash-o"></i>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <button type="button" class="btn btn-info float-right">
                      <i class="fas fa-plus"></i> Add item
                    </button>
                  </div>
                </div>
                <!-- /.card -->
              </section>
              <!-- /.Left col -->
              <!-- right col (We are only adding the ID to make the widgets sortable)-->
              <section class="col-lg-5 connectedSortable">
                <!-- Map card -->
                <div class="card bg-primary">
                  <div class="card-header no-border">
                    <h3 class="card-title">
                      <i class="fas fa-map-marker-alt mr-1"></i>
                      Visitors
                    </h3>
                    <!-- card tools -->
                    <div class="card-tools">
                      <button
                        type="button"
                        class="btn btn-primary btn-sm daterange"
                        data-toggle="tooltip"
                        title="Date range"
                      >
                        <i class="fas fa-calendar-times"></i>
                      </button>
                    </div>
                    <!-- /.card-tools -->
                  </div>
                  <div class="card-body">
                    <div id="world-map" style="height: 250px; width: 100%;"></div>
                  </div>
                  <!-- /.card-body-->
                  <div class="card-footer bg-transparent">
                    <div class="row">
                      <div class="col-4 text-center">
                        <div id="sparkline-1"></div>
                        <div class="text-white">Visitors</div>
                      </div>
                      <!-- ./col -->
                      <div class="col-4 text-center">
                        <div id="sparkline-2"></div>
                        <div class="text-white">Online</div>
                      </div>
                      <!-- ./col -->
                      <div class="col-4 text-center">
                        <div id="sparkline-3"></div>
                        <div class="text-white">Sales</div>
                      </div>
                      <!-- ./col -->
                    </div>
                    <!-- /.row -->
                  </div>
                </div>
                <!-- /.card -->

                <!-- Calendar -->
                <div class="card bg-success">
                  <div class="card-header no-border">
                    <h3 class="card-title">
                      <i class="fas fa-calendar-times"></i>
                      Calendar
                    </h3>
                    <calendar-view
                      id="calendar"
                      :show-date="showDate"
                      class="holiday-us-traditional holiday-us-official"
                    >
                      <calendar-view-header
                        slot="header"
                        slot-scope="t"
                        :header-props="t.headerProps"
                        @input="setShowDate"
                      />
                    </calendar-view>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body pt-0">
                    <!--The calendar -->
                    <div id="calendar" style="width: 100%"></div>
                  </div>
                  <!-- /.card-body -->
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
  </div>
</template>

<script>
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar";
require("vue-simple-calendar/static/css/default.css");
require("vue-simple-calendar/static/css/holidays-us.css");
export default {
  name: "app",
  data: function() {
    return { showDate: new Date() };
  },
  components: {
    CalendarView,
    CalendarViewHeader
  },
  methods: {
    setShowDate(d) {
      this.showDate = d;
    }
  }
};
</script>

<style scoped>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  /* color: #2c3e50; */
  height: 67vh;
  width: 90vw;
  margin-left: auto;
  margin-right: auto;
}
</style>
