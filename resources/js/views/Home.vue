<template>
    <!-- Lentele -->
    <div class="rows">
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
            :city="''"
        >
        </TableComponent>

        <span class="card-footer-item icon">
            <figure class="card-footer-item">
                <svg
                    class="svg-icon"
                    viewBox="-5 -10 30 30"
                    @click="editCountry(country.attributes)"
                >
                    <path
                        d="M18.303,4.742l-1.454-1.455c-0.171-0.171-0.475-0.171-0.646,0l-3.061,3.064H2.019c-0.251,0-0.457,0.205-0.457,0.456v9.578c0,0.251,0.206,0.456,0.457,0.456h13.683c0.252,0,0.457-0.205,0.457-0.456V7.533l2.144-2.146C18.481,5.208,18.483,4.917,18.303,4.742 M15.258,15.929H2.476V7.263h9.754L9.695,9.792c-0.057,0.057-0.101,0.13-0.119,0.212L9.18,11.36h-3.98c-0.251,0-0.457,0.205-0.457,0.456c0,0.253,0.205,0.456,0.457,0.456h4.336c0.023,0,0.899,0.02,1.498-0.127c0.312-0.077,0.55-0.137,0.55-0.137c0.08-0.018,0.155-0.059,0.212-0.118l3.463-3.443V15.929z M11.241,11.156l-1.078,0.267l0.267-1.076l6.097-6.091l0.808,0.808L11.241,11.156z"
                    ></path>
                </svg>
            </figure>

            <figure class="card-footer-item">
                <svg
                    class="svg-icon"
                    viewBox="-5 -10 30 30"
                    @click="deleteCountry(country.id)"
                >
                    <path
                        d="M17.114,3.923h-4.589V2.427c0-0.252-0.207-0.459-0.46-0.459H7.935c-0.252,0-0.459,0.207-0.459,0.459v1.496h-4.59c-0.252,0-0.459,0.205-0.459,0.459c0,0.252,0.207,0.459,0.459,0.459h1.51v12.732c0,0.252,0.207,0.459,0.459,0.459h10.29c0.254,0,0.459-0.207,0.459-0.459V4.841h1.511c0.252,0,0.459-0.207,0.459-0.459C17.573,4.127,17.366,3.923,17.114,3.923M8.394,2.886h3.214v0.918H8.394V2.886z M14.686,17.114H5.314V4.841h9.372V17.114z M12.525,7.306v7.344c0,0.252-0.207,0.459-0.46,0.459s-0.458-0.207-0.458-0.459V7.306c0-0.254,0.205-0.459,0.458-0.459S12.525,7.051,12.525,7.306M8.394,7.306v7.344c0,0.252-0.207,0.459-0.459,0.459s-0.459-0.207-0.459-0.459V7.306c0-0.254,0.207-0.459,0.459-0.459S8.394,7.051,8.394,7.306"
                    ></path>
                </svg>
            </figure>
        </span>

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
                        @click="fetchCountries(pagination.prev_page_url)"
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
                        @click="fetchCountries(pagination.next_page_url)"
                        >Next page</a
                    >
                </li>
            </ul>
        </nav>
    </div>
</template>
<script>
import TableComponent from "../components/TableComponent.vue";

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
            page_url: `https://akademija.teltonika.lt/countries_api/api/countries`,
        };
    },
    created() {
        this.fetchCountries();
    },
    methods: {
        fetchCountries(page_url) {
            page_url = page_url || this.page_url;
            fetch(page_url)
                .then((res) => res.json())
                .then((res) => {
                    this.countries = res.data;
                    this.makePagination(res.meta, res.links);
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
        deleteCountry(id) {
            if (confirm("Are You Sure?")) {
                fetch(
                    `https://akademija.teltonika.lt/countries_api/api/countries/${id}`,
                    {
                        method: "delete",
                    }
                )
                    .then((res) => res.json())
                    .then((data) => {
                        alert("Article Removed");
                        this.fetchCountries();
                    })
                    .catch((err) => console.log(err));
            }
        },
        editCountry(country) {
            this.edit;
        },
    },
    components: { TableComponent },
};
</script>
