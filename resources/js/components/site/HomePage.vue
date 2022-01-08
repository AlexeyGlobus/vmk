<template>
    <div>
        <div class="d-flex justify-space-between mr-2">
        	<h1 v-if="$auth.check()">
                {{ $t('Boathouses') + ' ' + filteredPlacesCount + ' ' + $t('of') + ' ' + placesCount }}
            </h1>
            <div v-if="$auth.user().role === 1">
                <router-link to="/places/create">
                    <v-icon :title="$t('Add place')">mdi-home-plus</v-icon>
                </router-link>
            </div>
        </div>
          <v-text-field
            :label="$t('Search')"
            v-model="placesSearch"
            append-icon="mdi-magnify"
          ></v-text-field>	
        <div v-if="!!placesCount" style="display: flex;flex-direction: row;flex-wrap: wrap;">
          <v-card
            :to="'/places/' + place.id"
            class="ma-3"
            max-width="344"
            outlined
            v-for="place in filteredPlaces"
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
                name: 'Home',
                places: [],
                placesSearch: '',
                errors: []
            }
        },
        mounted() {
            this.$store.dispatch('placesAll');
        },
        computed: {
            placesCount() {
                return this.$store.state.places.all.length;
            },
            filteredPlaces() {
                return this.$store.state.places.all.filter(place => {
                    return (!!place.name && place.name.indexOf(this.placesSearch) !== -1) ||
                    (!!place.owners_name && place.owners_name.indexOf(this.placesSearch) !== -1) ||
                    (!!place.owners_surname && place.owners_surname.indexOf(this.placesSearch) !== -1);
                })
            },
            filteredPlacesCount() {
                return this.filteredPlaces.length;
            },
        }
    }
</script>