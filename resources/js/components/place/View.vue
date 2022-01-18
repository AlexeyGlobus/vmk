<template>
    <div>
        <v-card 
            elevation="4" 
            class="d-flex justify-space-between mt-6 pa-4"
            v-if="$store.getters.userCan('read-' + table_name)"
        >
            <div class="headers">
                <div class="d-flex justify-space-between mr-2">
                    <h2>{{ place.name }}</h2>
                    <router-link 
                        :to="'/places/edit/' + place.id" 
                        :title="$t('Edit') + ' ' + place.name" 
                        v-if="this.$store.getters.userCan('update-' + table_name)"
                    >
                        <v-icon>mdi-home-edit</v-icon>
                    </router-link>
                    <a href="#" 
                        @click.prevent="deleteCurrent"
                        v-if="this.$store.getters.userCan('delete-' + table_name)"
                        :title="$t('Delete') + ' ' + place.name"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </a>
                </div>
                <h3 style="width: 280px;">
                    {{ place.owners_name }} {{ place.owners_patronymic }} {{ place.owners_surname }}
                </h3>
                <p v-if="place.owners_email">{{ place.owners_email }}</p>
                <p v-if="place.owners_phone">{{ place.owners_phone }}</p>
                <p v-if="place.comments">{{ place.comments }}</p>
            </div>
            <Map :place="place" v-if="locationIsReady"/>    
        </v-card>
        <h3 v-else>{{ $t('403 Access denied') }}</h3>
    </div>
</template>

<script>
    import Map from './Map.vue';
    export default {
        data: function () {
            return {
                table_name: 'places',
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
                if (_.isEmpty(result)) {
                    await this.$store.dispatch('placesAll');
                    result = this.$store.getters.placeById(this.$route.params.id); 
                }
                return result;
            },
            deleteCurrent() {
                if (typeof this.place.id !== undefined && !isNaN(this.place.id)) {
                    this.$confirm(this.$t('Please confirm deletion')).then(res => {
                        if(res) {
                            this.$store.dispatch('httpRequest', {
                                url: '/places/' + this.place.id,
                                method: 'DELETE',
                                data: this.place,
                                mutation: 'getPlaces'
                            }).then(() => {
                                this.errors = this.$store.state.http.httpErrors;
                                this.$router.push('/');
                            });
                        }
                    });
                }
            }
        }
    }
</script>