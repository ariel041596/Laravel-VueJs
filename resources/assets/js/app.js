/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
// Importing vue from vue-cli and vfrom in github
import Vue from "vue";
import Vuex from "vuex";
window.Vue = require("vue");
import moment from "moment";
import { Form, HasError, AlertError } from "vform";
import VueRouter from "vue-router";
import VueProgressBar from "vue-progressbar";
import swal from "sweetalert2";
import VueNumeric from "vue-numeric";
import VueLodash from "vue-lodash";
import _ from "lodash";
import jspdf from "jspdf";
import Vuetify from "vuetify";
import StoreData from "./store";
import TextareaAutosize from "vue-textarea-autosize";

// import { routes } from './routes';
import VueAxios from "vue-axios";
import axios from "axios";
Vue.use(TextareaAutosize);
Vue.use(VueAxios, axios);

Vue.use(Vuetify);

Vue.use(Vuex);

// import mdbootstrap from 'mdbootstrap'

// import the Gate.js
import Gate from "./Gate";
// Vue prototype with the sign $ like $Progress
Vue.prototype.$gate = new Gate(window.user);
Object.defineProperty(Vue.prototype, "$_", { value: _ });

// Sweet Alert Message from sweet alert 2
window.swal = swal;

const store = new Vuex.Store(StoreData);

const toast = swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

// const options = { name: 'lodash' } // customize the way you want to call it

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

// Register the vue pagination
Vue.component("pagination", require("laravel-vue-pagination"));
// Register material design
Vue.component("material-design", require("material-design-lite"));
Vue.component("vuenumeric", require("vue-numeric"));
Vue.component("vueloadash", require("vue-lodash"));
// Vue.component('mdbootstrap', require('mdbootstrap'));
Vue.component("jspdf", require("jspdf"));
Vue.component("vuetify", require("vuetify"));

Vue.component("chat-apps", require("./components/ChatApps.vue"));
// Vue.component("chat-app", require("./components/ChatApp.vue"));

// Vue.use(VueLodash) // options is optional
// use the vue mdbootstrap in every inputs
// Vue.use(mdbootstrap)
// use the vue numeric in every inputs
// Vue.use(material - design)l
Vue.use(VueNumeric);
// use the vue router in every components or layout
Vue.use(VueRouter);
Vue.use(jspdf);
// routes for vue js

const routes = [
    { path: "/dashboard", component: require("./components/Dashboard.vue") },
    { path: "/users", component: require("./components/Users.vue") },
    { path: "/profile", component: require("./components/Profile.vue") },
    { path: "/assets", component: require("./components/Assets.vue") },
    // { path: '/developer', component: require('./components/Developer.vue') },
    { path: "/iirup", component: require("./components/IIRUP.vue") },
    { path: "/disposed", component: require("./components/AssetDisposed.vue") },
    {
        path: "/accountable-officers",
        component: require("./components/AccountOfficer.vue")
    },
    {
        path: "/account-codes",
        component: require("./components/AccountCode.vue")
    },
    { path: "/inventory", component: require("./components/ICSList.vue") },
    { path: "/pendings", component: require("./components/PendingAssets.vue") },
    { path: "/users-type", component: require("./components/UsersType.vue") },
    {
        path: "/employee-dashboard",
        component: require("./components/EmployeeDashboard.vue")
    },
    {
        path: "/requests",
        component: require("./components/RequestedProperty.vue")
    },
    {
        path: "/property-officers",
        component: require("./components/PropertyOfficer.vue")
    },
    {
        path: "/article-category",
        component: require("./components/ArticleCategory.vue")
    },
    {
        path: "/return-request",
        component: require("./components/ReturnRequestModule.vue")
    },
    { path: "/for-reissue", component: require("./components/ForReissue.vue") },
    {
        path: "/approved-transfers",
        component: require("./components/ApprovedTransfers.vue")
    },
    {
        path: "/for-transfer",
        component: require("./components/ForTransfer.vue")
    },
    // {
    //     path: "/chat",
    //     component: require("./components/ChatApps.vue")
    // },
    {
        path: "/import-data",
        component: require("./components/ImportData.vue")
    },
    { path: "/", component: require("./components/Profile.vue") },
    // { path: "/:id", name: "par", component: require("./components/PAR.vue") },
    { path: "*", component: require("./components/404NotFound.vue") }
];
// To remove the home e.g home/dashboard after the refresh page
const router = new VueRouter({
    mode: "history",
    routes //added the routes:
});

// Use this to make a filter imported from vuejs and make a capitalize letter
Vue.filter("upText", function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter("numberComma", function(x) {
    const amt = Number(x);
    return (
        (amt && amt.toLocaleString(undefined, { maximumFractionDigits: 2 })) ||
        "0"
    );
});

// Moment function | first install npm install moment --save
Vue.filter("myDate", function(created) {
    return moment(created).format("ll");
    // return moment(created).format('MM-DD-YYYY');
});

// Vue Progressbar
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "3px"
});

//
window.Fire = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//  Import the vue auth from passport

Vue.component("passport-clients", require("./components/passport/Clients.vue"));

Vue.component(
    "passport-authorized-clients",
    require("./components/passport/AuthorizedClients.vue")
);

Vue.component(
    "passport-personal-access-tokens",
    require("./components/passport/PersonalAccessTokens.vue")
);
Vue.component("NotFound", require("./components/404NotFound.vue"));

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue")
);
// ---end Here
const app = new Vue({
    el: "#app",
    router,
    store,
    // Custom method for search function
    data: {
        search: ""
    },
    methods: {
        // Debounce is an installed package in laravel for wait of every request
        searchit: _.debounce(() => {
            Fire.$emit("searching");
        }, 200),

        printme() {
            window.print();
        }
    },
    computed: {
        grandTotal: function() {
            return this.form.assets.reduce(function(carry, product) {
                return (
                    carry + parseFloat(asset.quantity) * parseFloat(asset.price)
                );
            }, 0);
        }
    }
});
