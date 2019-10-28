<template>
  <!-- For Employee -->
  <div id="card-content" class="card row mt-4" v-if="$gate.isEmployee()">
    <div id="rpcppe" class="card-header">
      <h3 class="card-title mt-1 text-white">
        <i class="fas fa-list-ol"></i> &nbsp;
        LIST OF ACCOUNTABILITIES
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
              class="table table-bordered dataTable"
              role="grid"
              aria-describedby="example2_info"
            >
              <tbody></tbody>
              <tbody>
                <tr class>
                  <!-- <th>ID</th> -->
                  <th>ARTICLE</th>
                  <th width="30%">DESCRIPTION</th>
                  <th class="text-center">PROPERTY #</th>
                  <th class="text-center">UNIT</th>
                  <th class="text-center">PRICE</th>
                  <th class="text-center">QTY</th>
                  <th class="text-center">TOTAL COST</th>
                  <th class="text-center">DATE</th>
                  <!-- <th class="text-center">REMARKS</th> -->
                  <th class="text-center">ACTION</th>
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
                    <td class="text-center">{{asset.property_number}}</td>
                    <td class="text-center">{{asset.unit_of_measure}}</td>
                    <td class="text-right">{{asset.price | numberComma }}</td>
                    <td class="text-center">{{asset.quantity | numberComma}}</td>
                    <td class="text-right">{{asset.total_value | numberComma}}</td>
                    <td class="text-center">{{asset.date | myDate}}</td>
                    <!-- <td class="text-center">{{asset.remarks }}</td> -->
                    <td class="text-center">
                      <a
                        href="#"
                        @click="transferModal(asset)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Transfer Accountability"
                        class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                      >
                        <i class="material-icons fas fa-exchange-alt"></i>
                      </a>
                      <a
                        href="#"
                        @click="transferModal2(asset)"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Request for Returned"
                        class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                      >
                        <i class="material-icons fas fa-recycle red"></i>
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
            <h5 v-show="transfermode" class="modal-title" id="addNewModalLabel">Request for Transfer</h5>
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
                <label class="descLabel">Description</label>
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
              <div class="row">
                <div class="col form-group">
                  <label>For Transfer to</label>
                  <select
                    v-model="form.transfer_to"
                    type="text"
                    id="transfer_to"
                    placeholder="Accountable Officer"
                    name="transfer_to"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('transfer_to') }"
                  >
                    <option value>Select Accountable Officer</option>
                    <option
                      v-for="officer in accountable_officers.data"
                      :key="officer.id"
                    >{{officer.name}}</option>
                  </select>
                  <has-error :form="form" field="transfer_to"></has-error>
                </div>
                <div class="col form-group">
                  <label>Designation of Receiving Officer</label>
                  <select
                    v-model="form.transfer_to_designation"
                    type="text"
                    id="transfer_to_designation"
                    placeholder="Designation"
                    name="transfer_to_designation"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('transfer_to_designation') }"
                  >
                    <option value>Select Designation</option>
                    <option
                      v-for="officer in accountable_officers.data"
                      :key="officer.id"
                    >{{officer.designation}}</option>
                  </select>
                  <has-error :form="form" field="transfer_to_designation"></has-error>
                </div>
                <!-- <div class="col form-group" v-show="false">
                  <label>Received From</label>
                  <input
                    readonly
                    class="form-control"
                    id="received_from"
                    name="received_from"
                    placeholder="Please select Account"
                    v-model="form.received_from"
                    :class="{'is-invalid': form.errors.has('received_from')}"
                  />
                  <has-error :form="form" field="received_from"></has-error>
                </div>-->
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
                @click="transferAccountability()"
                v-show="transfermode"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-exchange-alt">&nbsp;</i>For Transfer
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
      <!-- <div class="errors" v-if="errors">
        <ul>
          <li v-for="(fieldError, fieldName) in errors" :key="fieldName">
            <strong>{{ fieldName }}</strong>
            {{ fieldError.join('\n') }}
          </li>
        </ul>
      </div>-->
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
            <h5 v-show="!transfermode" class="modal-title" id="addNewModalLabel">Add New</h5>
            <h5 v-show="transfermode" class="modal-title" id="addNewModalLabel">Request For Returned</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="modal-close-button" aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="transfermode ? updateAsset2() : createAsset()">
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
                <label class="descLabel">Description</label>
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
                v-show="transfermode"
                @click="approvedStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-thumbs-up">&nbsp;</i>Approved
              </button>
              <!-- <button
                :disabled="noremarks"
                v-show="transfermode"
                @click="cancelStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-undo">&nbsp;</i>Cancel
              </button>-->
              <!-- <button
                :disabled="noremarks"
                v-show="transfermode"
                @click="cancelStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-undo">&nbsp;</i>Cancel
              </button>-->
              <button
                v-show="transfermode"
                @click="returnedStatus()"
                type="submit"
                class="update-create mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect"
              >
                <i class="fas fa-recycle">&nbsp;</i>For Returned
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
      <!-- <div class="errors" v-if="errors">
        <ul>
          <li v-for="(fieldError, fieldName) in errors" :key="fieldName">
            <strong>{{ fieldName }}</strong>
            {{ fieldError.join('\n') }}
          </li>
        </ul>
      </div>-->
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
      profiles: {},
      transfermode: false,
      accountable_officers: {},
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
        received_from: "",
        comments: "",
        null: ""
      })
    };
  },
  computed: {
    noremarks() {
      return this.form.remarks === null || !this.form.remarks;
    }
    // disabled() {
    //   return this.form.comments === null || !this.form.comments;
    // }
    // disabledCancel() {
    //   return this.form.remarks === "Cancel Returned";
    // }
  },
  methods: {
    loadUsers() {
      axios.get("api/profile").then(({ data }) => (this.profiles = data));
    },
    getResults(page = 1) {
      axios.get("api/accountabilities?page=" + page).then(response => {
        this.assets = response.data;
      });
    },
    returnedStatus() {
      this.form.remarks = "For Returned";
    },
    cancelStatus() {
      this.form.remarks = "Cancel Returned";
    },
    setShowDate(d) {
      this.showDate = d;
    },
    transferAccountability() {
      this.form.remarks = "For Transfer";
      this.form.status = "ForTransfer";
      this.form.createdBy = this.profiles.id;
      this.form.received_from = this.form.accountable_officer;
      this.form.accountable_officer = this.form.transfer_to;
    },
    updateAsset() {
      this.$Progress.start();
      this.form
        .post("api/transfer")
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
    updateAsset2() {
      this.$Progress.start();
      this.form.createdBy = this.profiles.id;
      this.form.property_type = "IIRUP";
      this.form.status = "processing";
      this.form
        .post("api/disposal")
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
    loadAssets() {
      if (this.$gate.isEmployee()) {
        axios
          .get("api/accountabilities")
          .then(({ data }) => (this.assets = data));
      }
    },
    loadAccountableOfficers() {
      axios
        .get("api/accountable_officer")
        .then(({ data }) => (this.accountable_officers = data)); //Remove the previous (this.users =data.data) into data only
    },
    transferModal(asset) {
      this.transfermode = true;
      $("#addNew").modal("show");
      this.form.fill(asset);
    },
    transferModal2(asset) {
      this.transfermode = true;
      $("#addNew2").modal("show");
      this.form.fill(asset);
    }
  },

  created() {
    this.loadAssets();
    this.loadAccountableOfficers();
    this.loadUsers();
    Fire.$on("AfterCreate", () => {
      this.loadAssets();
    });
    // setInterval(() => this.loadAssets(), 5000);
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
/* .mdl-btn {
  background-color: #ececec;
} */
.modal-close-button {
  color: white;
}
.modal-header {
  background: rgb(22, 70, 143);
  color: aliceblue;
  -webkit-border-radius: 0px;
  -moz-border-radius: 0px;
  border-radius: 0px;
}
.modal-content {
  -webkit-border-radius: 0px;
  -moz-border-radius: 0px;
  border-radius: 0px;
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
.descLabel {
  margin-top: 80px;
}
#description {
  height: 160px;
  margin-top: 20px;
}
</style>