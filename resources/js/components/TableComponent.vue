<template>
    <div class="card">
        <div class="card-footer">
            <router-link :to="'/city/' + place.id" class="card-footer-item">
                <a>{{ place.attributes.name }}</a>
            </router-link>

            <p class="card-footer-item">
                {{ place.attributes.area }}
            </p>
            <p class="card-footer-item">
                {{
                    place.attributes.phone_code || place.attributes.postal_code
                }}
            </p>
            <p class="card-footer-item">
                {{ place.attributes.population }}
            </p>
            <span class="card-footer-item icon">
                <a class="card-footer-item">
                    <svg
                        width="22"
                        height="22"
                        viewBox="0 0 22 22"
                        fill="none"
                        @click="isModalVisable = true"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M19.3026 1.8986C18.1044 0.700466 16.1618 0.700466 14.9635 1.8986L2.79947 14.0616C2.71611 14.1449 2.65592 14.2483 2.62449 14.3617L1.02488 20.1361C0.959095 20.3729 1.02595 20.6264 1.1996 20.8003C1.37351 20.9739 1.62706 21.0408 1.86384 20.9753L7.63878 19.3755C7.75223 19.3441 7.85557 19.2839 7.93893 19.2006L20.1027 7.03734C21.2991 5.83841 21.2991 3.89753 20.1027 2.6986L19.3026 1.8986ZM4.28509 14.5047L14.2404 4.55L17.4511 7.76038L7.49549 17.7151L4.28509 14.5047ZM3.64375 15.7915L6.20882 18.3566L2.66071 19.3396L3.64375 15.7915ZM19.1386 6.0733L18.4155 6.79633L15.2046 3.58568L15.9279 2.86265C16.5935 2.19714 17.6727 2.19714 18.3382 2.86265L19.1386 3.66265C19.8031 4.32896 19.8031 5.40725 19.1386 6.0733Z"
                            fill="#969696"
                            stroke="white"
                            stroke-width="0.5"
                        />
                    </svg>
                </a>

                <a class="card-footer-item">
                    <svg
                        width="20"
                        height="20"
                        viewBox="0 0 20 20"
                        fill="none"
                        @click="deletePlace(place.id)"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M18.1806 1.88441H12.8052V0.935742C12.8052 0.419766 12.386 0 11.8708 0H8.12922C7.61399 0 7.19485 0.419766 7.19485 0.935742V1.88438H1.81942C1.55946 1.88438 1.34875 2.09508 1.34875 2.35504C1.34875 2.615 1.55946 2.8257 1.81942 2.8257H2.69176L3.28661 18.3099C3.32301 19.2576 4.09446 20 5.04293 20H14.9571C15.9056 20 16.6771 19.2576 16.7134 18.3099L17.3082 2.82566H18.1806C18.4405 2.82566 18.6512 2.61496 18.6512 2.355C18.6512 2.09512 18.4405 1.88441 18.1806 1.88441ZM8.13614 0.941289H11.8639V1.88438H8.13614V0.941289ZM15.7728 18.2738C15.7559 18.7139 15.3976 19.0587 14.9571 19.0587H5.04293C4.60246 19.0587 4.24418 18.7139 4.22723 18.2738L3.63379 2.8257H16.3663L15.7728 18.2738Z"
                            fill="#969696"
                        />
                        <path
                            d="M7.134 7.09258C7.12904 6.83575 6.91939 6.63098 6.66361 6.63098C6.66056 6.63098 6.65744 6.63098 6.65439 6.63106C6.39455 6.63606 6.18787 6.85083 6.19287 7.11067L6.34056 14.7917C6.34549 15.0485 6.55521 15.2533 6.81095 15.2533C6.814 15.2533 6.81713 15.2533 6.82017 15.2532C7.08006 15.2482 7.2867 15.0335 7.2817 14.7736L7.134 7.09258Z"
                            fill="#969696"
                        />
                        <path
                            d="M9.99993 6.63098C9.74001 6.63098 9.52927 6.84168 9.52927 7.10165V14.7827C9.52927 15.0426 9.73997 15.2533 9.99993 15.2533C10.2599 15.2533 10.4706 15.0426 10.4706 14.7827V7.10165C10.4706 6.84172 10.2599 6.63098 9.99993 6.63098Z"
                            fill="#969696"
                        />
                        <path
                            d="M13.3455 6.6311C13.0866 6.62536 12.8709 6.83274 12.8659 7.09262L12.7182 14.7736C12.7132 15.0335 12.9198 15.2482 13.1797 15.2532C13.1828 15.2533 13.1859 15.2533 13.1889 15.2533C13.4446 15.2533 13.6544 15.0485 13.6593 14.7917L13.807 7.11071C13.812 6.85079 13.6054 6.63606 13.3455 6.6311Z"
                            fill="#969696"
                        />
                    </svg>
                </a>
            </span>
        </div>
        <ModalComponent
            v-show="isModalVisable"
            @close="closeModal"
            :place="place"
        >
        </ModalComponent>
    </div>
</template>

<script>
import ModalComponent from "./ModalComponent.vue";
export default {
    props: ["place"],
    components: { ModalComponent },
    data() {
        return {
            isModalVisable: false,
        };
    },

    methods: {
        //Tikrina kuriam route esame ir tada deletina
        deletePlace(id) {
            if (confirm("Are You Sure?")) {
                if (this.place.type == "cities") {
                    axios
                        .delete(
                            `https://akademija.teltonika.lt/countries_api/api/countries/${this.place.relationships.country.data.id}/cities/${this.place.id}`
                        )
                        .then((data) => {
                            alert("Article Removed");
                            this.$emit("reloadlist");
                        })
                        .catch((err) => console.log(err));
                } else {
                    axios
                        .delete(
                            `https://akademija.teltonika.lt/countries_api/api/countries/${this.place.id}`
                        )
                        .then((data) => {
                            alert("Article Removed");
                            this.$emit("reloadlist");
                        })
                        .catch((err) => console.log(err));
                }
            }
        },
        closeModal() {
            this.isModalVisable = false;
        },
    },
};
</script>
