<template>
    <div class="rows">
        <h3>Create City</h3>
        <CreateComponent @on-submit="addCity" :code="'Postal'" />

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
    </div>
</template>

<script>
import TableComponent from "../components/TableComponent.vue";
import CreateComponent from "../components/CreateComponent.vue";

export default {
    data() {
        return {
            id: this.$route.params.id,
            cities: [],
            city: {},
            pagination: {},
        };
    },
    components: { TableComponent, CreateComponent },
    created() {
        this.getListCities();
    },
    methods: {
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
        // fetchCities(page_url) {
        //     page_url =
        //         page_url ||
        //         `https://akademija.teltonika.lt/countries_api/api/countries/${this.id}/cities `;
        //     fetch(page_url)
        //         .then((res) => res.json())
        //         .then((res) => {
        //             this.cities = res.data;
        //             this.makePagination(res.meta, res.links);
        //         })
        //         .catch((err) => console.log(err));
        // },
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
    },
};
</script>
