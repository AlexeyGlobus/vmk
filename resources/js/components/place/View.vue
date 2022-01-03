<template>
    <div>
        <v-card elevation="4" class="d-flex justify-space-between mt-6 pa-4">
            <div class="headers">
                <div class="d-flex justify-space-between mr-2">
                    <h2>{{ place.name }}</h2>
                    <router-link :to="'/places/edit/' + place.id" :title="$t('Edit')">
                        <v-icon>mdi-home-edit</v-icon>
                    </router-link>
                </div>
                <h3 style="width: 280px;">
                    {{ place.owners_name }} {{ place.owners_patronymic }} {{ place.owners_surname }}
                </h3>
                <p v-if="place.owners_email">{{ place.owners_email }}</p>
                <p v-if="place.owners_phone">{{ place.owners_phone }}</p>
            </div>
            <Map :place="place" v-if="locationIsReady"/>    
        </v-card>
    </div>
</template>

<script>
    import Map from './Map.vue';
    export default {
        data: function () {
            return {
                name: 'PlaceView',
                place: {},
                errors: []
            }
        },
        name: "PlaceView",
        components: {
            Map
        },
        created() {
            this.currentPlace().then((result) => {
                this.place = result;
                if (!!this.place.coords.length) {
                    let coords = this.place.coords.match(/\d+\.*\d*/g);
                    coords.forEach((x, i) => {
                    coords[i] = parseFloat(x);
                });
                    this.place.coords = coords;
                } else {
                    this.place.coords = [];
                }
            });
        },
        computed: {
            locationIsReady() {
                return typeof this.place.coords === 'object' && 
                typeof this.place.coords[0] !== 'undefined' && 
                typeof this.place.coords[1] !== 'undefined';
            }
        },
        methods: {
            async currentPlace() {
                let result = this.$store.getters.placeById(this.$route.params.id);
                if (!result) {
                    await this.$store.dispatch('placesAll');
                    result = this.$store.getters.placeById(this.$route.params.id); 
                }
                return result;
            }
        }
    }
</script>