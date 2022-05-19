require("./bootstrap");
import router from "./routes";

Vue.component("countries", require("./views/Home.vue"));

new Vue({
    el: "#app",

    router,
});
