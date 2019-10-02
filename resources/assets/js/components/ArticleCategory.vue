<template>
  <div class>
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div id="rpcppe" class="card-header">
        <button class="update-create btn float-right" @click="newModal">
          <i class="fas fa-plus">&nbsp;</i>Add Article
        </button>
        <h3 class="card-title mt-1 text-white">Article Category{{selecteds}} {{selected}}</h3>
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
                    <th>
                      <input type="checkbox" v-model="selectAll" @click="select" />
                    </th>
                    <th class="text-center">ID</th>
                    <th>Article</th>
                    <th>Account Name</th>
                    <th>Account Code</th>
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
                  <tr v-for="article in article_categories.data" :key="article.id">
                    <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                    <!-- <td>{{asset.id}}</td> -->

                    <td>
                      <input type="checkbox" :value="article.id" v-model="selected" />
                    </td>
                    <td class="text-center">{{article.id}}</td>
                    <td>{{article.article}}</td>
                    <td>{{article.account_name}}</td>
                    <td>{{article.account_code}}</td>
                    <td>
                      <!-- See for the function of edits and Deletes -->
                      <a
                        href="#"
                        @click="editModal(article)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Edit"
                      >
                        <i class="fas fa-edit"></i>
                      </a>
                      <a
                        href="#"
                        @click="deleteArticleCategory(article.id)"
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
                  :data="article_categories"
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
            >Add New Article Category</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Update Article Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateArticleCategory() : createArticleCategory()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>Article Name</label>
                  <input
                    v-model="form.article"
                    type="text"
                    id="article"
                    placeholder="Article Name"
                    name="article"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('article') }"
                  />
                  <has-error :form="form" field="article"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Account Name</label>
                  {{selecteds}}
                  <select
                    v-model="selecteds"
                    type="text"
                    id="account_name"
                    placeholder="Enter Account Name"
                    name="account_name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('account_name') }"
                  >
                    <option value>Select Account Name</option>
                    <option
                      @click="select_account_code()"
                      v-for="accountname in account_codes.data"
                      :key="accountname.id"
                    >{{accountname}}</option>
                  </select>
                  <has-error :form="form" field="account_name"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Account Code</label>
                  <input
                    v-model="selecteds_account_code"
                    type="text"
                    id="account_code"
                    placeholder="Enter Account Code"
                    name="account_code"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('account_code') }"
                  />
                  <has-error :form="form" field="account_code"></has-error>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times">&nbsp;</i>Close
              </button>
              <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update Article Category
              </button>
              <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add Article Category
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
      selecteds: null,
      selectAll: false,
      selectAlls: false,
      acctMode: false,
      editmode: false,
      selecteds_account_code: {},
      selected_value: "",
      selected_options: [{}],
      article_categories: {},
      account_codes: {},
      form: new Form({
        id: "",
        article: "",
        account_name: "",
        account_code: ""
      })
    };
  },
  methods: {
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let article_category in this.article_categories.data) {
          this.selected.push(this.article_categories.data[article_category].id);
        }
      }
    },
    select_account_code(){

    },
    selects() {
      //   this.selecteds = [];
      //   if (!this.selectAlls) {
      for (let accountname in this.account_codes.data) {
        this.selecteds.push(this.account_codes.data[accountname].account_code);
      }
      //   }
    },
    getResults(page = 1) {
      axios.get("api/article_category?page=" + page).then(response => {
        this.article_categories = response.data;
      });
    },
    getRespondingdata() {
      this.form.account_code = this.selecteds.account_code;
      //   for (let accountname in this.account_codes.data) {
      //     this.form.account_code = this.account_codes.data[accountname].id;
      //   }
    },
    // getSelectedOptions() {
    //   this.selected_options = this.account_codes.data;
    // },
    updateArticleCategory() {
      this.$Progress.start();
      this.form
        .put("api/article_category/" + this.form.id)
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
    deleteArticleCategory(id) {
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
              .delete("api/article_category/" + id)
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
              .delete("api/article_category/" + id)
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
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios
          .get("api/account_code")
          .then(({ data }) => (this.account_codes = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadArticleCategory() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios
          .get("api/article_category")
          .then(({ data }) => (this.article_categories = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    createArticleCategory() {
      // Progressbar before create user
      this.$Progress.start();
      this.form
        .post("api/article_category")
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
    // this.getSelectedOptions();
    // this.selecteds = this.account_codes.;
    this.loadAccountCodes();
    this.loadArticleCategory();
    Fire.$on("AfterCreate", () => {
      this.loadArticleCategory();
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
</style>


// Command for this (npm run watch && php artisan serve)
