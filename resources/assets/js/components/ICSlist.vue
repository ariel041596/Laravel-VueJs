<template>
  <div class>
    <!-- For Admin -->
    <div class="card row mt-4" v-if="$gate.isAdminOrUserOrAuthor()">
      <div class="rpcppe card-header">
        <h3 class="card-title mt-2">
          Inventory and Custodian Slip (ICS)
          <button
            class="update-create btn float-right"
            @click="newModal"
          >
            <i class="fas fa-cart-plus">&nbsp;</i>Add Asset
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
                    <th>Article</th>
                    <th width="20%">Description</th>
                    <th width="5%">Property Number</th>
                    <th>Unit</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total Value</th>
                    <th>Date</th>
                    <th>Accountable Officer</th>
                    <th>Remarks</th>
                    <th v-if="$gate.isAdminOrAuthor()" width="8%">Account Name</th>
                    <th>Status</th>
                    <th>Property Type</th>
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
                  <tr v-for="asset in assets.data" :key="asset.id">
                    <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                    <!-- <td>{{asset.id}}</td> -->

                    <td>
                      <input type="checkbox" :value="asset.id" v-model="selected" />
                    </td>
                    <td>{{asset.article | upText}}</td>
                    <td>{{asset.description | upText}}</td>
                    <td>{{asset.property_number}}</td>
                    <td>{{asset.unit_of_measure}}</td>
                    <td>{{asset.price | numberComma }}</td>
                    <td>{{asset.quantity | numberComma}}</td>
                    <td>{{asset.total_value | numberComma}}</td>
                    <td>{{asset.date | myDate}}</td>
                    <td>{{asset.accountable_officer | upText}}</td>
                    <td>{{asset.remarks | upText}}</td>
                    <td v-if="$gate.isAdminOrAuthor()">{{asset.account_name | upText}}</td>
                    <td>{{asset.status | upText}}</td>
                    <td>{{asset.property_type}}</td>
                    <td>
                      <a
                        href="#"
                        @click="editModal(asset)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Edit"
                      >
                        <i class="fas fa-edit"></i>
                      </a>
                      <router-link v-show="asset.price>15000" :to="`${asset.id}`">
                        <i
                          class="fas fa-print"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Print PAR"
                        ></i>
                      </router-link>
                      <router-link v-show="asset.price<=15000" :to="`${asset.id}`">
                        <i
                          class="fas fa-print"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Print ICS"
                        ></i>
                      </router-link>
                      <a
                        href="#"
                        @click="deleteAsset(asset.id)"
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
    <div v-if="!$gate.isAdminOrUserOrAuthor()">
      <NotFound></NotFound>
    </div>
    <div
      id="printThis"
      class="modal fade"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <!-- Modal Content: begins -->
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="gridSystemModalLabel">Your Headings</h4>
          </div>

          <!-- Modal Body -->
          <div class="modal-body">
            <div class="body-message">
              <h4>Any Heading</h4>
              <p>And a paragraph with a full sentence or something else...</p>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <a href @click.prevent="print" target="_blank" class="btn btn-default">
              <i class="fa fa-print"></i>
            </a>
          </div>
        </div>
        <!-- Modal Content: ends -->
      </div>
    </div>

    <div
      class="modal fade"
      id="printing"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <!-- <h5 class="modal-title" id="addNewModalLabel">Add New Accountable Officer</h5> -->
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="widget-user-header text-white">
            <img src="/img/Header.png" width="75%" style="margin-left: 12%;" />
            <!-- <img src="/img/example-logo.jpg" width="75%" style="margin-left: 12%;"> -->
          </div>
          <form @submit.prevent>
            <div class="modal-body">
              <!-- For account Name and Code -->
              <div class="form-group">
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
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <a href @click.prevent="print" target="_blank" class="btn btn-default">
                <i class="fa fa-print"></i>
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Modal for Printing -->

    <!-- Modal for Adding Account Name -->
    <!-- Add bd-example-modal-lg for LARGE size modal and modal-lg for the second div-->
    <div
      class="modal fade"
      id="addNewAcctName"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="acctMode" class="modal-title" id="addNewModalLabel">Add New Account Name</h5>
            <h5
              v-show="!acctMode"
              class="modal-title"
              id="addNewModalLabel"
            >Add New Accountable Officer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="acctMode ? createAcct() : createAcctOfficer()">
            <div class="modal-body">
              <!-- For account Name and Code -->
              <div class="form-group">
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
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <!-- <button
                v-show="!acctMode"
                type="submit"
                class="btn btn-primary"
              >Create Accountable Officer</button>-->
              <button v-show="acctMode" type="submit" class="btn btn-primary">Create Account Name</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- End Modal for Adding Account Name -->
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
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Update Asset</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset() : createAsset()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>PAR/ICS Number</label>
                  <input
                    v-model="form.number"
                    type="text"
                    id="number"
                    placeholder="Enter PAR/ICS Number"
                    name="number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('number') }"
                  />
                  <has-error :form="form" field="number"></has-error>
                </div>
                <div class="col form-group">
                  <label>Article</label>
                  <input
                    v-model="form.article"
                    @change="getProfileid"
                    type="text"
                    id="article"
                    placeholder="Enter article"
                    name="article"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('article') }"
                  />
                  <has-error :form="form" field="article"></has-error>
                </div>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea
                  v-model="form.description"
                  type="text"
                  id="description"
                  placeholder="Enter description"
                  name="description"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('description') }"
                ></textarea>
                <has-error :form="form" field="description"></has-error>
              </div>
              <div class="row">
                <!-- first col -->
                <div class="col form-group">
                  <label>Property Number</label>
                  <input
                    v-model="form.property_number"
                    type="text"
                    id="property_number"
                    placeholder="Property Number"
                    name="property_number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('property_number') }"
                  />
                  <has-error :form="form" field="property_number"></has-error>
                </div>
                <!-- Second col -->
                <div class="col form-group">
                  <label>Unit of Measure</label>
                  <select
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
                <!-- third col Remove also the v-model-->
                <div class="col form-group">
                  <label>Unit Price</label>
                  <input
                    min="0"
                    currency="P"
                    separator=","
                    :value="form.price"
                    @change="updatePrice"
                    step="any"
                    type="number"
                    id="price"
                    placeholder="Enter price"
                    name="price"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('price') }"
                  />
                  <has-error :form="form" field="price"></has-error>
                </div>
                <!-- fourth col  Trying to remove the v-model first  -->
                <div class="col form-group">
                  <label>Quantity</label>
                  <input
                    min="1"
                    separator=","
                    :value="form.quantity"
                    @change="updateQuantity"
                    type="number"
                    id="quantity"
                    placeholder="Enter quantity"
                    name="quantity"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('quantity') }"
                  />
                  <has-error :form="form" field="quantity"></has-error>
                </div>
              </div>
              <div class="row">
                <!-- firt col -->
                <div class="col form-group">
                  <label>Total Value</label>
                  <input
                    disabled
                    currency="P"
                    separator=","
                    v-model="form.total_value"
                    step="any"
                    type="number"
                    id="total_value"
                    placeholder="Total Value"
                    name="total_value"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('total_value') }"
                  />
                  <has-error :form="form" field="total_value"></has-error>
                </div>
                <!-- Second col -->
                <div class="col form-group">
                  <label>Date Acquired</label>
                  <input
                    v-model="form.date"
                    type="date"
                    id="date"
                    placeholder="Total Date"
                    name="date"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('date') }"
                  />
                  <has-error :form="form" field="date"></has-error>
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Accountable Officer</label>
                  <select
                    v-model="form.accountable_officer"
                    type="text"
                    id="accountable_officer"
                    placeholder="Accountable Officer"
                    name="accountable_officer"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('accountable_officer') }"
                  >
                    <option value>Select Accountable Officer</option>
                    <option
                      v-for="officer in accountable_officers.data"
                      :key="officer.id"
                    >{{officer.name}}</option>
                  </select>
                  <has-error :form="form" field="accountable_officer"></has-error>
                </div>
                <!-- firt col -->
                <div class="col form-group">
                  <label>Remarks</label>
                  <input
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
                <div class="col form-group" v-show="false">
                  <input
                    v-model="form.createdBy"
                    type="text"
                    id="createdBy"
                    placeholder="createdBy"
                    name="createdBy"
                    class="form-control"
                  />
                </div>
                <div class="col form-group" v-show="false">
                  <input
                    value="pending"
                    type="text"
                    id="status"
                    placeholder="Status"
                    name="status"
                    class="form-control"
                  />
                </div>
                <div class="col form-group" v-show="false">
                  <input
                    value="INVENTORY"
                    type="text"
                    id="property_type"
                    placeholder="property_type"
                    name="property_type"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="row">
                <!-- <div class="col form-group">
                  <label>Service</label>
                  <input
                    v-model="form.service"
                    type="text"
                    id="service"
                    placeholder="Service"
                    name="service"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('service') }"
                  />
                  <has-error :form="form" field="service"></has-error>
                </div>-->
                <div class="col form-group" v-if="editmode">
                  <label>Status</label>
                  <select
                    name="status"
                    v-model="form.status"
                    id="status"
                    class="form-control"
                    :class="{'is-invalid': form.errors.has('status')}"
                  >
                    <option value>Select Status</option>
                    <!-- <option value="approved">Approved</!-->
                    -->
                    <option value="fordisposal">For Disposal</option>
                    <option value="disposed">Disposed</option>
                    <has-error :form="form" field="status"></has-error>
                  </select>
                </div>
                <div class="col form-group">
                  <label>Account Name</label>
                  <select
                    class="form-control"
                    id="account_name"
                    name="account_name"
                    placeholder="Please select Account"
                    v-model="form.account_name"
                    :class="{'is-invalid': form.errors.has('account_name')}"
                  >
                    <option value>Select Account Name</option>
                    <option
                      v-for="account in accountcodes.data"
                      :key="account.id"
                    >{{account.account_name}}</option>
                    <has-error :form="form" field="account_name"></has-error>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <div
                class="py-2 px-2"
                style="background: rgb(52, 144, 220); height: 32px; border-radius: 3px;"
              >
                <a href="#" @click="addAccModal">
                  <i class="fas fa-plus" style="color:#fff;"></i>
                </a>
              </div>
              <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fas fa-times">&nbsp;</i>Close
              </button>
              <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update Asset
              </button>
              <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-cart-plus">&nbsp;</i>Add Asset
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
      accountcodes: {},
      accountable_officers: {},
      profiles: {},
      assets: {},
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
        // service: "",
        createdBy: "",
        status: "pending",
        property_type: "INVENTORY"
      })
    };
  },
  // Computed Properties
  computed: {
    // grandTotal() {
    //   // return this.assets.reduce((sum, val) => sum + val.total_value, 0);
    // }
    // grandTotal: function() {
    //   let total = [];
    //   Object.entries(this.assets).forEach(([key, val]) => {
    //     total.push(val.total_value);
    //   });
    //   return total.reduce(function(total, num) {
    //     return total + num;
    //   }, 0);
    // }
  },

  // Testing for watch method to add commas while typing
  watch: {
    total_value: function(newValue) {
      const result = newValue
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      Vue.nextTick(() => (this.price = result));
    }
  },
  // Testing auto computation
  methods: {
    // needd to import the validate from validate.js
    add() {
      this.errors = null;
      const constraints = this.getConstraints();
      const errors = validate(this.$data.assets, constraints);
      if (errors) {
        this.errors = errors;
        return;
      }
      // else send to the users the data
    },
    getConstraints() {
      return {
        description: {
          presense: true,
          length: {
            minimum: 3,
            message: "Must gonna be 3 characters in minimum"
          }
        },
        price: {
          presense: true,
          numericallity: true,
          length: {
            minimum: 1,
            message: "Must gonna be 3 characters in minimum"
          }
        }
        // Same as from the top
      };
    },
    // datas() {
    //   return this.$store.getters.assets;
    // },
    // grandTotal: function() {
    //   console.log(this.assets.data.total_value);
    //   return this.assets.data.total_value.reduce((total, asset) => {
    //     return total + this.assets.data.total_value;
    //   }, 0);
    // },
    // grandTotal: function() {
    //   let total = [];
    //   Object.entries(this.assets).forEach(([key, val]) => {
    //     total.push(val.total_value);
    //   });
    //   return total.reduce(function(total, num) {
    //     return total + num;
    //   }, 0);
    // },
    printme() {
      window.print();
    },
    // print(elem) {
    //   var domClone = elem.cloneNode(true);

    //   var $printSection = document.getElementById("printSection");

    //   if (!$printSection) {
    //     var $printSection = document.createElement("div");
    //     $printSection.id = "printSection";
    //     document.body.appendChild($printSection);
    //   }

    //   $printSection.innerHTML = "";
    //   $printSection.appendChild(domClone);
    //   window.print();
    // },
    print() {
      const modal = document.getElementById("printing");
      const cloned = modal.cloneNode(true);
      let section = document.getElementById("print");
      if (!section) {
        section = document.createElement("div");
        section.id = "print";
        document.body.appendChild(section);
      }
      section.innerHTML = "";
      section.appendChild(cloned);
      window.print();
    },
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let asset in this.assets.data) {
          this.selected.push(this.assets.data[asset].id);
        }
      }
    },
    getProfileid(event) {
      this.form.article = event.target.value;
      this.form.createdBy = this.profiles.id;
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
      axios.get("api/asset?page=" + page).then(response => {
        this.assets = response.data;
      });
    },
    updateAsset() {
      this.$Progress.start();
      this.form
        .put("api/asset/" + this.form.id)
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
              .delete("api/asset/" + id)
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
    loadAccountableOfficers() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios
          .get("api/accountable_officer")
          .then(({ data }) => (this.accountable_officers = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadUsers() {
      axios.get("api/profile").then(({ data }) => (this.profiles = data));
    },
    // LoadUser to display in the tbody
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios.get("api/inventory").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    // LoadAccountname to display in the options datalist
    loadAcctName() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios
          .get("api/accountcode")
          .then(({ data }) => (this.accountcodes = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    createAsset() {
      // Progressbar before create user
      this.$Progress.start();
      this.form
        .post("api/asset")
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
    },
    createAcctOfficer() {
      // this.$Progress.start();
      // this.form
      //   .post("api/accountcode")
      //   .then(() => {
      //     // Custom event
      //     // Fire.$emit("AfterCreateAcct");
      //     toast.fire({
      //       type: "success",
      //       title: "Created successfully"
      //     });
      //     this.$Progress.finish();
      //     $("#addNewAcctName").modal("hide");
      //     $("#addNew").modal("show");
      //   })
      //   .catch(() => {});
    }
  },

  created() {
    // console.log(this.$_.isEmpty(null));
    // Progressbar before
    this.loadUsers();
    this.loadAcctName();
    this.loadAssets();
    this.loadAccountableOfficers();
    Fire.$on("AfterCreate", () => {
      this.loadAssets();
      this.loadAcctName();
    });
    // SetInterval Function
    // setInterval(() => this.loadUsers(), 3000);
  },
  mounted() {
    axios.get("api/inventory").then(response => {
      this.assets = response.data;
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

.rpcppe {
  background-color: rgb(242, 242, 242);
}
</style>


// Command for this (npm run watch && php artisan serve)
