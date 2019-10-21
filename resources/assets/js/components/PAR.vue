<template>
  <div class="container">
    <template v-if="assets.asset.property_type=='PAR'">
      <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <div class="widget-user-header">
                  <img src="/img/Header.png" width="65%" style="margin-left: 17%;" />
                  <!-- <img src="/img/example-logo.jpg" width="65%" style="margin-left: 17%;" /> -->
                </div>
                <p
                  style="font-family:Palatino Linotype; font-size:18px; text-align:center; text-decoration: underline; "
                >
                  <strong>PROPERTY ACKNOWLEDGEMENT RECEIPT</strong>
                </p>
                <div>
                  <p style="font-family:Palatino Linotype; font-size:16px; text-align:left; ">
                    <strong>Entity Name:</strong> DICT
                  </p>
                  <p style="font-family:Palatino Linotype; font-size:16px;  ">
                    <strong>Fund Cluster:</strong>
                    <strong class="float-right" style="text-align:right;">
                      PAR No:
                      <u>{{assets.asset.number}}</u>
                    </strong>
                  </p>
                </div>
              </div>
              <!-- /.col -->
            </div>

            <!-- Table row -->
            <div class="row">
              <div
                class="card-body table-responsive p-1"
                style="text-align:center; font-size:16px;"
              >
                <table border="1" id="table">
                  <tbody class="tablebody">
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="8%">Qty.</th>
                      <th width="8%">Unit</th>
                      <th width="30%">Description</th>
                      <th width="14%">Property No.</th>
                      <th width="10%">Date Acquired</th>
                      <th width="15%">Unit Cost</th>
                      <th width="15%">Total Cost</th>
                    </tr>
                  </tbody>
                  <tbody class="tablebody">
                    <tr v-for="asset in assets" :key="asset.id">
                      <td>{{ asset.quantity | numberComma }}</td>
                      <td>{{ asset.unit_of_measure }}</td>
                      <td class="text-left">{{ asset.description }}</td>
                      <td>{{ asset.property_number }}</td>
                      <td>{{ asset.date | myDate }}</td>
                      <td>{{ asset.price | numberComma }}</td>
                      <td>{{ asset.total_value | numberComma }}</td>
                    </tr>
                  </tbody>
                </table>
                <p class="tablebody">
                  x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x
                  <i>NOTHING FOLLOWS x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x</i>
                </p>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <!-- accepted payments column -->
              <div class="col-6">
                <p class="lead" style="margin-top: 50px;">
                  <i>Received by:</i>
                </p>
                <p class="receiving-side" style="margin-top: 50px;  ">
                  <strong class="underline-text">{{assets.asset.accountable_officer}}</strong>
                  <br />Signature over Printed Name of End User
                </p>
                <p class="receiving-side" style="margin-top: 30px;  ">
                  <strong class="underline-text">{{assets.asset.service}}</strong>
                  <br />Position / Office
                </p>
                <p class="receiving-side" style="margin-top: 10px;">
                  <span class="underline-text">{{assets.asset.date}}</span>
                  <br />Date
                </p>
              </div>
              <!-- 2nd Column -->
              <template v-if="assets.asset.received_from==null">
                <div class="col-6" v-for="property in property_officers.data" :key="property.id">
                  <p class="lead" style="margin-top: 50px;">
                    <i>Received from:</i>
                  </p>
                  <p class="receiving-side" style="margin-top: 50px;  ">
                    <strong class="underline-text">{{property.name}}</strong>
                    <br />Signature over Printed Name
                  </p>
                  <p class="receiving-side mdl-selectfield__box" style="margin-top: 30px;  ">
                    <strong class="underline-text">{{property.designation}}</strong>
                    <br />Position / Office
                  </p>
                  <p class="receiving-side" style="margin-top: 10px;">
                    <span class="underline-text">{{assets.asset.date}}</span>
                    <br />Date
                  </p>
                </div>
              </template>
              <template v-else>
                <div class="col-6">
                  <p class="lead" style="margin-top: 50px;">
                    <i>Received from:</i>
                  </p>
                  <p class="receiving-side" style="margin-top: 50px;  ">
                    <strong class="underline-text">{{assets.asset.received_from}}</strong>
                    <br />Signature over Printed Name
                  </p>
                  <p class="receiving-side mdl-selectfield__box" style="margin-top: 30px;  ">
                    <strong class="underline-text">{{assets.asset.received_from}}</strong>
                    <br />Position / Office
                  </p>
                  <p class="receiving-side" style="margin-top: 10px;">
                    <span class="underline-text">{{assets.asset.date}}</span>
                    <br />Date
                  </p>
                </div>
              </template>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href @click.prevent="printme" target="_blank" class="btn btn-default">
                  <i class="fa fa-print"></i> Print
                </a>
                <!-- <button type="button" class="btn btn-success float-right">
                <i class="fa fa-credit-card"></i>
                Submit Payment
                </button>-->

                <button
                  type="button"
                  class="btn btn-primary float-right"
                  style="margin-right: 5px; "
                >
                  <!-- <i @click.prevent="exportPDF" class="fa fa-download"></i> Generate PDF -->

                  <router-link to="/assets" class="router">
                    <i class="rpcppe-btn fas fa-undo">&nbsp;</i>Back to RPCPPE
                  </router-link>
                </button>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div>
      </div>
    </template>
    <template v-if="assets.asset.property_type=='INVENTORY'">
      <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <div class="widget-user-header">
                  <img src="/img/Header.png" width="65%" style="margin-left: 17%;" />
                  <!-- <img src="/img/example-logo.jpg" width="65%" style="margin-left: 17%;" /> -->
                </div>
                <p
                  style="font-family:Palatino Linotype; font-size:18px; text-align:center; text-decoration: underline; "
                >
                  <strong>INVENTORY CUSTODIAN SLIP</strong>
                </p>
                <div>
                  <p style="font-family:Palatino Linotype; font-size:16px; text-align:left; ">
                    <strong>Entity Name:</strong> DICT
                  </p>
                  <p style="font-family:Palatino Linotype; font-size:16px;  ">
                    <strong>Fund Cluster:</strong>
                    <strong class="float-right" style="text-align:right;">
                      ICS No:
                      <u>{{assets.asset.number}}</u>
                    </strong>
                  </p>
                </div>
              </div>
              <!-- /.col -->
            </div>

            <!-- Table row -->
            <div class="row">
              <div
                class="card-body table-responsive p-1"
                style="text-align:center; font-size:16px;"
              >
                <table border="1" id="table">
                  <tbody class="tablebody">
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="8%">Qty.</th>
                      <th width="8%">Unit</th>
                      <th width="30%">Description</th>
                      <th width="14%">Property No.</th>
                      <th width="10%">Date Acquired</th>
                      <th width="15%">Unit Cost</th>
                      <th width="15%">Total Cost</th>
                    </tr>
                  </tbody>
                  <tbody class="tablebody">
                    <tr v-for="asset in assets" :key="asset.id">
                      <td>{{ asset.quantity | numberComma }}</td>
                      <td>{{ asset.unit_of_measure }}</td>
                      <td class="text-left">{{ asset.description }}</td>
                      <td>{{ asset.property_number }}</td>
                      <td>{{ asset.date | myDate }}</td>
                      <td>{{ asset.price | numberComma }}</td>
                      <td>{{ asset.total_value | numberComma }}</td>
                    </tr>
                  </tbody>
                </table>
                <p class="tablebody">
                  x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x
                  <i>NOTHING FOLLOWS x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x</i>
                </p>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-6">
                <p class="lead" style="margin-top: 50px;">
                  <i>Received by:</i>
                </p>
                <p class="receiving-side" style="margin-top: 50px;  ">
                  <strong class="underline-text">{{assets.asset.accountable_officer}}</strong>
                  <br />Signature over Printed Name of End User
                </p>
                <p class="receiving-side" style="margin-top: 30px;  ">
                  <strong class="underline-text">{{assets.asset.service}}</strong>
                  <br />Position / Office
                </p>
                <p class="receiving-side" style="margin-top: 10px;">
                  <span class="underline-text">{{assets.asset.date}}</span>
                  <br />Date
                </p>
              </div>
              <!-- 2nd Column -->
              <div class="col-6" v-for="property in property_officers.data" :key="property.id">
                <p class="lead" style="margin-top: 50px;">
                  <i>Received from:</i>
                </p>
                <p class="receiving-side" style="margin-top: 50px;  ">
                  <strong class="underline-text">{{property.name}}</strong>
                  <br />Signature over Printed Name
                </p>
                <p class="receiving-side mdl-selectfield__box" style="margin-top: 30px;  ">
                  <strong class="underline-text">{{property.designation}}</strong>
                  <br />Position / Office
                </p>
                <p class="receiving-side" style="margin-top: 10px;">
                  <span class="underline-text">{{assets.asset.date}}</span>
                  <br />Date
                </p>
              </div>
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href @click.prevent="printme" target="_blank" class="btn btn-default">
                  <i class="fa fa-print"></i> Print
                </a>
                <!-- <button type="button" class="btn btn-success float-right">
                <i class="fa fa-credit-card"></i>
                Submit Payment
                </button>-->

                <button
                  type="button"
                  class="btn btn-primary float-right"
                  style="margin-right: 5px; "
                >
                  <!-- <i @click.prevent="exportPDF" class="fa fa-download"></i> Generate PDF -->

                  <router-link to="/assets" class="router">
                    <i class="rpcppe-btn fas fa-undo">&nbsp;</i>Back to RPCPPE
                  </router-link>
                </button>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div>
      </div>
    </template>
    <template v-if="assets.asset.property_type=='IIRUP'">
      <div class="mt-3 row justify-content-center">
        <div class="col-md-12">
          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <div class="widget-user-header">
                  <img src="/img/Header.png" width="65%" style="margin-left: 17%;" />
                  <!-- <img src="/img/example-logo.jpg" width="65%" style="margin-left: 17%;" /> -->
                </div>
                <p
                  style="font-family:Palatino Linotype; font-size:18px; text-align:center; text-decoration: underline; "
                >
                  <strong>RETURN SLIP FOR PROPERTY, PLANT AND EQUIPMENT</strong>
                </p>
                <div>
                  <p
                    style="font-family:Palatino Linotype; font-size:18px; text-align:left; margin-top: 50px;"
                  >
                    <strong>MEMORANDUM:</strong>
                  </p>
                  <p style="font-family:Palatino Linotype; font-size:18px;">
                    <strong>FOR: The Officer-in-Charge, Asset and Property Section</strong>
                  </p>
                  <p style="font-family:Palatino Linotype; font-size:18px;">
                    <strong style="text-align:left;">FROM: {{assets.asset.accountable_officer}}</strong>
                  </p>
                </div>
                <div>
                  <p
                    style="font-family:Palatino Linotype; font-size:18px; text-align: justify"
                  >Please be advised that we are returning the items listed hereunder for as stated. A copy of the signed Property Acknowledgement Receipt (PAR) is likewise attached for your ready reference. Please make the necessary adjustment in our records of property accountability.</p>
                </div>
              </div>
              <!-- /.col -->
            </div>

            <!-- Table row -->
            <div class="row">
              <div
                class="card-body table-responsive p-1"
                style="text-align:center; font-size:16px;"
              >
                <table border="1" id="table">
                  <tbody class="tablebody">
                    <tr>
                      <!-- <th>ID</th> -->
                      <th width="8%">Qty.</th>
                      <th width="8%">Unit</th>
                      <th width="30%">Description</th>
                      <th width="14%">Memo Receipt</th>
                      <th width="10%">Date Acquired</th>
                      <th width="15%">Unit Cost</th>
                      <th width="15%">Total Cost</th>
                    </tr>
                  </tbody>
                  <tbody class="tablebody">
                    <tr v-for="asset in assets" :key="asset.id">
                      <td>{{ asset.quantity | numberComma }}</td>
                      <td>{{ asset.unit_of_measure }}</td>
                      <td class="text-left">{{ asset.description }}</td>
                      <td>{{ asset.property_number }}</td>
                      <td>{{ asset.date | myDate }}</td>
                      <td>{{ asset.price | numberComma }}</td>
                      <td>{{ asset.total_value | numberComma }}</td>
                    </tr>
                  </tbody>
                </table>
                <p class="tablebody">
                  x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x
                  <i>NOTHING FOLLOWS x-x-x-x-x-x-x-x-x-x-x-x-x-x-x-x</i>
                </p>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
              <div class="col-4">
                <p class="lead" style="margin-top: 50px;">
                  <strong>RETURNED BY:</strong>
                </p>
                <p class="receiving-side" style="margin-top: 50px;  ">
                  <strong class="underline-text">{{assets.asset.accountable_officer}}</strong>
                  <br />Signature over Printed Name of End User
                </p>
                <p class="receiving-side" style="margin-top: 30px;  ">
                  <strong class="underline-text">{{assets.asset.service}}</strong>
                  <br />Position / Office
                </p>
                <p class="receiving-side" style="margin-top: 10px;">
                  <span class="underline-text">{{assets.asset.date}}</span>
                  <br />Date
                </p>
              </div>
              <!-- 2nd Column -->
              <div class="col-4" v-for="property in property_officers.data" :key="property.id">
                <p class="lead" style="margin-top: 50px;">
                  <strong>RECEIVED BY:</strong>
                </p>
                <p class="receiving-side" style="margin-top: 50px;  ">
                  <strong class="underline-text">{{property.name}}</strong>
                  <br />Signature over Printed Name
                </p>
                <p class="receiving-side mdl-selectfield__box" style="margin-top: 30px;  ">
                  <strong class="underline-text">{{property.designation}}</strong>
                  <br />Position / Office
                </p>
                <p class="receiving-side" style="margin-top: 10px;">
                  <span class="underline-text">{{assets.asset.date}}</span>
                  <br />Date
                </p>
              </div>
              <div class="col-4" v-for="property in property_officers.data" :key="property.id">
                <p class="lead" style="margin-top: 50px;">
                  <strong>NOTED BY:</strong>
                </p>
                <p class="receiving-side" style="margin-top: 50px;  ">
                  <strong class="underline-text">{{property.name}}</strong>
                  <br />Signature over Printed Name
                </p>
                <p class="receiving-side mdl-selectfield__box" style="margin-top: 30px;  ">
                  <strong class="underline-text">{{property.designation}}</strong>
                  <br />Position / Office
                </p>
                <p class="receiving-side" style="margin-top: 10px;">
                  <span class="underline-text">{{assets.asset.date}}</span>
                  <br />Date
                </p>
              </div>
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href @click.prevent="printme" target="_blank" class="btn btn-default">
                  <i class="fa fa-print"></i> Print
                </a>
                <!-- <button type="button" class="btn btn-success float-right">
                <i class="fa fa-credit-card"></i>
                Submit Payment
                </button>-->

                <button
                  type="button"
                  class="btn btn-primary float-right"
                  style="margin-right: 5px; "
                >
                  <!-- <i @click.prevent="exportPDF" class="fa fa-download"></i> Generate PDF -->

                  <router-link to="/assets" class="router">
                    <i class="rpcppe-btn fas fa-undo">&nbsp;</i>Back to RPCPPE
                  </router-link>
                </button>
              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div>
      </div>
    </template>
  </div>
</template>

<script>
export default {
  name: "par-view",
  data() {
    return {
      show: false,
      assets: {},
      property_officers: {},
      form: new Form({
        received_from: ""
      })
    };
  },
  methods: {
    loadPropertyOfficers() {
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios
          .get("api/property_officer")
          .then(({ data }) => (this.property_officers = data)); //Remove the previous (this.users =data.data) into data only
      }
    },
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
        axios
          .get(`api/asset/${this.$route.params.id}`)
          .then(({ data }) => (this.assets = data));
      }
    },
    // loadForReissue() {
    //   if (this.$gate.isAdminOrUserOrAuthorOrSupply()) {
    //     axios
    //       .get(`api/re-issue/${this.$route.params.id}`)
    //       .then(({ data }) => (this.assets = data));
    //   }
    // },
    printme() {
      window.print();
    },
    exportPDF() {
      var doc = new jsPDF();
      doc.save("test.pdf");
    }
  },
  created() {
    // this.loadForReissue();
    this.loadPropertyOfficers();
    this.loadAssets();
  }
};
</script>

<style>
.router:hover {
  color: aliceblue;
}
.router {
  color: aliceblue;
}

@media print {
  .nav.nav-tabs li:not(.active) {
    display: none;
  }
  .invoice {
    padding: 10px 20px;
  }

  .invoice {
    background-position: center center;
    background-repeat: no-repeat;
  }
  .table-responsive table {
    background-color: transparent !important;
  }
}

@page {
  margin: 0;
}
.widget-user-header {
  background-position: center center;
  background-size: 100%;
  height: auto !important;
  width: 100%;
  background-repeat: no-repeat;
}
.widget-user .card-footer {
  padding: 0;
}
#table {
  font-family: Palatino Linotype;
  font-size: 16px;
}

.tablebody {
  border-top: 1px solid black;
  border: 1px solid black;
}
.receiving-side {
  font-family: Palatino Linotype;
  font-size: 16px;
  text-align: center;
}
.underline-text {
  text-decoration: underline;
}

.lead {
  font-family: Palatino Linotype;
  font-size: 16px;
}
select {
  border: 0px;
  outline: 0px;
}
</style>

