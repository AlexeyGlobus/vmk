<template>
    <div>
        <div class="headers">
            <h2>{{ place.name }}</h2>
            <h3>
            {{ place.owners_name }} {{ place.owners_patronymic }} {{ place.owners_surname }}
            </h3>
        </div>
        <v-card elevation="4">
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