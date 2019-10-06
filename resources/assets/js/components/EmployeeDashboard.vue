<template>
  <!-- For Employee -->
  <div id="card-content" class="card row mt-4" v-if="$gate.isEmployee()">
    <div id="rpcppe" class="card-header">
      <h3 class="card-title mt-1 text-white">
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
                  <th>Actions</th>
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
                    <td>{{asset.remarks }}</td>
                    <td>
                      <a
                        href="#"
                        @click="transferModal(asset)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Edit"
                        class="mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                      >
                        <i class="material-icons fas fa-pen"></i>
                      </a>
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
            <h5 v-show="!transfermode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="transfermode" class="modal-title" id="addNewModalLabel">Update Asset</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="transfermode ? updateAsset() : createAsset()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>PAR/ICS Number</label>
                  <input
                    readonly
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
                    value="PAR"
                    type="text"
                    id="property_type"
                    placeholder="property_type"
                    name="property_type"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="row">
                <div class="col form-group">
                  <label>Position</label>
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
                </div>
                <!-- <div class="col form-group" v-if="transfermode">
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
                <option value>Select Status</option>-->
                <!-- <option value="approved">Approved</!-->
                <!-- <option value="fordisposal">For Disposal</option>
                    <option value="disposed">Disposed</option>
                  </select>
                  <has-error :form="form" field="status"></has-error>
                </div>-->
                <div class="col form-group">
                  <label>Account Name</label>
                  <input
                    class="form-control"
                    id="account_name"
                    name="account_name"
                    placeholder="Please select Account"
                    v-model="form.account_name"
                    :class="{'is-invalid': form.errors.has('account_name')}"
                  />
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
              <button
                v-if="$gate.isAdminOrUserOrAuthor()"
                v-show="transfermode"
                @click="approvedStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-thumbs-up">&nbsp;</i>Approved
              </button>
              <button
                v-show="transfermode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen">&nbsp;</i>Update
              </button>

              <!-- <button v-show="transfermode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update RPCPPE
              </button>-->
              <!-- <button v-show="!transfermode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add RPCPPE
              </button>-->
              <button
                v-show="!transfermode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-plus">&nbsp;</i>RPCPPE
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
      assets: {},
      transfermode: false,
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
    },
    transferModal(asset) {
      this.transfermode = true;
      $("#addNew").modal("show");
      this.form.fill(asset);
    }
  },

  created() {
    this.loadAssets();
  }
};
</script>
<style scoped>
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
.update-create {
  background: rgb(22, 70, 143);
  color: white;
  opacity: 0.9;
}
.update-create:hover {
  opacity: 1;
}
</style>