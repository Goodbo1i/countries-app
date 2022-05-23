<template>
    <!-- Lentele -->
    <div class="rows">
        <h3>Create Country form</h3>
        <CreateComponent @on-submit="addCountry" :code="'Phone'" />

        <!-- Lenteles Header -->
        <div class="card">
            <div class="card-footer">
                <h1 class="card-footer-item">Name</h1>
                <h1 class="card-footer-item">Area</h1>
                <h1 class="card-footer-item">Phone Code</h1>
                <h1 class="card-footer-item">Population</h1>
                <h1 class="card-footer-item">
                    <h1 class="card-footer-item">Edit</h1>
                    <h1 class="card-footer-item">Delete</h1>
                </h1>
            </div>
        </div>

        <!-- Lenteles Duomenys -->
        <TableComponent
            v-for="country in countries"
            :key="country.id"
            :place="country"
            v-on:reloadlist="getList()"
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
                        @click="getList(pagination.prev_page_url)"
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
                        @click="getList(pagination.next_page_url)"
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
            countries: [],
            country: {
                id: "",
                name: "",
                area: "",
                population: "",
                phone_code: "",
                cities_link: "",
            },
            pagination: {},
        };
    },
    created() {
        this.getList();
    },
    methods: {
        getList(page_url) {
            page_url =
                page_url ||
                `https://akademija.teltonika.lt/countries_api/api/countries`;
            axios
                .get(page_url)
                .then((res) => {
                    console.log(res);
                    this.countries = res.data.data;
                    this.makePagination(res.data.meta, res.data.links);
                })
                .catch((err) => {
                    console.log(err);
                });
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
        addCountry(countryForm) {
            let json = JSON.stringify({
                data: {
                    attributes: {
                        name: countryForm.name,
                        area: countryForm.area,
                        population: countryForm.population,
                        phone_code: countryForm.phoneCode,
                    },
                },
            });
            axios.post(
                `https://akademija.teltonika.lt/countries_api/api/countries`,
                json,
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
                }
            );
        },
    },
    components: { TableComponent, CreateComponent },
};
</script>
