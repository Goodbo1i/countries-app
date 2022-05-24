<template>
    <div class="rows">
        <div class="addPlace">
            <h1 class="bigName">Cities</h1>
        </div>
        <a class="addPlace" @click="isModalVisable = true">
            <svg class="svg-icon" viewBox="0 -40 60 60">
                <path
                    d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10 M17.969,10c0,4.401-3.567,7.969-7.969,7.969c-4.402,0-7.969-3.567-7.969-7.969c0-4.402,3.567-7.969,7.969-7.969C14.401,2.031,17.969,5.598,17.969,10 M17.13,10c0-3.932-3.198-7.13-7.13-7.13S2.87,6.068,2.87,10c0,3.933,3.198,7.13,7.13,7.13S17.13,13.933,17.13,10"
                ></path>
            </svg>
        </a>

        <!-- Lenteles Header -->
        <div class="card">
            <div class="card-footer">
                <h1 class="card-footer-item">Name</h1>
                <h1 class="card-footer-item">Area</h1>
                <h1 class="card-footer-item">Postal Code</h1>
                <h1 class="card-footer-item">Population</h1>
                <h1 class="card-footer-item">
                    <h1 class="card-footer-item">Edit</h1>
                    <h1 class="card-footer-item">Delete</h1>
                </h1>
            </div>
        </div>

        <!-- Lenteles Duomenys -->
        <TableComponent
            v-for="city in cities"
            :key="city.id"
            :place="city"
            v-on:reloadlist="getListCities()"
        >
        </TableComponent>

        <!-- Numeracija -->
        <nav
            class="pagination is-centered"
            role="navigation"
            aria-label="pagination"
        >
            <ul class="pagination-list">
                <li>
                    <a
                        v-bind:class="{
                            'is-disabled': !pagination.prev_page_url,
                        }"
                        class="pagination-previous"
                        title="This is the first page"
                        @click="getListCities(pagination.prev_page_url)"
                        >Previous</a
                    >
                </li>
                <li class="page-item">
                    <h1 class="pagination-link" aria-label="Page">
                        Page {{ pagination.current_page }} of
                        {{ pagination.last_page }}
                    </h1>
                </li>
                <li>
                    <a
                        v-bind:class="{
                            'is-disabled': !pagination.next_page_url,
                        }"
                        class="pagination-next"
                        @click="getListCities(pagination.next_page_url)"
                        >Next page</a
                    >
                </li>
            </ul>
        </nav>
        <div>
            <ModalComponent
                v-show="isModalVisable"
                @close="closeModal"
                :place="city"
                v-on:reloadlist="getListCities()"
            >
            </ModalComponent>
        </div>
    </div>
</template>

<script>
import ModalComponent from "../components/ModalComponent.vue";
import TableComponent from "../components/TableComponent.vue";
import CreateComponent from "../components/CreateComponent.vue";

export default {
    data() {
        return {
            id: this.$route.params.id,
            cities: [],
            city: {
                attributes: {
                    name: "",
                    area: "",
                    population: "",
                    postal_code: "",
                },
                type: "cities",
            },
            pagination: {},
            isModalVisable: false,
        };
    },
    components: { TableComponent, CreateComponent, ModalComponent },
    created() {
        this.getListCities();
    },
    methods: {
        showModal() {
            this.$refs.isModalVisable = true;
        },
        addCity(cityForm) {
            console.log("creating", cityForm);
            console.log(cityForm.name);
            fetch(
                `https://akademija.teltonika.lt/countries_api/api/countries/${this.id}/cities`,
                {
                    method: "post",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        data: {
                            attributes: {
                                name: cityForm.name,
                                area: cityForm.area,
                                population: cityForm.population,
                                postal_code: cityForm.phoneCode,
                            },
                        },
                    }),
                }
            )
                .then((response) => {
                    console.log(response);
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getListCities(page_url) {
            page_url =
                page_url ||
                `https://akademija.teltonika.lt/countries_api/api/countries/${this.id}/cities `;
            axios
                .get(page_url)
                .then((res) => {
                    this.cities = res.data.data;
                    this.makePagination(res.data.meta, res.data.links);
                })
                .catch((err) => console.log(err));
        },

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                first_page: meta.from,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
            };
            this.pagination = pagination;
        },
        closeModal() {
            this.isModalVisable = false;
        },
    },
};
</script>

<style>
.addPlace {
    display: inline-block;
    width: 250px;
    height: 30px;
}
h1.bigName {
    font-size: 100px;
}
</style>
