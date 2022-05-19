<template>
    <div class="container">
        <div class="rows">
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

            <div class="card" v-for="country in countries" v-bind="country.id">
                <div class="card-footer">
                    <a href="#" class="card-footer-item">{{
                        country.attributes.name
                    }}</a>
                    <p class="card-footer-item">
                        {{ country.attributes.area }}
                    </p>
                    <p class="card-footer-item">
                        {{ country.attributes.phone_code }}
                    </p>
                    <p class="card-footer-item">
                        {{ country.attributes.population }}
                    </p>
                    <span class="card-footer-item icon">
                        <figure class="image is square">
                            <img
                                src="https://cdn-icons-png.flaticon.com/32/1827/1827933.png"
                                @click="editCountry(country.attributes)"
                                class="fas fa-home card-footer-item"
                            />
                        </figure>

                        <button
                            @click="deleteCountry(country.id)"
                            class="btn btn-danger card-footer-item"
                        >
                            Delete
                        </button>
                    </span>
                </div>
            </div>

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
    </div>
</template>
<script>
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
        this.fetchCountries();
    },
    methods: {
        fetchCountries(page_url) {
            page_url =
                page_url ||
                `https://akademija.teltonika.lt/countries_api/api/countries`;
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
    },
};
</script>
