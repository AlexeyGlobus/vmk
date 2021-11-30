<template>
    <div>
        <v-row
        align="start"
        justify="center"
        class="mt-3"
        >
            <v-col
              cols="12"
              sm="12"
              md="6"
              lg="6"
            >
                <div class="headers">
                    <h2>{{ place.name }}</h2>
                    <h3 style="width: 280px;">
                        {{ place.owners_name }} {{ place.owners_patronymic }} {{ place.owners_surname }}
                    </h3>
                    <p v-if="place.owners_email">{{ place.owners_email }}</p>
                    <p v-if="place.owners_phone">{{ place.owners_phone }}</p>
                </div>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="6"
                  lg="6"
                >
                <v-card elevation="4">
                    <Map :place="place" v-if="locationIsReady"/>    
                </v-card>
            </v-col>
        </v-row>
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
        mounted() {
            axios
              .get('/places/' + this.$route.params.name )
              .then(response => {
                if (response.status >= 200 && response.status < 300) {
                        return response;
                    } else {
                        let error = new Error(response.statusText);
                        error.response = response;
                        throw error
                    }
                }).then(response => {
                    if (response.headers['content-type'] !== 'application/json') {
                        let error = new Error('Некорректный ответ от сервера');
                        error.response = response;
                        throw error
                    }
                    return response.data;
                }).then(json => {
                    if (typeof json.place === 'object') {
                        this.place = json.place;
                    }
                }).catch(error => {
                     if (typeof error.message !== 'undefined') {
                        this.errors.push(this.$t(error.message));
                     }
                });
        },
        computed: {
            locationIsReady() {
                return typeof this.place.lat !== 'undefined' && 
                typeof this.place.lng !== 'undefined';
            }
        }
    }
</script>