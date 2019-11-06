<template>
  <div class id>
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrUserOrAuthor()">
      <div id="rpcppe" class="rpcppe card-header">
        <h3 class="card-title mt-1 text-white">
          <i class="fas fa-upload"></i>&nbsp;Upload Data
        </h3>
      </div>
      <section class="content mt-4">
        <div class="container-fluid">
          <div class="row">
            <section class="col-lg-4 connectedSortable">
              <div class="card card-content">
                <div class="card-header d-flex p-0">
                  <h5 class="card-box-title p-2">
                    <i class="fas fa-upload"></i>
                    Import RPCPPE or ICS
                  </h5>
                </div>
                <div class="card-body">
                  <div class="tab-content p-0">
                    <div class id style="position: relative; height: 200px;">
                      <div class="form-group">
                        <div class="col-sm-12">
                          <!-- <input
                              type="file"
                              @change="updateFile"
                              class="form-control-file"
                              name="file"
                              id="file"
                              aria-describedby="fileHelp"
                              :class="{ 'is-invalid': form.errors.has('file') }"
                          />-->
                          <small
                            id="fileHelp"
                            class="form-text text-muted"
                          >Please upload a valid CSV file. File should be formatted on tables</small>
                          <has-error :form="form" field="file"></has-error>
                        </div>
                      </div>
                      <div class="form-group">
                        <button
                          @click="newModal"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Please fill up fields"
                          class="ml-1 update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                        >
                          <i class="fas fa-upload">&nbsp;</i>RPCPPE/ICS
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
    <div v-if="!$gate.isAdminOrUserOrAuthorOrSupply()">
      <NotFound></NotFound>
    </div>
    <div
      class="modal fade bd-example-modal-sm"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Update Asset</h5>
            <button
              data-toggle="tooltip"
              data-placement="bottom"
              title="Close"
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset() : createAsset()">
            <div class="modal-body">
              <div class="form-group">
                <div class="col-sm-12">
                  <input
                    type="file"
                    @change="updateFile"
                    class="form-control-file"
                    name="file"
                    id="file"
                    aria-describedby="fileHelp"
                    :class="{ 'is-invalid': form.errors.has('file') }"
                  />
                  <small
                    id="fileHelp"
                    class="form-text text-muted"
                  >Please upload a valid CSV file. File should be formatted on tables</small>
                  <has-error :form="form" field="file"></has-error>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                data-dismiss="modal"
                class="btn-danger mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-times">&nbsp;</i>Close
              </button>
              <button
                data-toggle="tooltip"
                data-placement="bottom"
                title="Add Report on Physical Count of Property Plant and Equipment"
                v-show="!editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-upload">&nbsp;</i>Upload Data
              </button>
            </div>
          </form>
        </div>
      </div>
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
        // file: ""
      })
    };
  },
  methods: {
    newModal() {
      this.editmode = false;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
    },
    updateFile(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      if (file["size"] < 21117755) {
        reader.onloadend = file => {
          this.form.file = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        swal.fire("Opps", "Your file was too large", "error");
      }
    },
    createAsset() {
      this.$Progress.start();
      this.form
        .post("api/import_data")
        .then(() => {
          Fire.$emit("AfterCreate");
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
  }
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
