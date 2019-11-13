<template>
  <div class id="requestedPropertyvue">
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrUserOrAuthorOrEmployee()">
      <div id="rpcppe" class="card-header">
        <h3 class="card-title mt-1 text-white">
          <i class="fas fa-exchange-alt"></i>&nbsp;TRANSFER REQUESTS
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
                    <th>ARTICLE</th>
                    <th width="20%">DESCRIPTION</th>
                    <th>PROPERTY #</th>
                    <th>UNIT</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>TOTAL VALUE</th>
                    <th>DATE</th>
                    <th>ACCOUNTABLE OFFICER</th>
                    <th>FOR TRANSFER TO</th>
                    <th>STATUS</th>
                    <th v-if="$gate.isAdminOrAuthor()" width="8%">ACCOUNT NAME</th>
                    <!-- <th>Status</th>
                    <th>Property Type</th>-->
                    <th>ACTION</th>
                  </tr>
                </tbody>
                <tbody>
                  <template v-if="assets.data<=0">
                    <tr>
                      <td colspan="15" class="text-center">No Request For Transfer Available</td>
                    </tr>
                  </template>
                  <template v-else>
                    <tr v-for="asset in assets.data" :key="asset.id">
                      <!-- <tr v-for="asset in assets" :key="asset.id"> -->
                      <!-- <td>{{asset.id}}</td> -->

                      <!-- <td>
                        <input type="checkbox" :value="asset.id" v-model="selected" />
                      </td>-->
                      <td>{{asset.article | upText }}</td>
                      <!-- <td
                        class="mdl-badge mdl-badge--overlap"
                        :data-badge="asset.remarks"
                      >{{asset.description | upText}}</td>-->
                      <td>{{asset.description | upText}}</td>
                      <td>{{asset.property_number}}</td>
                      <td>{{asset.unit_of_measure}}</td>
                      <td class="text-right">{{asset.price | numberComma }}</td>
                      <td class="text-center">{{asset.quantity | numberComma}}</td>
                      <td class="text-right">{{asset.total_value | numberComma}}</td>
                      <td>{{asset.date | myDate}}</td>
                      <td>{{asset.received_from | upText}}</td>
                      <td>{{asset.transfer_to | upText}}</td>
                      <td>
                        <span
                          v-if="asset.remarks=='For Transfer'"
                          class="badge badge-pill badge-danger"
                        >{{asset.remarks }}</span>
                        <span
                          v-if="asset.remarks=='Cancel Transfer'"
                          class="badge badge-pill badge-dark"
                        >{{asset.remarks }}</span>
                        <!-- <span v-else>{{asset.remarks}}</span> -->
                      </td>
                      <td v-if="$gate.isAdminOrAuthor()">{{asset.account_name | upText}}</td>
                      <!-- <td>{{asset.status | upText}}</td> -->
                      <!-- <td>{{asset.property_type | upText}}</td> -->
                      <td>
                        <a
                          v-if="$gate.isEmployee()"
                          @click="editModal2(asset)"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Edit"
                        >
                          <i class="material-icons fas fa-pen"></i>
                          <!-- <i class="material-icons">add</i> -->
                        </a>
                        <router-link
                          v-if="$gate.isEmployee()"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          v-show="asset.price>15000"
                          :to="{name: 'par', params: { id: asset.id }}"
                        >
                          <!-- <router-link v-show="asset.price>15000" :to="`${asset.id}`"> -->
                          <i
                            class="material-icons fas fa-print"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Print PAR Transfer"
                          ></i>
                        </router-link>
                        <router-link
                          v-if="$gate.isEmployee()"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          v-show="asset.price<=15000"
                          :to="`${asset.id}`"
                        >
                          <i
                            class="material-icons fas fa-print"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Print ICS Transfer"
                          ></i>
                        </router-link>
                        <a
                          v-if="$gate.isAdminOrUserOrAuthor()"
                          @click="editModal3(asset)"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="View"
                        >
                          <i class="material-icons fas fa-eye blue"></i>
                        </a>
                        <span class="view_action"></span>
                        <!-- <a
                          v-if="$gate.isAdminOrUserOrAuthor()"
                          @click="editModal4(asset)"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="For Re-issue"
                        >-->
                        <!-- <i class="material-icons fas fa-recycle green"></i> -->
                        <!-- <i class="material-icons">add</i> -->
                        <!-- </a> -->
                        <!-- <router-link
                          v-if="$gate.isAdminOrUserOrAuthor()"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          :to="{name: 'par', params: { id: asset.id }}"
                        >-->
                        <!-- <router-link v-show="asset.price>15000" :to="`${asset.id}`"> -->
                        <!-- <i
                            class="material-icons fas fa-print"
                            data-toggle="tooltip"
                            data-placement="bottom"
                            title="Print IIRUP"
                          ></i>
                        </router-link>-->

                        <!-- <a
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          href="#"
                          @click="deleteAsset(asset.id)"
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Disposed"
                        >
                          <i class="material-icons fas fa-trash red"></i>
                        </!-->
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <div>
                <p
                  id="showEntries"
                >Showing {{assets.from}} to {{assets.to}} of {{assets.total}} entries</p>

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
    <div v-if="!$gate.isAdminOrUserOrAuthorOrEmployee()">
      <NotFound></NotFound>
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
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Request For Returned</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset2() : createAsset()">
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
                    readonly
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
                  :readonly="!$gate.isEmployee()"
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
                    readonly
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
                    readonly
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
                    readonly
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
                    :readonly="!$gate.isEmployee()"
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
              </div>
              <div class="row">
                <!-- firt col -->
                <div class="col form-group">
                  <label>Total Value</label>
                  <input
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                  <input
                    readonly
                    class="form-control"
                    id="account_name"
                    name="account_name"
                    placeholder="Please select Account"
                    v-model="form.account_name"
                    :class="{'is-invalid': form.errors.has('account_name')}"
                  />
                </div>
              </div>
              <!-- <div class="row">
                <div class="col form-group">
                  <label>Purpose</label>
                  <textarea
                    class="form-control"
                    id="comments"
                    name="comments"
                    placeholder="Please input reason for return"
                    v-model="form.comments"
                    :class="{'is-invalid': form.errors.has('comments')}"
                  />
                </div>
              </div>-->
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
              <!-- <button
                v-if="$gate.isAdminOrUserOrAuthor()"
                v-show="editmode"
                @click="approvedStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-thumbs-up">&nbsp;</i>Approved
              </button>-->
              <!-- <button
                :disabled="noremarks"
                v-show="editmode"
                @click="cancelStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-undo">&nbsp;</i>Cancel
              </button>-->
              <button
                v-if="$gate.isEmployee()"
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen"></i>&nbsp;Update
              </button>

              <!-- <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update RPCPPE
              </button>-->
              <!-- <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add RPCPPE
              </button>-->
              <button
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
      id="addNew3"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Request For Transfer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset3() : createAsset()">
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
              </div>
              <div class="row">
                <!-- firt col -->
                <div class="col form-group">
                  <label>Total Value</label>
                  <input
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                  <input
                    readonly
                    class="form-control"
                    id="account_name"
                    name="account_name"
                    placeholder="Please select Account"
                    v-model="form.account_name"
                    :class="{'is-invalid': form.errors.has('account_name')}"
                  />
                </div>
              </div>
              <!-- <div class="row">
                <div class="col form-group">
                  <label>Purpose</label>
                  <textarea
                    class="form-control"
                    id="comments"
                    name="comments"
                    placeholder="Please input reason for return"
                    v-model="form.comments"
                    :class="{'is-invalid': form.errors.has('comments')}"
                  />
                </div>
              </div>-->
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
                <i class="fas fa-thumbs-up">&nbsp;</i>For Transfer
              </button>
              <!-- <button
                :disabled="noremarks"
                v-show="editmode"
                @click="cancelStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-undo">&nbsp;</i>Cancel
              </button>-->
              <button
                v-if="$gate.isEmployee()"
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen"></i>&nbsp;Update
              </button>

              <!-- <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update RPCPPE
              </button>-->
              <!-- <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add RPCPPE
              </button>-->
              <button
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
      id="addNew4"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="editmode" class="modal-title" id="addNewModalLabel">Request For Returned</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateAsset4() : createAsset()">
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
              </div>
              <div class="row">
                <!-- firt col -->
                <div class="col form-group">
                  <label>Total Value</label>
                  <input
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                    readonly
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
                  <input
                    readonly
                    class="form-control"
                    id="account_name"
                    name="account_name"
                    placeholder="Please select Account"
                    v-model="form.account_name"
                    :class="{'is-invalid': form.errors.has('account_name')}"
                  />
                </div>
              </div>
              <!-- <div class="row">
                <div class="col form-group">
                  <label>Purpose</label>
                  <textarea
                    class="form-control"
                    id="comments"
                    name="comments"
                    placeholder="Please input reason for return"
                    v-model="form.comments"
                    :class="{'is-invalid': form.errors.has('comments')}"
                  />
                </div>
              </div>-->
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
                @click="forReissue()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-thumbs-up">&nbsp;</i>For Re-issue
              </button>
              <!-- <button
                :disabled="noremarks"
                v-show="editmode"
                @click="cancelStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-undo">&nbsp;</i>Cancel
              </button>-->
              <button
                v-if="$gate.isEmployee()"
                v-show="editmode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-pen"></i>&nbsp;Update
              </button>

              <!-- <button v-show="editmode" type="submit" class="update-create btn">
                <i class="fas fa-pen">&nbsp;</i>Update RPCPPE
              </button>-->
              <!-- <button v-show="!editmode" type="submit" class="update-create btn btn-primary">
                <i class="fas fa-plus">&nbsp;</i>Add RPCPPE
              </button>-->
              <button
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
      accountable_officers: {},
      profiles: {},
      assets: {},
      total_assets: {},
      total_disposals: {},
      article_categories: {},
      assetCount: null,
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
        property_type: "",
        transfer_to: "",
        transfer_to_designation: "",
        received_from: ""
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

    //------------------------Take Note----------this is a used function---------
    updateAsset2() {
      this.$Progress.start();
      // let request1 = this.form.post("api/asset/");
      this.form
        .put("api/transfer/" + this.form.id)
        // let request2 = this.form.put("api/asset/" + this.form.id);
        // this.form
        //   .put("api/asset/" + this.form.id)
        // $.when(request1, request2)
        .then(() => {
          $("#addNew2").modal("hide");
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
    updateAsset3() {
      this.$Progress.start();
      let request1 = this.form.post("api/asset");
      let request2 = this.form.put("api/transfer/" + this.form.id);
      // let request2 = this.form.put("api/asset/" + this.form.id);
      // this.form
      //   .put("api/asset/" + this.form.id)
      $.when(request1, request2)
        .then(() => {
          $("#addNew3").modal("hide");
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
    updateAsset4() {
      this.$Progress.start();
      let today = new Date();
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      let createdby = this.profiles.id;
      today = yyyy;
      let totalDisposal = this.total_disposals + 1;
      this.form.number =
        "IIRUP-" + today + "-" + createdby + "-" + totalDisposal;
      let request1 = this.form.post("api/re-issue");
      let request2 = this.form.put("api/return-request/" + this.form.id);
      $.when(request1, request2)
        .then(() => {
          $("#addNew4").modal("hide");
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
    getStatus() {
      this.assets.data.status == "seen";
    },
    noAvailable() {
      this.form.remarks = "No Available / Insuficient Quantity";
    },
    forprocessing() {
      this.form.remarks = "For Processing";
    },
    forrelease() {
      this.form.remarks = "Ready for Release";
    },
    forReissue() {
      let today = new Date();
      let yyyy = String(today.getFullYear()).padStart(1, "0");
      let createdby = this.profiles.id;
      today = yyyy;
      let totalDisposal = this.total_disposals + 1;
      this.form.number =
        "IIRUP-" + today + "-" + createdby + "-" + totalDisposal;
      this.form.createdBy = this.profiles.id;
      this.form.status = "forReissue";
      this.form.remarks = "Serviceable";
    },
    approvedStatus() {
      this.form.status = "approved";
      this.form.createdBy = this.profiles.id;
      this.form.remarks = "Transferred from" + " " + this.form.received_from;
      //   this.form.received_from = this.form.accountable_officer;
      //   this.form.accountable_officer = this.form.transfer_to;
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
      axios.get("api/return-request?page=" + page).then(response => {
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
    editModal2(asset) {
      this.editmode = true;
      this.form.reset();
      this.form.clear();
      $("#addNew2").modal("show");
      this.form.fill(asset);
    },
    editModal3(asset) {
      this.editmode = true;
      this.form.reset();
      this.form.clear();
      $("#addNew3").modal("show");
      this.form.fill(asset);
    },
    editModal4(asset) {
      this.editmode = true;
      this.form.reset();
      this.form.clear();
      $("#addNew4").modal("show");
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
    loadTotalDisposal() {
      axios
        .get("api/total_disposal")
        .then(({ data }) => (this.total_disposals = data));
    },
    // LoadUser to display in the tbody
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthorOrEmployee()) {
        axios.get("api/transfer").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadTotals() {
      axios
        .get("api/total_assets")
        .then(({ data }) => (this.total_assets = data));
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
      this.form.service = this.profiles.service;
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
    this.$Progress.start();
    this.loadAssets();
    this.loadUsers();
    this.loadTotals();
    this.loadAcctName();
    this.loadPropertyOfficers();
    this.loadTotalDisposal();
    this.$Progress.finish();
    Fire.$on("AfterCreate", () => {
      this.loadAssets();
      this.loadTotals();
      this.loadTotalDisposal();
      this.loadAcctName();
    });
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findRequestTransfer?q=" + query)
        .then(data => {
          this.assets = data.data;
        })
        .catch(() => {});
    });
    // SetInterval Function
    // setInterval(() => this.loadAssets(), 5000);
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
  -webkit-border-radius: 0px !important;
  -moz-border-radius: 0px !important;
  border-radius: 0px !important;
}
.modal-content {
  -webkit-border-radius: 0px !important;
  -moz-border-radius: 0px !important;
  border-radius: 0px !important;
}
.form-control {
  border-radius: 0;
}
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
.view_action {
  font-size: 12px;
  text-align: center;
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
/* .mdl-btn {
  background-color: #fff;
}
.mdl-btn:hover {
  background-color: #ececec;
} */
#showEntries {
  padding-bottom: 10px;
}
/* #requestedPropertyvue {
  font-size: 11px;
} */
#description {
  height: 160px;
}
.btn-danger {
  margin-top: -1px;
}
</style>


// Command for this (npm run watch && php artisan serve)
