<template>
    <div>
    	<h1 v-if="$auth.check()">GLOBUS-1 {{ name }}</h1>	
        <div v-if="!!placesCount" style="display: flex;flex-direction: row;">
          <v-card
            :to="'/place/' + place.name"
            class="ma-3"
            max-width="344"
            outlined
            v-for="place in places"
            :key="place.id"
          >
            <v-list-item three-line>
              <v-list-item-content>
                <div class="text-overline mb-4">
                  {{ place.name }}
                </div>
                <v-list-item-title class="text-h5 mb-1">
                  {{ place.name }}
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ place.owners_name }} {{ place.owners_surname }}
                </v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-avatar
                tile
                size="80"
                color="#add8e6"
              >
                  <img src="/img/boathouse.svg">
              </v-list-item-avatar>
            </v-list-item>
          </v-card>
        </div>
    </div>   
</template>

<script>
    export default {
        data: function () {
            return {
                name: 'Vue',
                places: [],
                errors: []
            }
        },
        mounted() {
            axios
              .get('/places')
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
                    if (typeof json.places === 'object') {
                        this.places = json.places;
                    }
                }).catch(error => {
                     if (typeof error.message !== 'undefined') {
                        this.errors.push(this.$t(error.message));
                     }
            });
        },
        computed: {
            placesCount() {
                return this.places.length;
            }
        }
    }
</script>