<template>
  <div class>
    <!-- For Admin -->
    <div class="card row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div class="rpcppe card-header">
        <h3 class="card-title mt-2">
          Account Codes
          <button class="update-create btn float-right" @click="newModal">
            <i class="fas fa-code">&nbsp;</i>Add Account Code
          </button>
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
                <tbody>
                  <tr class>
                    <!-- <th>ID</th> -->
                    <th>
                      <input type="checkbox" v-model="selectAll" @click="select" />
                    </th>
                    <th>ID</th>
                    <th>Account Code</th>
                    <th>Account Name</th>
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
                  <tr v-for="code in account_codes.data" :key="code.id">
                    <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                    <!-- <td>{{asset.id}}</td> -->

                    <td>
                      <input type="checkbox" :value="code.id" v-model="selected" />
                    </td>
                    <td>{{code.id}}</td>
                    <td>{{code.account_code}}</td>
                    <td>{{code.account_name}}</td>
                    <td>
                      <!-- See for the function of edits and Deletes -->
                      <a
                        href="#"
                        @click="editModal(code)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Edit"
                      >
                        <i class="fas fa-edit"></i>
                      </a>
                      <a
                        href="#"
                        @click="deleteAccountCode(code.id)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Disposed"
                      >
                        <i class="fas fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                  <!-- </template> -->
                </tbody>
              </table>
              <div>
                <pagination
                  :data="account_codes"
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
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New Account Code</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Update Account Code</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAccountCode() : createAccountCode()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>Account Code</label>
                  <input
                    v-model="form.account_code"
                    type="text"
                    id="account_code"
                    placeholder="Account Code"
                    name="account_code"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('account_code') }"
                  />
                  <has-error :form="form" field="account_code"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Account Name</label>
                  <input
                    v-model="form.account_name"
                    type="text"
                    id="account_name"
                    placeholder="Enter Account Name"
                    name="account_name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('account_name') }"
                  />
                  <has-error :form="form" field="account_name"></has-error>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times">&nbsp;</i>Close
              </button>
              <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update Account Code
              </button>
              <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-code">&nbsp;</i>Add Account Code
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
      account_codes: {},
      form: new Form({
        id: "",
        account_code: "",
        account_name: ""
      })
    };
  },
  methods: {
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let account in this.account_codes.data) {
          this.selected.push(this.account_codes.data[account_code].id);
        }
      }
    },
    getResults(page = 1) {
      axios.get("api/account_code?page=" + page).then(response => {
        this.account_codes = response.data;
      });
    },
    updateAccountCode() {
      this.$Progress.start();
      this.form
        .put("api/account_code/" + this.form.id)
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
    deleteAccountCode(id) {
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
              .delete("api/account_code/" + id)
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
    editModal(account_code) {
      this.editmode = true;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
      this.form.fill(account_code);
    },
    // Show modal and hide
    newModal() {
      this.editmode = false;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
    },
    //Delete User method
    deleteAccountCode(id) {
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
              .delete("api/account_code/" + id)
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
    loadAccountCodes() {
      if (this.$gate.isAdminOrAuthor()) {
        axios
          .get("api/account_code")
          .then(({ data }) => (this.account_codes = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    createAccountCode() {
      // Progressbar before create user
      this.$Progress.start();
      this.form
        .post("api/account_code")
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
    this.loadAccountCodes();
    Fire.$on("AfterCreate", () => {
      this.loadAccountCodes();
    });
  }
  // mounted() {
  //   axios.get("api/account_code").then(response => {
  //     this.account_codes = response.data;
  //   });
  // }
};
</script>

<style scoped>
.update-create {
  background: rgb(22, 70, 143);
  color: white;
  opacity: 0.9;
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

.rpcppe {
  background-color: rgb(242, 242, 242);
}
</style>


// Command for this (npm run watch && php artisan serve)
