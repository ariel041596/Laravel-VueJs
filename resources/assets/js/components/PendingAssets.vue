<template>
  <div class id="pendingAssetsVue">
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrUserOrAuthorOrSupply()">
      <div id="rpcppe" class="rpcppe card-header">
        <button
          data-toggle="tooltip"
          data-placement="bottom"
          title="Unit Price Exceeds P15,000.00"
          @click="newModal"
          class="ml-1 update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        >
          <i class="fas fa-plus">&nbsp;</i>RPCPPE
        </button>
        <button
          data-toggle="tooltip"
          data-placement="bottom"
          title="Unit Price Below P15,001.00"
          @click="newModal2"
          class="update-create float-right mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
        >
          <i class="fas fa-plus">&nbsp;</i>ICS
        </button>
        <h3 class="card-title mt-1 text-white">
          <i class="fas fa-clipboard"></i>&nbsp;PENDINGS
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
                class="table dataTable table-bordered"
                role="grid"
                aria-describedby="example2_info"
              >
                <tbody>
                  <tr class>
                    <!-- <th>ID</th> -->
                    <!-- <th>
                      <input type="checkbox" v-model="selectAll" @click="select" />
                    </!-->
                    <th>PAR/ICS #</th>
                    <th>ARTICLE</th>
                    <th>DESCRIPTION</th>
                    <th class="thPropNo">PROPERTY #</th>
                    <th>UNIT</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>TOTAL VALUE</th>
                    <th>DATE</th>
                    <th class="thAccOfficer">ACCOUNTABLE OFFICER</th>
                    <th>REMARKS</th>
                    <th v-if="$gate.isAdminOrAuthor()">ACCOUNT NAME</th>
                    <!-- <th>Service</th> -->
                    <!-- <th>Status</th> -->
                    <th>TYPE</th>
                    <th>ACTION</th>
                  </tr>
                </tbody>
                <tbody>
                  <template v-if="pendings.data<=0">
                    <tr>
                      <td colspan="15" class="text-center">No Pending PAR/ICS Available</td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr v-for="asset in pendings.data" :key="asset.id">
                      <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                      <!-- <td>{{asset.id}}</td> -->

                      <!-- <td>
                        <input type="checkbox" :value="asset.id" v-model="selected" />
                      </!-->
                      <td>{{asset.number}}</td>
                      <td>{{asset.article | upText}}</td>
                      <td>{{asset.description | upText}}</td>
                      <td>{{asset.property_number}}</td>
                      <td>{{asset.unit_of_measure}}</td>
                      <td>{{asset.price | numberComma }}</td>
                      <td>{{asset.quantity | numberComma}}</td>
                      <td>{{asset.total_value | numberComma}}</td>
                      <td>{{asset.date | myDate}}</td>
                      <td>{{asset.accountable_officer | upText}}</td>
                      <td>{{asset.remarks }}</td>
                      <td v-if="$gate.isAdminOrAuthor()">{{asset.account_name | upText}}</td>
                      <!-- <td>{{asset.service}}</td> -->
                      <!-- <td>{{asset.status | upText}}</td> -->
                      <td>{{asset.property_type | upText}}</td>
                      <td>
                        <a
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          @click="editModal(asset)"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Edit"
                        >
                          <i class="material-icons fas fa-pen"></i>
                        </a>
                        <router-link
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          v-show="asset.price>15000"
                          :to="`${asset.id}`"
                        >
                          <i
                            class="material-icons fas fa-print"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Print PAR"
                          ></i>
                        </router-link>
                        <router-link
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          v-show="asset.price<=15000"
                          :to="`${asset.id}`"
                        >
                          <i
                            class="material-icons fas fa-print"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Print ICS"
                          ></i>
                        </router-link>
                        <!-- <a
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          @click="deleteAsset(asset.id)"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Disposed"
                        >
                          <i class="material-icons fas fa-trash red"></i>
                        </a>-->
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <p
                id="showEntries"
              >Showing {{pendings.from}} to {{pendings.to}} of {{pendings.total}} entries</p>
              <div id="footer">
                <pagination
                  class="float-right"
                  :data="pendings"
                  @pagination-change-page="getResults"
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
    <div v-if="!$gate.isAdminOrUserOrAuthorOrSupply()">
      <NotFound></NotFound>
    </div>
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
              <div class="row">
                <div class="col form-group">
                  <input
                    readonly
                    v-model="form.number"
                    type="text"
                    id="number"
                    placeholder="Enter PAR Number"
                    name="number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('number') }"
                  />
                  <has-error :form="form" field="number"></has-error>
                  <label>PAR Number</label>
                </div>
                <div class="col form-group">
                  <select
                    v-model="form.article"
                    @change="getProfileid"
                    type="text"
                    id="article"
                    placeholder="Enter article"
                    name="article"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('article') }"
                  >
                    <option value>Please select article</option>
                    <option
                      v-for="article in article_categories.data"
                      :key="article.id"
                    >{{article.article}}</option>
                  </select>
                  <label>Article</label>
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
                  <input
                    v-model="form.property_number"
                    type="text"
                    id="property_number"
                    placeholder="Property Number"
                    name="property_number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('property_number') }"
                  />
                  <label>Property Number</label>
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
                  <label>Unit of Measure</label>
                </div>
              </div>
              <div class="row">
                <!-- third col Remove also the v-model-->
                <div class="col form-group">
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
                  <label>Unit Price</label>
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
                  <select
                    v-model="form.service"
                    type="text"
                    id="service"
                    placeholder="Service"
                    name="service"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('service') }"
                  >
                    <option value>Please Select Position</option>
                    <option
                      v-for="position in accountable_officers.data"
                      :key="position.id"
                    >{{position.designation}}</option>
                  </select>
                  <has-error :form="form" field="service"></has-error>
                </div>
                <!-- <div class="col form-group" v-if="editmode">
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
                v-show="editmode"
                @click="cancelStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-trash">&nbsp;</i>Cancel
              </button>
              <button
                v-if="$gate.isAdminOrUserOrAuthor()"
                v-show="editmode"
                @click="approvedStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-thumbs-up">&nbsp;</i>Approved
              </button>
              <button
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen">&nbsp;</i>Update
              </button>

              <!-- <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update RPCPPE
              </button>-->
              <!-- <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add RPCPPE
              </button>-->
              <button
                data-toggle="tooltip"
                data-placement="bottom"
                title="Add Report on Physical Count of Property Plant and Equipment"
                v-show="!editmode"
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
    <div
      class="modal fade bd-example-modal-lg"
      id="addNew2"
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
          <form @submit.prevent="editmode ? updateAsset() : createAsset2()">
            <div class="modal-body">
              <div class="row">
                <div class="col form-group">
                  <label>ICS Number</label>
                  <input
                    readonly
                    v-model="form.number"
                    type="text"
                    id="number"
                    placeholder="Enter ICS Number"
                    name="number"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('number') }"
                  />
                  <has-error :form="form" field="number"></has-error>
                </div>
                <div class="col form-group">
                  <label>Article</label>
                  <select
                    v-model="form.article"
                    @change="getProfileid"
                    type="text"
                    id="article"
                    placeholder="Enter article"
                    name="article"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('article') }"
                  >
                    <option value>Please select article</option>
                    <option
                      v-for="article in article_categories.data"
                      :key="article.id"
                    >{{article.article}}</option>
                  </select>
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
                  <select
                    v-model="form.service"
                    type="text"
                    id="service"
                    placeholder="Service"
                    name="service"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('service') }"
                  >
                    <option value>Please Select Position</option>
                    <option
                      v-for="position in accountable_officers.data"
                      :key="position.id"
                    >{{position.designation}}</option>
                  </select>
                  <has-error :form="form" field="service"></has-error>
                </div>
                <!-- <div class="col form-group" v-if="editmode">
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
                v-show="editmode"
                @click="approvedStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-thumbs-up">&nbsp;</i>Approved
              </button>
              <button
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen">&nbsp;</i>Update
              </button>

              <!-- <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update RPCPPE
              </button>-->
              <!-- <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add RPCPPE
              </button>-->
              <button
                data-toggle="tooltip"
                data-placement="bottom"
                title="Add Inventory Custodian Slip"
                v-show="!editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-plus">&nbsp;</i>ICS
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
      total_assets: {},
      total_inventories: {},
      pendings: {},
      inventories: {},
      article_categories: {},
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
      axios.get("api/pending?page=" + page).then(response => {
        this.pendings = response.data;
      });
    },
    approvedStatus() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        this.form.status = "approved";
        this.form.createdBy = this.profiles.id;
      }
    },
    cancelStatus() {
      if (this.$gate.isAdminOrUserOrAuthor()) {
        this.form.status = "cancel";
        this.form.property_type = "cancel";
        this.form.createdBy = this.profiles.id;
      }
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
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0");
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      // today = mm + dd + yyyy;
      today = yyyy;
      let parnumber = this.total_assets + 1; //trying to compute the total
      let createdby = this.profiles.id;
      this.form.property_type = "PAR";
      this.form.number = "PAR-" + today + "-" + createdby + "-" + parnumber;
    },
    newModal2() {
      this.editmode = false;
      this.form.reset();
      this.form.clear();
      $("#addNew2").modal("show");
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0");
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      // today = mm + dd + yyyy;
      today = yyyy;
      let icsnumber = this.total_inventories + 1;
      let createdby = this.profiles.id;
      this.form.property_type = "INVENTORY";
      this.form.number = "ICS-" + today + "-" + createdby + "-" + icsnumber;
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
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios
          .get("api/accountable_officer")
          .then(({ data }) => (this.accountable_officers = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadArticleCategory() {
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios
          .get("api/article_category")
          .then(({ data }) => (this.article_categories = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadUsers() {
      axios.get("api/profile").then(({ data }) => (this.profiles = data));
    },
    loadPendingAssets() {
      axios.get("api/pending").then(({ data }) => (this.pendings = data));
    },
    loadTotals() {
      axios
        .get("api/total_assets")
        .then(({ data }) => (this.total_assets = data));
    },
    loadTotalInventories() {
      axios
        .get("api/total_inventories")
        .then(({ data }) => (this.total_inventories = data));
    },
    // LoadUser to display in the tbody
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios.get("api/asset").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadInventories() {
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios
          .get("api/inventory")
          .then(({ data }) => (this.inventories = data));
      }
    },
    // LoadAccountname to display in the options datalist
    loadAcctName() {
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios
          .get("api/accountcode")
          .then(({ data }) => (this.accountcodes = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    createAsset() {
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0");
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      // today = mm + dd + yyyy;
      today = yyyy;
      let parnumber = this.total_assets + 1;
      let createdby = this.profiles.id;
      this.form.property_type = "PAR";
      this.form.status = "pending";
      this.form.number = "PAR-" + today + "-" + createdby + "-" + parnumber;

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
    createAsset2() {
      let today = new Date();
      let dd = String(today.getDate()).padStart(2, "0");
      let mm = String(today.getMonth() + 1).padStart(2, "0");
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      // today = mm + dd + yyyy;
      today = yyyy;
      let icsnumber = this.total_inventories + 1;
      let createdby = this.profiles.id;
      this.form.property_type = "INVENTORY";
      this.form.status = "pending";
      this.form.number = "ICS-" + today + "-" + createdby + "-" + icsnumber;

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
          $("#addNew2").modal("hide");
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
    this.$Progress.start();
    this.loadPendingAssets();
    this.loadInventories();
    this.loadAssets();
    this.loadTotals();
    this.loadTotalInventories();
    this.loadUsers();
    this.loadAcctName();
    this.loadAccountableOfficers();
    this.loadArticleCategory();
    this.$Progress.finish();
    Fire.$on("AfterCreate", () => {
      this.loadPendingAssets();
      this.loadAssets();
      this.loadInventories();
      this.loadTotals();
    });

    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findPending?q=" + query)
        .then(data => {
          this.pendings = data.data;
        })
        .catch(() => {});
    });
    // SetInterval Function
    // setInterval(() => this.loadUsers(), 3000);
    // setInterval(() => this.loadPendingAssets(), 5000);
  }
  // mounted() {
  //   axios.get("api/asset").then(response => {
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
  margin-top: -5px;
}
.btn-danger {
  margin-top: -5px;
}
.update-create:hover {
  background: rgb(22, 70, 143);
  opacity: 1;
}
.modal-close-button {
  color: white;
}
.modal-header {
  background: rgb(22, 70, 143);
  color: aliceblue;
  -webkit-border-radius: 0px !important;
  -moz-border-radius: 0px !important;
  border-radius: 0px !important;
}
.modal-content {
  -webkit-border-radius: 0px !important;
  -moz-border-radius: 0px !important;
  border-radius: 0px !important;
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
/* .mdl-btn {
  background-color: #ececec;
} */
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
.thPropNo {
  width: 90px;
}
.thAccOfficer {
  width: 170px;
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
#rpcppe {
  background: #3c8dbc;
  height: 50px;
}
/* #pendingAssetsVue {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
} */
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
.row .form-group label {
  position: absolute;
  top: 0;
  left: 0;
  margin-left: 18px;
}
.row .form-group input,
.row .form-group select {
  margin-top: 20px;
}
#description {
  height: 160px;
}
</style>


// Command for this (npm run watch && php artisan serve)
