import VueRouter from "vue-router";

let routes = [
    {
        path: "/",
        component: require("./views/Home.vue").default,
    },
    {
        path: "/city/:id",
        component: require("./views/City.vue").default,
    },
];

export default new VueRouter({
    routes,
    linkActiveClass: "is-active",
});
