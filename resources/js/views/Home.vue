<template>
    <div class="rows">
        <!-- Pavadinimas -->

        <div class="addPlace">
            <h1 class="bigName">Countries</h1>
        </div>

        <a>
            <svg
                width="64"
                height="64"
                viewBox="0 0 64 64"
                fill="none"
                @click="isModalVisable = true"
                xmlns="http://www.w3.org/2000/svg"
            >
                <g filter="url(#filter0_d_0_433)">
                    <circle cx="32" cy="32" r="22" fill="white" />
                </g>
                <line
                    x1="22.7742"
                    y1="32.0426"
                    x2="41.2258"
                    y2="32.0426"
                    stroke="#969696"
                />
                <line
                    x1="31.9573"
                    y1="22.7742"
                    x2="31.9573"
                    y2="41.2258"
                    stroke="#969696"
                />
                <defs>
                    <filter
                        id="filter0_d_0_433"
                        x="0"
                        y="0"
                        width="64"
                        height="64"
                        filterUnits="userSpaceOnUse"
                        color-interpolation-filters="sRGB"
                    >
                        <feFlood
                            flood-opacity="0"
                            result="BackgroundImageFix"
                        />
                        <feColorMatrix
                            in="SourceAlpha"
                            type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                            result="hardAlpha"
                        />
                        <feOffset />
                        <feGaussianBlur stdDeviation="5" />
                        <feColorMatrix
                            type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"
                        />
                        <feBlend
                            mode="normal"
                            in2="BackgroundImageFix"
                            result="effect1_dropShadow_0_433"
                        />
                        <feBlend
                            mode="normal"
                            in="SourceGraphic"
                            in2="effect1_dropShadow_0_433"
                            result="shape"
                        />
                    </filter>
                </defs>
            </svg>
        </a>

        <!-- Paieska -->
        <div class="field has-addons">
            <div class="control">
                <input
                    class="input"
                    type="text"
                    placeholder="Find a country"
                    v-model="search"
                    @input="getList()"
                />
            </div>
            <div class="control">
                <a class="button is-info"> Search </a>
            </div>

            <!-- Datos Filtravimas -->
            <date-picker
                v-model="filterDate"
                valueType="format"
                placeholder="Date Filter"
                @change="getList()"
            ></date-picker>
        </div>

        <!-- Lenteles Header -->
        <div class="card" v-once>
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

        <!-- Puslapiavimas -->

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
        <!-- Modal pasiekimas is pagrindinio ekrano -->

        <ModalComponent
            v-show="isModalVisable"
            @close="closeModal"
            :place="country"
            v-on:reloadlist="getList()"
        >
        </ModalComponent>
    </div>
</template>

<script>
import TableComponent from "../components/TableComponent.vue";
import CreateComponent from "../components/CreateComponent.vue";
import ModalComponent from "../components/ModalComponent.vue";
import { booleanLiteral } from "@babel/types";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
    data() {
        return {
            filterDate: "",
            search: "",
            countries: [],
            country: {
                attributes: {
                    name: "",
                    area: "",
                    population: "",
                    phone_code: "",
                },
                type: "countries",
            },
            pagination: {},
            isModalVisable: false,
        };
    },
    created() {
        this.getList();
    },
    methods: {
        //Atnaujina visa lentele
        getList(page_url) {
            if (this.filterDate == null) this.filterDate = ""; //Jeigu data yra pakeiciama i null, kad URL butu tuscias, o ne null

            if (!page_url) {
                axios
                    .get(
                        `https://akademija.teltonika.lt/countries_api/api/countries` +
                            `?search=${this.search}` +
                            `&start_date=${this.filterDate}`
                    )
                    .then((res) => {
                        console.log(res);
                        this.countries = res.data.data;
                        this.makePagination(res.data.meta, res.data.links);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } else {
                axios
                    .get(
                        page_url +
                            `&search=${this.search}` +
                            `&start_date=${this.filterDate}`
                    )
                    .then((res) => {
                        console.log(res);
                        this.countries = res.data.data;
                        this.makePagination(res.data.meta, res.data.links);
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            }
        },
        //SUkuria pagination
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
    components: { TableComponent, CreateComponent, ModalComponent, DatePicker },
};
</script>
