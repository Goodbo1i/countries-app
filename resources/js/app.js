require("./bootstrap");
import Vue from "vue";
import router from "./routes";

Vue.component("countries", require("./views/Home.vue"));
Vue.component("city", require("./views/City.vue"));

new Vue({
    el: "#app",

    router,
});
