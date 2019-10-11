<template>
  <div class>
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div id="rpcppe" class="card-header">
        <!-- <button class="update-create btn float-right" @click="newModal">
          <i class="fas fa-user-plus">&nbsp;</i>Create User
        </button>-->
        <button
          @click="newModal"
          class="update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        >
          <i class="fas fa-user-plus">&nbsp;</i>Create User
        </button>
        <h3 class="card-title mt-1 text-white">User's Management</h3>
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
                    </!-->
                    <th class="text-center">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Service</th>
                    <th>Action</th>
                  </tr>
                </tbody>
                <tbody>
                  <!-- <template v-if="!assets.data.length">
                    <tr>
                      <td colspan="15" class="text-center">No Properties Available</td>
                    </tr>
                  </template>-->
                  <!-- <template v-else> -->
                  <tr v-for="user in users.data" :key="user.id">
                    <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                    <!-- <td>{{asset.id}}</td> -->

                    <!-- <td>
                      <input type="checkbox" :value="user.id" v-model="selected" />
                    </!-->
                    <td class="text-center">{{user.id}}</td>
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | upText}}</td>
                    <td>{{user.service}}</td>
                    <td>
                      <a
                        id="mdl-btn"
                        title="Edit"
                        class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                        href="#"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        @click="editModal(user)"
                      >
                        <i class="material-icons fas fa-pen"></i>
                      </a>
                      <a
                        title="Delete"
                        class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                        href="#"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        @click="deleteUser(user.id)"
                      >
                        <i class="material-icons fas fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                  <!-- </template> -->
                </tbody>
              </table>
              <div>
                <pagination :data="users" @pagination-change-page="getResults" align="right"></pagination>
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
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New User</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Update User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateUser() : createUser()">
            <div class="modal-body">
              <div class="form-group">
                <label>Full Name (Last Name, First Name, M.I.)</label>
                <input
                  v-model="form.name"
                  type="text"
                  id="name"
                  placeholder="Enter Name"
                  name="name"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }"
                />
                <has-error :form="form" field="name"></has-error>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  id="email"
                  placeholder="Email Address"
                  name="email"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('email') }"
                />
                <has-error :form="form" field="email"></has-error>
              </div>
              <div class="form-group">
                <label>Service</label>
                <input
                  v-model="form.service"
                  id="service"
                  placeholder="Service"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('service') }"
                />
                <has-error :form="form" field="service"></has-error>
              </div>
              <div class="form-group">
                <label>User Type</label>
                <select
                  name="type"
                  v-model="form.type"
                  id="type"
                  class="form-control"
                  :class="{'is-invalid': form.errors.has('type')}"
                >
                  <option value>--Select User Role--</option>
                  <option value="admin">Admin</option>
                  <option value="author">Author</option>
                  <option value="user">User</option>
                  <option value="supply">Supply</option>
                  <option value="employee">Employee</option>
                  <has-error :form="form" field="type"></has-error>
                </select>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input
                  v-model="form.password"
                  type="password"
                  placeholder="Enter Password"
                  name="password"
                  id="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>
            </div>
            <i class="modal-footer">
              <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times">&nbsp;</i>Close
              </button>-->
              <button
                data-dismiss="modal"
                class="btn-danger mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-times">&nbsp;</i>Close
              </button>
              <!-- <button
                :disabled="disabled"
                v-show="editmode"
                type="submit"
                class="update-create btn"
              >
                <i class="fas fa-pen">&nbsp;</i>Update User
              </button>-->
              <button
                :disabled="disabled"
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen">&nbsp;</i>Update User
              </button>
              <button
                :disabled="disabled"
                v-show="!editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-user-plus">&nbsp;</i>Create User
              </button>
              <!-- <button
                :disabled="disabled"
                v-show="!editmode"
                type="submit"
                class="update-create btn"
              >
                <i class="fas fa-user-plus">&nbsp;</i>Create User
              </button>-->
            </i>
          </form>
        </div>
      </div>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  data() {
    return {
      submitmode: false,
      errors: null,
      selected: [],
      selectAll: false,
      editmode: false,
      users_types: {},
      users: {},
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        service: "",
        photo: ""
      })
    };
  },
  computed: {
    disabled() {
      return (
        this.form.name === "" ||
        this.form.email === "" ||
        this.form.password === "" ||
        this.form.type === "" ||
        this.form.service === ""
      );
    }
  },
  methods: {
    // disabled() {
    //   return (
    //     this.form.name === "" ||
    //     this.form.email === "" ||
    //     this.form.password === "" ||
    //     this.form.type === "" ||
    //     this.form.service === ""
    //   );
    // },
    isInAsset(asset) {
      const item = this.asset.find(item => item.id === asset.id);
      if (item) {
        return true;
      } else {
        return false;
      }
    },

    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let asset in this.assets.data) {
          this.selected.push(this.assets.data[asset].id);
        }
      }
    },
    getResults(page = 1) {
      axios.get("api/user?page=" + page).then(response => {
        this.users = response.data;
      });
    },
    updateUser() {
      $("#addNew").modal("hide");
      this.$Progress.start();
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          // swal.fire("Updated", "Your file has been Updated", "success");
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
          toast.fire({
            type: "success",
            title: "Updated successfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    // Show modal and hide
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    // Show modal and hide
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    //Delete User method
    deleteUser(id) {
      swal
        .fire({
          title: "Delete File?",
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
              .delete("api/user/" + id)
              .then(() => {
                toast.fire({
                  type: "success",
                  title: "Deleted successfully"
                });
                Fire.$emit("AfterCreate");
              })
              .catch(() => {
                swal("Failed", "There was something wrong", "warning");
              });
          }
        });
    },
    // LoadUser to display in the tbody
    loadUsers() {
      if (this.$gate.isAdminOrAuthor()) {
        axios.get("api/user").then(({ data }) => (this.users = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadUsersType() {
      if (this.$gate.isAdminOrAuthor()) {
        axios
          .get("api/users_type")
          .then(({ data }) => (this.users_types = data)); //Remove the previous (this.users =data.data) into data only
      }
    },

    createUser() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          $("#addNew").modal("hide");
          // Custom event to fire
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
          // Sweet Alert message from sweetalert2
          toast.fire({
            type: "success",
            title: "Created successfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
          this.$$Progress.finish();
        });
    }
  },

  created() {
    // Custom event for search
    this.loadUsersType();
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findUser?q=" + query)
        .then(data => {
          this.users = data.data;
        })
        .catch(() => {});
    });
    this.loadUsers();
    Fire.$on("AfterCreate", () => {
      this.loadUsersType();
      this.loadUsers();
    });
  }
};
</script>
<style scoped>
.update-create {
  background: rgb(22, 70, 143);
  color: white;
  opacity: 0.9;
}
.update-create:hover:enabled {
  opacity: 1;
}
.update-create:hover:disabled {
  cursor: not-allowed;
  opacity: 0.9;
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
.material-icons {
  font-size: 15px;
}
.mdl-btn {
  background-color: #ececec;
}
</style>
