<template>
  <div class="container">
    {{assets.property_type}}
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
                    <strong class="float-right" style="text-align:right;">PAR No:______________</strong>
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
                <p class="lead">Payment Methods:</p>
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/visa.png"
                  alt="Visa"
                />
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/mastercard.png"
                  alt="Mastercard"
                />
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/american-express.png"
                  alt="American Express"
                />
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/paypal2.png"
                  alt="Paypal"
                />

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                  plugg
                  dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
              </div>
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
                    <strong class="float-right" style="text-align:right;">PAR No:______________</strong>
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
                <p class="lead">Payment Methods:</p>
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/visa.png"
                  alt="Visa"
                />
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/mastercard.png"
                  alt="Mastercard"
                />
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/american-express.png"
                  alt="American Express"
                />
                <img
                  src="https://adminlte.io/themes/dev/AdminLTE/dist/img/credit/paypal2.png"
                  alt="Paypal"
                />

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                  Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
                  plugg
                  dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
              </div>
              <!-- /.col -->
              <div class="col-6">
                <p class="lead">Amount Due 2/22/2014</p>

                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>$250.30</td>
                      </tr>
                      <tr>
                        <th>Tax (9.3%)</th>
                        <td>$10.34</td>
                      </tr>
                      <tr>
                        <th>Shipping:</th>
                        <td>$5.80</td>
                      </tr>
                      <tr>
                        <th>Total:</th>
                        <td>$265.24</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
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
  </div>
</template>

<script>
export default {
  name: "par-view",
  data() {
    return {
      show: false,
      assets: {}
    };
  },
  created() {
    if (this.$gate.isAdminOrUserOrAuthor()) {
      axios
        .get(`api/asset/${this.$route.params.id}`)
        .then(({ data }) => (this.assets = data));
    }
    // if (this.$gate.isAdminOrUserOrAuthor()) {
    //   axios.get(`api/asset/${this.$route.params.id}`).then(response => {
    //     this.assets = response.data;
    //   });
    // }
    // if (this.assets.length) {
    //   this.assets = this.asset.find(asset => asset.id == this.$route.params.id);
    // } else {
    // }
    // if (this.$gate.isAdminOrUserOrAuthor()) {
    //     axios.get("api/asset").then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
    //   }
    // this.loadAssets();
    // this.loadAssets(id);
    // this.loadAssets();
    // this.loadAssets();
    // use the authentication
    // axios
    //   .get(`api/asset/${this.$route.params.id}`)
    //   .then(({ data }) => (this.asset = data));
    // .then(response => {
    //   this.assets = response.data.assets;
    // }); //Remove the previous (this.users =data.data) into data only
  },
  // },
  methods: {
    // getResults(page = 1) {
    //   axios.get("api/asset?page=" + page).then(response => {
    //     this.accountabilities = response.data;
    //   });
    // },
    // loadAssets(id) {
    //   if (this.assets.length) {
    //     this.asset = this.assets.find(
    //       asset => asset.id == this.$route.params.id
    //     );
    //   } else {
    //     axios.get(`api/par/${this.$route.params.id}`).then(response => {
    //       this.asset = response.data.asset;
    //     });
    //   }
    // },
    // loadAssets(id) {
    //   if (this.$gate.isAdminOrUserOrAuthor()) {
    //     axios
    //       .get(`api/${this.$route.params.id}`)
    //       .then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
    //   }
    // },
    printme() {
      window.print();
    },
    exportPDF() {
      var doc = new jsPDF();
      doc.save("test.pdf");
    }
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
</style>

