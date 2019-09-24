<template>
  <!-- For Employee -->
  <div class="card row mt-4" v-if="$gate.isEmployee()">
    <div class="rpcppe card-header">
      <h3 class="card-title mt-2">
        List of Accountabilities
        <!-- <button class="update-create btn float-right" @click="newModal">
            <i class="fas fa-code">&nbsp;</i>Add User Type
        </button>-->
      </h3>
    </div>

    <!-- /.card-header -->
    <div class="card-body table-responsive">
      <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <div class="row">
          <div class="col-sm-12 col-md-6"></div>
          <div class="col-sm-12 col-md-6"></div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <table
              id="example2"
              class="table table-bordered table-hover dataTable"
              role="grid"
              aria-describedby="example2_info"
            >
              <tbody></tbody>
              <tbody>
                <tr class>
                  <!-- <th>ID</th> -->
                  <th>Article</th>
                  <th>Description</th>
                  <th>Property Number</th>
                  <th>Unit</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total Value</th>
                  <th>Date</th>
                  <th>Remarks</th>
                </tr>
              </tbody>
              <tbody>
                <template v-if="assets.data<=0">
                  <tr>
                    <td colspan="15" class="text-center">No Accountability Available</td>
                  </tr>
                </template>
                <template v-else>
                  <tr v-for="asset in assets.data" :key="asset.id">
                    <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                    <!-- <td>{{asset.id}}</td> -->
                    <td>{{asset.article | upText}}</td>
                    <td>{{asset.description | upText}}</td>
                    <td>{{asset.property_number}}</td>
                    <td>{{asset.unit_of_measure}}</td>
                    <td class="text-right">{{asset.price | numberComma }}</td>
                    <td class="text-center">{{asset.quantity | numberComma}}</td>
                    <td class="text-right">{{asset.total_value | numberComma}}</td>
                    <td>{{asset.date | myDate}}</td>
                    <td>{{asset.remarks | upText}}</td>
                  </tr>
                </template>
              </tbody>
            </table>
            <div>
              <pagination :data="assets" @pagination-change-page="getResults" align="center"></pagination>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- End for Employee -->
</template>

<script>
// import { Calendar } from "vue-sweet-calendar";
// import "vue-sweet-calendar/dist/SweetCalendar.css";
export default {
  name: "empdashboard",
  data() {
    return {
      assets: {}
    };
  },
  components: {
    // Calendar
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/accountabilities?page=" + page).then(response => {
        this.assets = response.data;
      });
    },
    setShowDate(d) {
      this.showDate = d;
    },
    loadAssets() {
      if (this.$gate.isEmployee()) {
        axios
          .get("api/accountabilities")
          .then(({ data }) => (this.assets = data));
      }
    }
  },

  created() {
    this.loadAssets();
  }
};
</script>