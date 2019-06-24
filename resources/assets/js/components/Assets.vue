<template>
  <div class>
    <!-- /.row -->
    <div class="row mt-4" v-if="$gate.isAdminOrUserOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h1
              class="card-title mt-2"
            >Report on Physical Count of Property, Plant and Equipment (RPCPPE) {{ grandTotal }}</h1>
            <div class="card-tools">
              <button class="btn btn-primary mt-2" @click="newModal">
                <i class="fas fa-cart-plus">&nbsp;</i>Add Asset
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <!-- <th>ID</th> -->
                  <th>
                    <input type="checkbox" v-model="selectAll" @click="select">
                  </th>
                  <th>Article</th>
                  <th>Description</th>
                  <th>Property Number</th>
                  <th>Unit</th>
                  <th>Price</th>
                  <th>Qty</th>
                  <th>Total Value</th>
                  <th>Date</th>
                  <th>Accountable Officer</th>
                  <th>Remarks</th>
                  <th>Account Name</th>
                  <th v-if="$gate.isAdminOrAuthor()">Service</th>
                  <th>Action</th>
                </tr>
                <tr v-for="asset in assets.data" :key="asset.id">
                  <!-- <td>{{asset.id}}</td> -->
                  <td>
                    <input type="checkbox" :value="asset.id" v-model="selected">
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
                  <td>{{asset.service}}</td>
                  <!-- <td>{{asset.created_at | myDate}}</td> -->
                  <td>
                    <a href="#" @click="editModal(asset)">
                      <i class="fas fa-edit"></i>
                    </a>
                    <a href="#" @click="deleteAsset(asset.id)">
                      <i class="fas fa-trash red"></i>
                    </a>
                    <a href="#" @click="printingModal(asset)">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <!-- Start of Pagination -->
          <div class="card-footer">
            <pagination :data="assets" @pagination-change-page="getResults" align="right"></pagination>
          </div>
          <!-- End of pagination -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
    <!-- Modal for Printing -->
    <!-- Add bd-example-modal-lg for LARGE size modal and modal-lg for the second div-->
    <div
      class="modal fade"
      id="printing"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewModalLabel">Add New Accountable Officer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
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
                >
                <has-error :form="form" field="account_name"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
                >
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
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset() : createAsset()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="form.article"
                  type="text"
                  id="article"
                  placeholder="Enter article"
                  name="article"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('article') }"
                >
                <has-error :form="form" field="article"></has-error>
              </div>
              <div class="form-group">
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
                  <input
                    v-model="form.property_number"
                    type="text"
                    id="property_number"
                    placeholder="Property Number"
                    name="property_number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('property_number') }"
                  >
                  <has-error :form="form" field="property_number"></has-error>
                </div>
                <!-- Second col -->
                <div class="col form-group">
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
                <!-- third col Remove also the v-model-->
                <div class="col form-group">
                  <input
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
                  >
                  <has-error :form="form" field="price"></has-error>
                </div>
                <!-- fourth col  Trying to remove the v-model first  -->
                <div class="col form-group">
                  <input
                    separator=","
                    :value="form.quantity"
                    @change="updateQuantity"
                    type="number"
                    id="quantity"
                    placeholder="Enter quantity"
                    name="quantity"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('quantity') }"
                  >
                  <has-error :form="form" field="quantity"></has-error>
                </div>
              </div>
              <div class="row">
                <!-- firt col -->
                <div class="col form-group">
                  <input
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
                  >
                  <has-error :form="form" field="total_value"></has-error>
                </div>
                <!-- Second col -->
                <div class="col form-group">
                  <input
                    v-model="form.date"
                    type="date"
                    id="date"
                    placeholder="Total Date"
                    name="date"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('date') }"
                  >
                  <has-error :form="form" field="date"></has-error>
                </div>
                <!-- Third col -->
                <div class="col form-group">
                  <input
                    v-model="form.accountable_officer"
                    type="text"
                    id="accountable_officer"
                    placeholder="Accountable Officer"
                    name="accountable_officer"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('accountable_officer') }"
                  >
                  <has-error :form="form" field="accountable_officer"></has-error>
                </div>
              </div>
              <div class="row">
                <!-- firt col -->
                <div class="col form-group">
                  <input
                    v-model="form.remarks"
                    type="text"
                    id="remarks"
                    placeholder="Remarks"
                    name="remarks"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('remarks') }"
                  >
                  <has-error :form="form" field="remarks"></has-error>
                </div>
                <!-- Second col -->
                <div class="col form-group">
                  <input
                    type="text"
                    name="account_name"
                    v-model="form.account_name"
                    id="account_name"
                    class="form-control"
                    :class="{'is-invalid': form.errors.has('account_name')}"
                    list="accountcodes"
                  >
                  <has-error :form="form" field="account_name"></has-error>
                  <datalist id="accountcodes">
                    <option
                      v-for="accountcode in accountcodes.data"
                      :key="accountcode.id"
                    >{{accountcode.account_name}}</option>
                  </datalist>
                </div>
                <div
                  class="py-2 px-2"
                  style="background: rgb(52, 144, 220); height: 32px; border-radius: 3px;"
                >
                  <a href="#" @click="addAccModal">
                    <i class="fas fa-plus" style="color:#fff;"></i>
                  </a>
                </div>
                <!-- Third col -->
                <div class="col form-group">
                  <input
                    v-model="form.service"
                    type="text"
                    id="service"
                    placeholder="Service"
                    name="service"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('service') }"
                  >
                  <has-error :form="form" field="service"></has-error>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-primary">Update Asset</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">
                <i class="fas fa-cart-plus">&nbsp;</i>Add Asset
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selected: [],
      selectAll: false,
      acctMode: false,
      editmode: false,
      accountcodes: {},
      assets: {},
      form: new Form({
        id: "",
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
        service: ""
      })
    };
  },
  // Computed Properties
  computed: {
    grandTotal: function() {
      // console.log(this.data.assets.total_value);
      // return this.total_value.reduce((total, asset) => {
      //   return total + this.total_value;
      // }, 0);
    }

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
      this.form
        .put("api/asset/" + this.form.id)
        .then(() => {
          $("#addNew").modal("hide");
          swal.fire("Updated", "Your file has been Updated", "success");
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
                swal.fire("Deleted", "Your file has been deleted", "success");
                // this.loadUsers();
                Fire.$emit("AfterCreate");
              })
              .catch(() => {
                swal("Failed", "There was something wrong", "warning");
              });
          }
        });
    },
    // LoadUser to display in the tbody
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        axios.get("api/asset").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
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
        .catch(() => {});
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
    // Progressbar before
    this.loadAcctName();
    this.loadAssets();
    Fire.$on("AfterCreate", () => {
      this.loadAssets();
      this.loadAcctName();
    });
    // SetInterval Function
    // setInterval(() => this.loadUsers(), 3000);
  }
};
</script>

<style>
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
  .print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>


// Command for this (npm run watch && php artisan serve)
