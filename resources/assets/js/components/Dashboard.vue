<template>
  <div class>
    <div class="row" v-if="$gate.isAdminOrUserOrAuthor()">
      <div class="col-md-12">
        <!-- Content Header (Page header) -->
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h2 class="m-0 text-dark">Dashboard</h2>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <a href="#">Home</a>
                  </li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
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
              <!-- <div class="col-lg-3 col-6">
                <div class="small-box bg-success" id="totalpar">
                  <div class="inner">
                    <p class="card-box-title">
                      <strong></strong>
                    </p>
                    <p>Total PAR</p>
                    <la-cartesian :width="250" :height="50" :data="values" id="la-cartesian">
                      <la-area animated prop="value"></la-area>
                    </la-cartesian>
                  </div>
                </div>
              </div>-->
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <div class="small-box" id="totalpar">
                  <div class="inner">
                    <h3>53</h3>
                    <p>Pendings</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <router-link to="/pendings" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box" id="return_request">
                  <div class="inner">
                    <h3>53</h3>
                    <p>Return Request</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <router-link to="/return-request" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box" id="transfer_request">
                  <div class="inner">
                    <h3>44</h3>
                    <p>Transfer Request</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-clipboard"></i>
                  </div>
                  <router-link to="/for-transfer" class="nav-link small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                  </router-link>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box" id="for_reissue">
                  <div class="inner">
                    <h3>65</h3>

                    <p>Items for Re-issue</p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-recycle"></i>
                  </div>
                  <router-link to="/for-reissue" class="nav-link small-box-footer">
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
              <section class="col-lg-8 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                  <div class="card-header no-border d-flex p-0" id="summary_header">
                    <h3 class="card-title p-2 mt-2">
                      <i class="fas fa-bars mr-1 ml-1"></i>
                      SUMMARY OF PROPERTY, PLANT AND EQUIPMENT FOR CENTRAL OFFICE
                    </h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content p-0">
                      <div class="table-responsive">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                          <div class="row">
                            <div class="col-sm-12">
                              <table
                                id="example2"
                                class="table table-bordered dataTable"
                                aria-describedby="example2_info"
                              >
                                <tbody>
                                  <tr class>
                                    <th>ACCOUNNT CODE</th>
                                    <th>ACCOUNT NAME</th>
                                    <th>TOTAL</th>
                                  </tr>
                                </tbody>
                                <tbody>
                                  <tr>
                                    <td>1-06-01-010</td>
                                    <td>LAND</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-04-010</td>
                                    <td>BUILDINGS</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-020</td>
                                    <td>OFFICE EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-030</td>
                                    <td>ICT EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-070</td>
                                    <td>COMMUNICATION EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-090</td>
                                    <td>DISASTER RESPONSE AND RESCUE EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-110</td>
                                    <td>MEDICAL EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-140</td>
                                    <td>TECHNICAL AND SCIENTIFIC EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-990</td>
                                    <td>OTHER MACHINERY AND EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-06-010</td>
                                    <td>MOTOR VEHICLES</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-07-010</td>
                                    <td>FURNITURE & FIXTURES</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-07-020</td>
                                    <td>BOOKS</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-08-01-020</td>
                                    <td>COMPUTER SOFTWARE</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-99-990</td>
                                    <td>OTHER PROPERTY, PLANT AND EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-06-990</td>
                                    <td>OTHER TRANSPORTATION EQUIPMENT</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-06-05-010</td>
                                    <td>MACHINERY</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>5-02-03-990</td>
                                    <td>OTHER SUPPLIES AND MATERIAL EXPENSES</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>1-04-04-010</td>
                                    <td>OFFICE SUPPLIES INVENTORY</td>
                                    <td>21321</td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <strong>GRAND TOTAL</strong>
                                    </td>
                                    <td colspan="2">
                                      <strong>DUMMY TOTAL</strong>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <!-- /.Left col -->
              <!-- right col (We are only adding the ID to make the widgets sortable)-->
              <section class="col-lg-4 connectedSortable">
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
                <!-- <section class="col-lg-4 connectedSortable"> -->
                <div id="time" class="card">
                  <div id="clock-header" class="card-header no-border">
                    <h3 class="card-title text-white">
                      <i id="calendar-icon" class="fas fa-clock"></i>&nbsp;
                      Time
                    </h3>
                  </div>
                  <div id="clock">
                    <p id="date_value">{{ date }}</p>
                    <p id="time_value">{{ time }}</p>
                  </div>
                </div>
                <!-- /.card -->
                <!-- </section> -->
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
import { Cartesian, Area } from "laue";
import { Calendar } from "vue-sweet-calendar";
import "vue-sweet-calendar/dist/SweetCalendar.css";

export default {
  name: "app",
  data: function() {
    return {
      time: "",
      date: "",
      // cards: [],
      assets: {},
      values: [{ value: 0 }, { value: 1 }, { value: 10 }],
      showDate: new Date()
    };
  },
  components: {
    Calendar,
    LaCartesian: Cartesian,
    LaArea: Area
  },
  methods: {
    zeroPadding(num, digit) {
      var zero = "";
      for (var i = 0; i < digit; i++) {
        zero += "0";
      }
      return (zero + num).slice(-digit);
    },
    currentTime() {
      var week = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
      var timerID = setInterval(updateTime, 1000);
    },
    updateTime() {
      var week = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];
      // var timerID = setInterval(updateTime, 1000);
      var cd = new Date();
      this.time =
        this.zeroPadding(cd.getHours(), 2) +
        ":" +
        this.zeroPadding(cd.getMinutes(), 2) +
        ":" +
        this.zeroPadding(cd.getSeconds(), 2);
      this.date =
        this.zeroPadding(cd.getFullYear(), 4) +
        "-" +
        this.zeroPadding(cd.getMonth() + 1, 2) +
        "-" +
        this.zeroPadding(cd.getDate(), 2) +
        " " +
        week[cd.getDay()];
    },
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios.get("api/asset").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
      }
    }
    // axios.get('/api/dashboard')
    // 		.then((res) => {
    // 			this.$set(this.$data, 'cards', res.data.cards)
    // 		})
  },
  created() {
    this.$Progress.start();
    this.loadAssets();
    this.updateTime();
    setInterval(() => this.updateTime(), 1000);
    this.$Progress.finish();
  }
};
</script>

<style scoped>
#clock {
  font-family: "Share Tech Mono", monospace;
  color: #000000;
  text-align: center;
  /* text-shadow: 0 0 20px rgb(5, 186, 247), 0 0 20px rgba(10, 175, 230, 0); */

  height: 100px;
  background-size: 100%;
}
#time_value {
  letter-spacing: 0.05em;
  font-size: 60px;
  padding: 5px 0;
  margin-top: 20px;
  padding: 0;
}
#date_value {
  letter-spacing: 0.1em;
  font-size: 24px;
  margin-top: 10px;
  padding: 0;
}
#calendar-icon {
  color: white;
}
#calendar-header {
  background: rgb(68, 83, 184);
}
#clock-header {
  background: rgb(68, 83, 184);
  height: 40px;
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
  background-color: #17a2b8;
  color: #ffffff;
}
#return_request {
  background-color: #28a745;
  color: #ffffff;
}
#transfer_request {
  background-color: #ffc107;
  color: #070707;
}
#for_reissue {
  background-color: #dc3545;
  color: #ffffff;
}
#summary_header {
  background-color: #4453b8;
  color: #ffffff;
}
.card-box-title {
  margin-top: 5px;
  font-size: 30px;
  font-family: Arial, Helvetica, sans-serif;
}
.content {
  margin-top: -15px;
}
table {
  padding: 0;
  font-size: 12px;
  font-family: Arial, Helvetica, sans-serif;
}
</style>
