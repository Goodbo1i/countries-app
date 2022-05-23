<template>
    <form @submit.prevent="$emit('on-submit', form)">
        <div class="form-group">
            <label for="pavadinimas">Name</label>
            <input type="text" name="pavadinimas" v-model="form.name" />
        </div>
        <div class="form-group">
            <label for="area">Area</label>
            <input type="text" name="area" v-model="form.area" />
        </div>

        <div class="form-group">
            <label for="population">Population</label>
            <input type="text" name="population" v-model="form.population" />
        </div>
        <div class="form-group">
            <label for="phoneCode">{{ code }} Code</label>
            <input type="text" name="phoneCode" v-model="form.phoneCode" />
        </div>
        <button type="submit" ref="submit">Submit</button>
    </form>
</template>
​
<script>
export default {
    props: {
        place: {
            type: Object,
        },
        code: "",
    },
    data() {
        return {
            form: {
                name: this.place?.email || "",
                area: this.place?.name || "",
                population: this.place?.population || "",
                phoneCode: this.place?.phoneCode || "",
            },
        };
    },
};
</script>
