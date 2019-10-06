<template>
  <div class>
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isEmployeeOrSupply()">
      <div id="rpcppe" class="card-header">
        <button
          class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect float-right"
          @click="newModal"
          v-if="$gate.isEmployee()"
        >
          <i class="fas fa-cart-plus">&nbsp;</i>Request Asset
        </button>
        <h3 class="card-title mt-1 text-white">Request Asset</h3>
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
                    <!-- <th>
                      <input type="checkbox" v-model="selectAll" @click="select" />
                    </!-->
                    <th>Service</th>
                    <th>RIS Number</th>
                    <th>Unit</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Purpose</th>
                    <th>Accountable Officer</th>
                    <th v-if="$gate.isSupply()">Issued By</th>
                    <th v-if="$gate.isSupply()">Received By</th>
                    <th>Action</th>
                  </tr>
                </tbody>
                <tbody>
                  <template v-if="assets.data<=0">
                    <tr>
                      <td colspan="15" class="text-center">No Request Available</td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr v-for="asset in assets.data" :key="asset.id">
                      <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                      <!-- <td>{{asset.id}}</td> -->

                      <!-- <td>
                        <input type="checkbox" :value="asset.id" v-model="selected" />
                      </!-->
                      <td>{{asset.service | upText}}</td>
                      <td>{{asset.request_number}}</td>
                      <td>{{asset.unit_of_measure}}</td>
                      <td>{{asset.description | upText}}</td>
                      <td class="text-center">{{asset.quantity | numberComma}}</td>
                      <td>{{asset.status | upText}}</td>
                      <td>{{asset.remarks }}</td>
                      <td>{{asset.purpose | upText}}</td>
                      <td>{{asset.accountable_officer}}</td>
                      <td v-if="$gate.isSupply()">{{asset.issued_by }}</td>
                      <td v-if="$gate.isSupply()">{{asset.received_by }}</td>
                      <td>
                        <a
                          v-show="$gate.isEmployee()"
                          v-if="asset.status=='pending'"
                          href="#"
                          class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          @click="editModal(asset)"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Edit"
                        >
                          <i class="material-icons fas fa-pen"></i>
                        </a>
                        <a
                          v-show="$gate.isSupply()"
                          href="#"
                          class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          @click="editModal(asset)"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Edit"
                        >
                          <i class="material-icons fas fa-pen"></i>
                        </a>
                        <!-- <a
                          v-if="asset.status=='approved'"
                          class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          @click="editModal(asset)"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Disposed"
                        >
                          <i class="material-icons fas fa-eye"></i>
                        </a>-->

                        <!-- <router-link :to="`${asset.id}`">
                          <i
                            class="fas fa-print"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Print"
                          ></i>
                        </router-link>-->
                      </td>
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
    <!-- End for Admin -->

    <!-- /.row -->
    <div v-if="!$gate.isEmployeeOrSupply()">
      <NotFound></NotFound>
    </div>
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
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Update Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset() : createAsset()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>Entity Name</label>
                  <input
                    readonly
                    v-model="form.entity_name"
                    type="text"
                    id="entity_name"
                    placeholder="Entity Name"
                    name="entity_name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('entity_name') }"
                  />
                  <has-error :form="form" field="entity_name"></has-error>
                </div>
                <div class="col form-group">
                  <label>Service</label>
                  <input
                    readonly
                    v-model="form.service"
                    type="text"
                    id="service"
                    placeholder="Service"
                    name="service"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('service') }"
                  />
                  <has-error :form="form" field="service"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Request Number</label>
                  <input
                    readonly
                    v-model="form.request_number"
                    type="text"
                    id="request_number"
                    placeholder="Request Number"
                    name="request_number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('request_number') }"
                  />
                  <has-error :form="form" field="request_number"></has-error>
                </div>
                <div class="col form-group">
                  <label>Unit of Measure</label>
                  <select
                    :disabled="!$gate.isEmployee()"
                    name="unit_of_measure"
                    v-model="form.unit_of_measure"
                    id="unit_of_measure"
                    class="form-control"
                    :class="{'is-invalid': form.errors.has('unit_of_measure')}"
                  >
                    <option value>Select Unit of Measure</option>
                    <option value="pc.">Piece</option>
                    <option value="pcs.">Pieces</option>
                    <option value="unit">Unit</option>
                    <option value="units">Units</option>
                    <option value="lot">Lot</option>
                    <has-error :form="form" field="unit_of_measure"></has-error>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Description</label>
                  <textarea
                    :disabled="!$gate.isEmployee()"
                    v-model="form.description"
                    type="text"
                    id="description"
                    placeholder="Enter Description"
                    name="description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                  />
                  <has-error :form="form" field="description"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Quantity</label>
                  <input
                    :disabled="!$gate.isEmployee()"
                    min="1"
                    separator=","
                    v-model="form.quantity"
                    type="number"
                    id="quantity"
                    placeholder="Enter quantity"
                    name="quantity"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('quantity') }"
                  />
                  <has-error :form="form" field="quantity"></has-error>
                </div>
                <div class="col form-group" v-show="false">
                  <input
                    v-model="form.status"
                    readonly
                    value="pending"
                    type="text"
                    id="status"
                    placeholder="Status"
                    name="status"
                    class="form-control"
                  />
                </div>
                <div class="col form-group">
                  <label>Remarks</label>
                  <input
                    :disabled="!$gate.isSupply()"
                    v-model="form.remarks"
                    type="text"
                    id="remarks"
                    placeholder="Remarks"
                    name="remarks"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('remarks') }"
                  />
                  <has-error :form="form" field="remarks"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Purpose</label>
                  <textarea
                    :disabled="!$gate.isEmployee()"
                    v-model="form.purpose"
                    type="text"
                    id="purpose"
                    placeholder="Enter Purpose"
                    name="purpose"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('purpose') }"
                  />
                  <has-error :form="form" field="purpose"></has-error>
                </div>
                <div class="col form-group" v-show="false">
                  <label>Accountable Officer</label>
                  <input
                    v-model="form.accountable_officer"
                    type="text"
                    id="accountable_officer"
                    placeholder="Accountable Officer"
                    name="accountable_officer"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('accountable_officer') }"
                  />
                  <has-error :form="form" field="accountable_officer"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group" v-if="$gate.isSupply()">
                  <label>Issued by</label>
                  <select
                    v-model="form.issued_by"
                    type="text"
                    id="issued_by"
                    placeholder="Issued By"
                    name="issued_by"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('issued_by') }"
                  >
                    <option value>Select Property Officer</option>
                    <option
                      v-for="officer in property_officers.data"
                      :key="officer.id"
                    >{{officer.name}}</option>
                  </select>
                  <has-error :form="form" field="issued_by"></has-error>
                </div>
                <div class="col form-group" v-if="$gate.isSupply()">
                  <label>Received by</label>
                  <input
                    v-model="form.received_by"
                    type="text"
                    id="received_by"
                    placeholder="Received by"
                    name="received_by"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('received_by') }"
                  />
                  <has-error :form="form" field="received_by"></has-error>
                </div>
                <div class="col form-group" v-show="false">
                  <label>Created By</label>
                  <input
                    v-model="form.createdBy"
                    type="text"
                    id="createdBy"
                    placeholder="Created By"
                    name="createdBy"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('createdBy') }"
                  />
                  <has-error :form="form" field="createdBy"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group" v-if="$gate.isSupply()" v-show="false">
                  <label>Status</label>
                  <select
                    type="text"
                    name="status"
                    placeholder="Status"
                    v-model="form.status"
                    id="status"
                    class="form-control"
                    :class="{'is-invalid': form.errors.has('status')}"
                  >
                    <!-- <option value>Select Status</option> -->
                    <!-- <option value="approved">Approved</!-->
                    <!-- <option value="approved">Approved</option> -->
                    <!-- <option value="unavailable">No Available</option> -->
                  </select>
                  <has-error :form="form" field="status"></has-error>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn-danger mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
                data-dismiss="modal"
              >
                <i class="material-icons fas fa-times">&nbsp;</i>Close
              </button>
              <button
                v-if="$gate.isEmployee()"
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="material-icons fas fa-pen">&nbsp;</i>Update Request
              </button>
              <button
                v-if="$gate.isSupply()"
                v-show="editmode"
                @click="noAvailable()"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="material-icons fas fa-thumbs-down">&nbsp;</i>No Available
              </button>
              <button
                v-if="$gate.isSupply()"
                v-show="editmode"
                @click="approvedStatus()"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="material-icons fas fa-thumbs-up">&nbsp;</i>Approved Request
              </button>
              <button
                v-show="!editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="material-icons fas fa-cart-plus">&nbsp;</i>Add Request
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
      selected_officer: "",
      selectAll: false,
      acctMode: false,
      editmode: false,
      accountcodes: {},
      property_officers: {},
      profiles: {},
      assets: {},
      form: new Form({
        id: "",
        entity_name: "DICT",
        service: "",
        request_number: "",
        unit_of_measure: "",
        description: "",
        quantity: "",
        status: "",
        remarks: "",
        purpose: "",
        accountable_officer: "",
        issued_by: "",
        received_by: "",
        createdBy: ""
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
    getStatus() {
      this.assets.data.status == "seen";
    },
    noAvailable() {
      this.form.remarks = "No Available / Insuficient Quantity";
    },
    approvedStatus() {
      this.form.status = "approved";
    },
    getProfileid(event) {
      this.form.description = event.target.value;
      this.form.createdBy = this.profiles.id;
    },
    getProfilename(event) {
      this.form.quantity = event.target.value;
      this.form.accountable_officer = this.profiles.name;
    },
    getProfileService(event) {
      this.form.description = event.target.value;
      this.form.service = this.profiles.service;
    },

    updateQuantity(event) {
      this.form.quantity = event.target.value;
      this.form.total_value = this.form.quantity * this.form.price;
    },
    updatePrice(event) {
      this.form.price = event.target.value;
      this.form.total_value = this.form.quantity * this.form.price;
    },
    getResults(page = 1) {
      axios.get("api/requests?page=" + page).then(response => {
        this.assets = response.data;
      });
    },
    getService() {
      if (this.$gate.isEmployee()) {
        this.form.service = this.profiles.service;
      }
    },
    updateAsset() {
      // if (this.$gate.isSupply()) {
      //   this.form.status = "approved";
      // }
      this.$Progress.start();
      this.form
        .put("api/requests/" + this.form.id)
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
    printingModal(asset) {
      $("#printing").modal("show");
    },
    // Show modal and hide
    editModal(asset) {
      this.editmode = true;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
      this.form.fill(asset);
    },
    // Show modal for add Account Name
    addAccModal() {
      this.acctMode = true;
      $("#addNewAcctName").modal("show");
      $("#addNew").modal("hide");
    },
    // Show modal and hide
    newModal() {
      this.editmode = false;
      this.form.reset();
      this.form.clear();
      $("#addNew").modal("show");
      this.form.service = this.profiles.service;
      // this.form.request_number = this.assets.to + 1;
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0");
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      // today = mm + dd + yyyy;
      today = yyyy;
      let risnumber = this.assets.total + 1;
      let createdby = this.profiles.id;
      this.form.request_number =
        "RIS-" + today + "-" + createdby + "-" + risnumber;
      this.form.createdBy = this.assets.id;
    },
    //Delete User method
    deleteAsset(id) {
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
              .delete("api/requests/" + id)
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
    loadPropertyOfficers() {
      if (this.$gate.isEmployeeOrSupply()) {
        axios
          .get("api/property_officer")
          .then(({ data }) => (this.property_officers = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadUsers() {
      axios.get("api/profile").then(({ data }) => (this.profiles = data));
    },
    // LoadUser to display in the tbody
    loadAssets() {
      if (this.$gate.isEmployeeOrSupply()) {
        axios.get("api/requests").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    // LoadAccountname to display in the options datalist
    loadAcctName() {
      if (this.$gate.isEmployeeOrSupply()) {
        axios
          .get("api/accountcode")
          .then(({ data }) => (this.accountcodes = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    createAsset() {
      // Progressbar before create user
      this.$Progress.start();
      this.form.status = "pending";
      this.form.createdBy = this.profiles.id;
      this.form.accountable_officer = this.profiles.name;
      this.form
        .post("api/requests")
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
    },
    createAcct() {
      this.$Progress.start();
      this.form
        .post("api/accountcode")
        .then(() => {
          // Custom event
          Fire.$emit("AfterCreateAcct");
          toast.fire({
            type: "success",
            title: "Created successfully"
          });
          this.$Progress.finish();
          $("#addNewAcctName").modal("hide");
          $("#addNew").modal("show");
        })
        .catch(() => {});
    }
  },

  created() {
    // console.log(this.$_.isEmpty(null));
    // Progressbar before
    this.loadUsers();
    this.loadAcctName();
    this.loadAssets();
    this.loadPropertyOfficers();
    Fire.$on("AfterCreate", () => {
      this.loadAssets();
      this.loadAcctName();
    });
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findRequest?q=" + query)
        .then(data => {
          this.assets = data.data;
        })
        .catch(() => {});
    });
    // SetInterval Function
    // setInterval(() => this.loadUsers(), 3000);
  }
  // mounted() {
  //   axios.get("api/requests").then(response => {
  //     this.assets = response.data;
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
#rpcppe {
  background: #3c8dbc;
  height: 50px;
}
.material-icons {
  font-size: 15px;
}
</style>


// Command for this (npm run watch && php artisan serve)
