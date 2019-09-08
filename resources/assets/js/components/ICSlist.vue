<template>
  <div class>
    <div class="card row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div class="card-header">
        <h3 class="card-title mt-2">
          Inventory and Custodian Slip
          <button class="btn btn-primary float-right" @click="newModal">
            <i class="fas fa-cart-plus">&nbsp;</i>Add Asset
          </button>
        </h3>
      </div>

      <!-- /.card-header -->
      <div class="card-body">
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
                    <th width="8%">Account Name</th>
                    <th v-if="$gate.isAdminOrAuthor()">Service</th>
                    <th>Action</th>
                  </tr>
                </tbody>
                <tbody>
                  <template v-if="!assets.data.length">
                    <tr>
                      <td colspan="15" class="text-center">No Properties Available</td>
                    </tr>
                  </template>
                  <template v-else>
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
                      <td>{{asset.service}}</td>
                      <!-- <td>{{asset.created_at | myDate}}</td> -->
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
                  </template>
                </tbody>
              </table>
            </div>
            <div class="card-footer">
              <pagination :data="assets" @pagination-change-page="getResults" align="right"></pagination>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>

    <!-- /.row -->
    <div v-if="!$gate.isAdminOrAuthor()">
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
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset() : createAsset()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
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
                  />
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
                  />
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
                  />
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
                  />
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
                  />
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
                  />
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
                  />
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
                  />
                  <has-error :form="form" field="account_name"></has-error>
                  <datalist id="accountcodes">
                    <option>{{accountcodes.account_name}}</option>
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
                  />
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
  name: "ics-list",
  data() {
    return {
      invetorys: {}
    };
  },
  created() {
    if (this.$gate.isAdminOrUserOrAuthor()) {
      axios.get("api/inventory").then(({ data }) => (this.invetorys = data)); //Remove the previous (this.users =data.data) into data only
    }
  }
};
</script>

<style>
</style>


// Command for this (npm run watch && php artisan serve)
