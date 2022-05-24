<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Modal title</p>
                <button
                    class="delete"
                    aria-label="close"
                    @click="close"
                ></button>
            </header>
            <section class="modal-card-body">
                <div class="control">
                    Name
                    <input
                        class="input"
                        type="text"
                        placeholder="Name"
                        v-model="place.attributes.name"
                    />
                </div>
                <div class="control">
                    Area
                    <input
                        class="input"
                        type="text"
                        placeholder="Area"
                        v-model="place.attributes.area"
                    />
                </div>
                <div class="control">
                    Population
                    <input
                        class="input"
                        type="text"
                        placeholder="Population"
                        v-model="place.attributes.population"
                    />
                </div>
                <div class="control">
                    Code
                    <input
                        class="input"
                        type="text"
                        v-if="place.type == 'cities'"
                        placeholder="Postal Code"
                        v-model="place.attributes.postal_code"
                    />
                    <input
                        class="input"
                        type="text"
                        v-if="place.type == 'countries'"
                        placeholder="Phone Code"
                        v-model="place.attributes.phone_code"
                    />
                </div>
            </section>
            <footer class="modal-card-foot">
                <button
                    class="button is-success"
                    v-once
                    v-show="!place.attributes.name"
                    @click="addPlace()"
                >
                    Add Place
                </button>
                <button
                    class="button is-success"
                    v-once
                    v-show="place.attributes.name"
                    @click="updatePlace()"
                >
                    Save Changes
                </button>
                <button class="button" @click="$emit('close')">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    props: ["place"],
    data() {
        return {
            id: this.$route.params.id,
            newPlace: {
                name: "",
                area: "",
                population: "",
                phone_code: "",
            },
        };
    },
    name: "Modal",
    methods: {
        close() {
            this.$emit("close");
        },
        addPlace() {
            console.log(this.place.attributes);
            if (this.place.type == "cities") {
                let json = JSON.stringify({
                    data: {
                        attributes: {
                            name: this.place.attributes.name,
                            area: this.place.attributes.area,
                            population: this.place.attributes.population,
                            postal_code: this.place.attributes.postal_code,
                        },
                    },
                });
                axios.post(
                    `https://akademija.teltonika.lt/countries_api/api/countries/${this.id}/cities`,
                    json,
                    {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );
            } else {
                let json = JSON.stringify({
                    data: {
                        attributes: {
                            name: this.place.attributes.name,
                            area: this.place.attributes.area,
                            population: this.place.attributes.population,
                            phone_code: this.place.attributes.phone_code,
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
            }
            this.close();
            this.$emit("reloadlist");
        },
        updatePlace() {
            console.log(this.place.attributes);
            if (this.place.type == "cities") {
                let json = JSON.stringify({
                    data: {
                        attributes: {
                            name: this.place.attributes.name,
                            area: this.place.attributes.area,
                            population: this.place.attributes.population,
                            postal_code: this.place.attributes.postal_code,
                        },
                    },
                });
                axios.put(
                    `https://akademija.teltonika.lt/countries_api/api/countries/${this.id}/cities/${this.place.id}`,
                    json,
                    {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );
            } else {
                let json = JSON.stringify({
                    data: {
                        attributes: {
                            name: this.place.attributes.name,
                            area: this.place.attributes.area,
                            population: this.place.attributes.population,
                            phone_code: this.place.attributes.phone_code,
                        },
                    },
                });
                axios.put(
                    `https://akademija.teltonika.lt/countries_api/api/countries/${this.place.id}`,
                    json,
                    {
                        headers: {
                            "Content-Type": "application/json",
                        },
                    }
                );
            }
            this.close();
            this.$emit("reloadlist");
        },
    },
};
</script>
