<template>
    <p>Hello There</p>
</template>

<script>
export default {
    data() {
        return {
            id: this.$route.params.id,
            cities: [],
            city: {},
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
                `https://akademija.teltonika.lt/countries_api/api/countries/${this.id}/cities `;
            fetch(page_url)
                .then((res) => res.json())
                .then((res) => {
                    this.cities = res.data;
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
