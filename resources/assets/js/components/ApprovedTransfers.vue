<template>
  <div class>
    <!-- For Admin -->
    <div id="card-content" class="card row mt-4" v-if="$gate.isAdminOrUserOrAuthorOrEmployee()">
      <div id="rpcppe" class="card-header">
        <h3
          data-toggle="tooltip"
          data-placement="bottom"
          title="Serviceable items ready for re-issue"
          class="card-title mt-1 text-white"
        >
          <i class="fas fa-recycle">&nbsp;</i>FOR RE-ISSUE
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
                    <th width="5%">PROPERTY #</th>
                    <th>UNIT</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>TOTAL VALUE</th>
                    <th>DATE</th>
                    <th v-if="!$gate.isEmployee()">RECEIVED FROM</th>
                    <th>TRANSFER TO</th>
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
                      <td
                        colspan="15"
                        class="text-center"
                      >No Report on Physical Count of Property Plant and Equipment Available</td>
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
                      <td v-if="!$gate.isEmployee()">{{asset.received_from | upText}}</td>
                      <td>{{asset.transfer_to | upText}}</td>
                      <td v-if="$gate.isAdminOrAuthor()">{{asset.account_name | upText}}</td>
                      <td>{{asset.status | upText}}</td>
                      <!-- <td>
                        <span
                          v-if="asset.remarks=='For Returned'"
                          class="badge badge-pill badge-danger"
                        >{{asset.remarks }}</span>
                        <span
                          v-if="asset.remarks=='Cancel Returned'"
                          class="badge badge-pill badge-dark"
                      >{{asset.remarks }}</span>-->
                      <!-- <span v-else>{{asset.remarks}}</span> -->
                      <!-- </!-->
                      <!-- <td>{{asset.status | upText}}</td> -->
                      <!-- <td>{{asset.property_type | upText}}</td> -->
                      <td>
                        <router-link
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Print IIRUP"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          v-show="asset.price>15000"
                          :to="{name: 'par', params: { id: asset.id }}"
                        >
                          <!-- <router-link v-show="asset.price>15000" :to="`${asset.id}`"> -->
                          <i class="material-icons fas fa-print"></i>
                        </router-link>
                        <router-link
                          data-toggle="tooltip"
                          data-placement="bottom"
                          title="Print IIRP"
                          class="mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
                          v-show="asset.price<=15000"
                          :to="`${asset.id}`"
                        >
                          <i class="material-icons fas fa-print"></i>
                        </router-link>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
              <p
                id="showEntries"
              >Showing {{assets.from}} to {{assets.to}} of {{assets.total}} entries</p>
              <div id="footer">
                <pagination class="float-right" :data="assets" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
          </div>
          <!-- start the pagination -->
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- End for Admin -->
    <!-- /.row -->
    <div v-if="!$gate.isAdminOrUserOrAuthorOrEmployee()">
      <NotFound></NotFound>
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
      total_disposals: {},
      total_assets: {},
      total_inventories: {},
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
        status: "pending",
        property_type: "PAR",
        designation: ""
      })
    };
  },
  // Computed Properties
  computed: {},

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
    getResults(page = 1) {
      axios.get("api/approved_transfer?page=" + page).then(response => {
        this.assets = response.data;
      });
    },
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
    printme() {
      window.print();
    },
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
    selectedOfficer() {
      for (let officer in this.accountable_officers.data) {
        this.selected_officer = this.accountable_officers.data[
          officer
        ].designation;
      }
    },
    // LoadUser to display in the tbody
    loadAssets() {
      if (this.$gate.isAdminOrUserOrAuthorOrEmployee()) {
        axios
          .get("api/approved_transfer")
          .then(({ data }) => (this.assets = data)); //Remove the previous (this.users =data.data) into data only
      }
    }
  },

  created() {
    this.$Progress.start();
    this.loadAssets();
    this.$Progress.finish();
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findApprovedTransfer?q=" + query)
        .then(data => {
          this.assets = data.data;
        })
        .catch(() => {});
    });
    // SetInterval Function
    // setInterval(() => this.loadUsers(), 3000);
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
.update-create:hover {
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
.material-icons {
  font-size: 15px;
}
/* .mdl-btn {
  background-color: #ececec;
} */
.badge {
  font-size: 11px;
}
.btn-danger {
  margin-top: -5px;
}
</style>


// Command for this (npm run watch && php artisan serve)
