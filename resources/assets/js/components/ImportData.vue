<template>
  <div class id>
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrUserOrAuthor()">
      <div id="rpcppe" class="rpcppe card-header">
        <h3 class="card-title mt-1 text-white">
          <i class="fas fa-upload"></i>&nbsp;Upload Data
        </h3>
      </div>
      <section class="content mt-4">
        <div class="container-fluid">
          <div class="row">
            <!-- Left col -->
            <section class="col-lg-4 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card card-content">
                <div class="card-header d-flex p-0">
                  <h5 class="card-box-title p-2">
                    <i class="fas fa-upload"></i>
                    Import RPCPPE or ICS
                  </h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content p-0">
                    <div class id style="position: relative; height: 200px;">
                      <form @submit.prevent="createAsset()" enctype="multipart/from-data">
                        <div class="form-group">
                          <div class="col-sm-12">
                            <!-- Class name maybe -form-input -->

                            <input
                              type="file"
                              class="form-control-file"
                              name="file"
                              id="file"
                              aria-describedby="fileHelp"
                              :class="{ 'is-invalid': form.errors.has('file') }"
                            />
                            <has-error :form="form" field="file"></has-error>
                            <small
                              id="fileHelp"
                              class="form-text text-muted"
                            >Please upload a valid CSV file. File should be formatted on tables</small>
                          </div>
                        </div>
                        <div class="form-group">
                          <button
                            @click="checkForm"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Please fill up fields"
                            class="ml-1 update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                          >
                            <i class="fas fa-upload">&nbsp;</i>RPCPPE/ICS
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- /.card -->
            </section>
            <section class="col-lg-4 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card card-content">
                <div class="card-header d-flex p-0">
                  <h5 class="card-box-title p-2">
                    <i class="fas fa-upload"></i>
                    Import For Disposal (IIRUP)
                  </h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content p-0">
                    <div class id style="position: relative; height: 200px;">
                      <form @submit.prevent="createForDisposal()" enctype="multipart/from-data">
                        <div class="form-group">
                          <div class="col-sm-12">
                            <!-- Class name maybe -form-input -->
                            <input
                              type="file"
                              class="form-control-file"
                              name="file"
                              id="file"
                              aria-describedby="fileHelp2"
                              :class="{ 'is-invalid': form.errors.has('file') }"
                            />
                            <has-error :form="form" field="file"></has-error>
                            <small
                              id="fileHelp2"
                              class="form-text text-muted"
                            >Please upload a valid CSV file. File should be formatted on tables</small>
                          </div>
                        </div>
                        <div class="form-group">
                          <button
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Please fill up fields"
                            class="ml-1 update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                          >
                            <i class="fas fa-upload">&nbsp;</i>IIRUP
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- /.card -->
            </section>
            <section class="col-lg-4 connectedSortable">
              <!-- Custom tabs (Charts with tabs)-->
              <div class="card card-content">
                <div class="card-header d-flex p-0">
                  <h5 class="card-box-title p-2">
                    <i class="fas fa-upload"></i>
                    Import For Items Ready for Re-issue
                  </h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content p-0">
                    <div class id style="position: relative; height: 200px;">
                      <form @submit.prevent="createForReissue()" enctype="multipart/from-data">
                        <div class="form-group">
                          <div class="col-sm-12">
                            <!-- Class name maybe -form-input -->
                            <input
                              type="file"
                              class="form-control-file"
                              name="file"
                              id="file"
                              aria-describedby="fileHelp3"
                              :class="{ 'is-invalid': form.errors.has('file') }"
                            />
                            <has-error :form="form" field="file"></has-error>
                            <small
                              id="fileHelp3"
                              class="form-text text-muted"
                            >Please upload a valid CSV file. File should be formatted on tables</small>
                          </div>
                        </div>
                        <div class="form-group">
                          <button
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Please fill up fields"
                            class="ml-1 update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                          >
                            <i class="fas fa-upload">&nbsp;</i>For Re-issues
                          </button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- /.card -->
            </section>
          </div>
          <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- <div class="row">
        <div class="col-sm-3">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Configurations</h3>
            </div>
            <div class="box-body">
              <button
                data-toggle="tooltip"
                data-placement="bottom"
                title="Unit Price Exceeds P15,000.00"
                @click="newModal"
                class="ml-1 update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-plus">&nbsp;</i>RPCPPE
              </button>
            </div>
          </div>
        </div>
      </div>-->
    </div>
    <!-- End for Admin -->

    <!-- /.row -->
    <div v-if="!$gate.isAdminOrUserOrAuthorOrSupply()">
      <NotFound></NotFound>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
// import validate from 'validate.js'
export default {
  name: "list",
  data() {
    return {
      errors: [],
      selected: [],
      selectAll: false,
      acctMode: false,
      editmode: false,
      form: new Form({
        id: "",
        number: "",
        article: "",
        description: "",
        property_number: "",
        unit_of_measure: "",
        price: "",
        quantity: "",
        total_value: "",
        date: "",
        accountable_officer: "",
        remarks: "",
        account_name: "",
        service: "",
        createdBy: "",
        status: "",
        property_type: ""
      })
    };
  },
  computed: {},
  watch: {
    total_value: function(newValue) {
      const result = newValue
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      Vue.nextTick(() => (this.price = result));
    }
  },
  methods: {
    checkForm() {},
    createAsset() {
      this.$Progress.start();
      this.form
        .post("api/import_data")
        .then(() => {
          Fire.$emit("AfterCreate");
          // Sweet Alert message from sweetalert2
          toast.fire({
            type: "success",
            title: "Created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    }
  },

  created() {}
};
</script>

<style scoped>
.update-create {
  background: rgb(22, 70, 143);
  color: white;
  opacity: 0.9;
  margin-top: -5px;
}
.btn-danger {
  margin-top: -5px;
}
.update-create:hover {
  opacity: 1;
}

.rpcppe {
  background-color: rgb(242, 242, 242);
}
#footer {
  margin-top: -40px;
  margin-bottom: -5px;
}
#showEntries {
  padding-bottom: 10px;
}
#card-content {
  border: 1px solid #3c8dbc;
}
.card-content {
  border: 1px solid #3c8dbc;
}
#rpcppe {
  background: #3c8dbc;
  height: 50px;
}
/* #pendingAssetsVue {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
} */
.card-header {
  height: 30px;
  background: #3c8dbc;
  color: #ffffff;
}
.material-icons {
  font-size: 15px;
}
/* .form-group input:focus + label {
  color: red !important;
} */
/* .row .form-group {
} */
/* .row .form-group input:focus,
.row .form-group select:focus,
.row .form-group textarea:focus {
  border-bottom: 1px solid red !important;
  box-shadow: 0 1px 0 0 red !important;
}
.row .form-group input:focus ~ label,
.row .form-group input:valid ~ label,
.row .form-group select:focus ~ label {
  color: #3c8dbc !important;
} */
.form-control {
  border-radius: 0;
}
/* .form-group label {
  position: absolute;
  top: 0;
  left: 0;
}
.form-group input,
.form-group select {
  margin-top: 20px;
} */
#description {
  height: 160px;
}
.card-box-title {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 13px;
}
</style>
