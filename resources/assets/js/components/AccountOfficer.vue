<template>
  <div class>
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div id="rpcppe" class="card-header">
        <!-- <button class="update-create btn float-right" @click="newModal">
          <i class="fas fa-user-plus">&nbsp;</i>Add Accountable Officer
        </button>-->
        <button
          @click="newModal"
          class="update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        >
          <i class="fas fa-user-plus">&nbsp;</i> Accountable Officer
        </button>
        <h3 class="card-title mt-1 text-white">Accountable Officers</h3>
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
                class="table table-bordered dataTable"
                role="grid"
                aria-describedby="example2_info"
              >
                <tbody>
                  <tr class>
                    <!-- <th>ID</th> -->
                    <!-- <th>
                      <input type="checkbox" v-model="selectAll" @click="select" />
                    </th>-->
                    <th class="text-center">ID</th>
                    <th>Full Name (Surname, First Name, M.I)</th>
                    <th>Designation</th>
                    <th>Service</th>
                    <th>Actions</th>
                  </tr>
                </tbody>
                <tbody>
                  <!-- <template v-if="!assets.data.length">
                    <tr>
                      <td colspan="15" class="text-center">No Properties Available</td>
                    </tr>
                  </template>-->
                  <!-- <template v-else> -->
                  <tr v-for="officer in accountable_officers.data" :key="officer.id">
                    <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                    <!-- <td>{{asset.id}}</td> -->

                    <!-- <td>
                      <input type="checkbox" :value="officer.id" v-model="selected" />
                    </td>-->
                    <td class="text-center">{{officer.id}}</td>
                    <td>{{officer.name}}</td>
                    <td>{{officer.designation}}</td>
                    <td>{{officer.service}}</td>
                    <td>
                      <!-- See for the function of edits and Deletes -->
                      <a
                        class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                        href="#"
                        @click="editModal(officer)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Edit"
                      >
                        <i class="material-icons fas fa-pen"></i>
                      </a>
                      <a
                        class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                        href="#"
                        @click="deleteAccountableOfficer(officer.id)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Disposed"
                      >
                        <i class="material-icons fas fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                  <!-- </template> -->
                </tbody>
              </table>
              <div>
                <pagination
                  :data="accountable_officers"
                  @pagination-change-page="getResults"
                  align="center"
                ></pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- End for Admin -->

    <!-- /.row -->
    <div v-if="!$gate.isAdminOrAuthor()">
      <NotFound></NotFound>
    </div>
    <!-- Modal -->
    <!-- Add bd-example-modal-lg for LARGE size modal and modal-lg for the second div-->
    <div
      class="modal fade bd-example-modal-lg"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5
              v-show="!editmode"
              class="modal-title"
              id="addNewModalLabel"
            >Add New Accountable Officer</h5>
            <h5
              v-show="editmode"
              class="modal-title"
              id="addNewModalLabel"
            >Update Accountable Officer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAccountableOfficer() : createAcctableOfficer()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>Full Name (Last Name, First Name, M.I.)</label>
                  <input
                    v-model="form.name"
                    type="text"
                    id="name"
                    placeholder="Full Name (Last Name, First Name, M.I.)"
                    name="name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Service</label>
                  <input
                    v-model="form.service"
                    type="text"
                    id="service"
                    placeholder="Enter service"
                    name="service"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('service') }"
                  />
                  <has-error :form="form" field="service"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Designation</label>
                  <input
                    v-model="form.designation"
                    type="text"
                    id="designation"
                    placeholder="Enter designation"
                    name="designation"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('designation') }"
                  />
                  <has-error :form="form" field="designation"></has-error>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times">&nbsp;</i>Close
              </button>-->
              <button
                data-dismiss="modal"
                class="btn-danger mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-times">&nbsp;</i>Close
              </button>
              <!-- <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update Accountable Officer
              </button>-->
              <button
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen">&nbsp;</i>Update User
              </button>
              <!-- <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-user-plus">&nbsp;</i>Add Accountable Officer
              </button>-->
              <button
                v-show="!editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-user-plus">&nbsp;</i> Accountable Officer
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Div for errors -->
      <div class="errors" v-if="errors">
        <ul>
          <li v-for="(fieldError, fieldName) in errors" :key="fieldName">
            <strong>{{ fieldName }}</strong>
            {{ fieldError.join('\n') }}
          </li>
        </ul>
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
      errors: null,
      selected: [],
      selectAll: false,
      acctMode: false,
      editmode: false,
      accountable_officers: {},
      form: new Form({
        id: "",
        name: "",
        designation: "",
        service: ""
      })
    };
  },
  methods: {
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let asset in this.assets.data) {
          this.selected.push(this.assets.data[asset].id);
        }
      }
    },
    getResults(page = 1) {
      axios.get("api/accountable_officer?page=" + page).then(response => {
        this.accountable_officers = response.data;
      });
    },
    updateAccountableOfficer() {
      this.$Progress.start();
      this.form
        .put("api/accountable_officer/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          toast.fire({
            type: "success",
            title: "Updated Successfully"
          });
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    deleteAccountableOfficer(id) {
      swal
        .fire({
          title: "Deleted successfully",
          text: "You wont be able to revert this",
          type: "warning",
          showCancelButton: "true",
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#33",
          confirmButtonText: "Delete"
        })
        .then(result => {
          // send request to the server
          if (result.value) {
            this.form
              .delete("api/accountable_officer/" + id)
              .then(() => {
                this.$Progress.start();
                swal.fire("Deleted", "Your file has been deleted", "success");
                Fire.$emit("AfterCreate");
                this.$Progress.finish();
              })
              .catch(() => {
                this.$Progress.fail();
              });
          }
        });
    },
    // Show modal and hide
    editModal(accountable_officer) {
      this.editmode = true;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
      this.form.fill(accountable_officer);
    },
    // Show modal and hide
    newModal() {
      this.editmode = false;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
    },
    //Delete User method
    deleteAccountableOfficer(id) {
      swal
        .fire({
          title: "Deleted successfully",
          text: "You wont be able to revert this",
          type: "warning",
          showCancelButton: "true",
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#33",
          confirmButtonText: "Delete"
        })
        .then(result => {
          // send request to the server
          if (result.value) {
            this.form
              .delete("api/accountable_officer/" + id)
              .then(() => {
                this.$Progress.start();
                swal.fire("Deleted", "Your file has been deleted", "success");
                Fire.$emit("AfterCreate");
                this.$Progress.finish();
              })
              .catch(() => {
                this.$Progress.fail();
              });
          }
        });
    },
    // LoadUser to display in the tbody
    loadAccountableOfficers() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios
          .get("api/accountable_officer")
          .then(({ data }) => (this.accountable_officers = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    createAcctableOfficer() {
      // Progressbar before create user
      this.$Progress.start();
      this.form
        .post("api/accountable_officer")
        .then(() => {
          // Custom event to fire

          Fire.$emit("AfterCreate");
          // Sweet Alert message from sweetalert2
          toast.fire({
            type: "success",
            title: "Created successfully"
          });
          this.$Progress.finish();
          // Hide modal
          $("#addNew").modal("hide");
        })
        .catch(() => {
          this.$Progress.fail();
          swal("Failed", "There was something wrong", "warning");
        });
    }
  },

  created() {
    this.loadAccountableOfficers();
    Fire.$on("AfterCreate", () => {
      this.loadAccountableOfficers();
    });
  }
  // mounted() {
  //   axios.get("api/accountable_officer").then(response => {
  //     this.accountable_officers = response.data;
  //   });
  // }
};
</script>

<style scoped>
.update-create {
  background: rgb(22, 70, 143);
  color: white;
  opacity: 0.9;
  margin-top: -5px;
}
.update-create:hover {
  opacity: 1;
}
.modal-close-button {
  color: white;
}
.modal-header {
  background: rgb(22, 70, 143);
  color: aliceblue;
}
#description {
  height: 100px;
}
@media screen {
  #print {
    display: none;
  }
}

@media print {
  body * {
    visibility: hidden;
  }
  #print,
  #print * {
    visibility: visible;
  }
  #print {
    position: absolute;
    left: 0;
    top: 0;
  }
}

.widget-user-header {
  background-position: center center;
  background-size: contain;
  height: 130px !important;
  width: 100%;
  background-repeat: no-repeat;
}
.widget-user {
  padding: 0;
}

#card-content {
  border: 1px solid #3c8dbc;
}
#rpcppe {
  background: #3c8dbc;
  height: 50px;
}
.btn-danger {
  margin-top: -5px;
}
.material-icons {
  font-size: 15px;
}
</style>


// Command for this (npm run watch && php artisan serve)
