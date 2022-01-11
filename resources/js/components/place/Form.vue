<template>
  <v-card elevation="2" class="pa-2 mt-3" autocomplete="off">
    <v-alert prominent type="error"v-if="has_error">
      <v-row align="center">
        <v-col class="grow">
          Saving error
        </v-col>
      </v-row>
    </v-alert>
    <v-form ref="place_form" 
      id="place_form" 
      @keyup.native.enter.prevent.stop="save" 
      v-if="isReady"
    >
      <v-row
        align="start"
        justify="center"
      >
        <v-col
          cols="12"
          sm="12"
          md="6"
          lg="6"
        >
          <v-text-field
            v-model="place.name"
            :label="$t('Alias')"
            required
            :error-messages="errors.name"
          ></v-text-field>
          <v-select
            v-model="place.type"
            :items="typesList"
            item-value="key" 
            item-text="name"
            :label="$t('Place type')"
          ></v-select>
          <v-text-field
            v-model="place.coords[0]"
            :label="$t('Latitude')"
            :error-messages="errors.coords"
          ></v-text-field>
          <v-text-field
            v-model="place.coords[1]"
            :label="$t('Longitude')"
            :error-messages="errors.coords"
          ></v-text-field>

          <v-icon
          large
          color="rgba(0,0,0,.42)"
          @click="showMap = !showMap"
          >
            mdi-map
          </v-icon>

        </v-col>
        <v-col
          cols="12"
          sm="12"
          md="6"
          lg="6"
        >
          <v-text-field
            v-model="place.owners_name"
            :label="$t('Owners name')"
            :error-messages="errors.owners_name"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_patronymic"
            :label="$t('Owners patronymic')"
            :error-messages="errors.owners_patronymic"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_surname"
            :label="$t('Owners surname')"
            :error-messages="errors.owners_surname"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_email"
            :label="$t('Owners email')"
            type="email"
            :error-messages="errors.owners_email"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_phone"
            :label="$t('Owners phone')"
            type="tel"
            :error-messages="errors.owners_phone"
          ></v-text-field>
          <v-textarea
            v-model="place.comments"
            :label="$t('Comments')"
            rows="2"
            :error-messages="errors.comments"
          ></v-textarea>
        </v-col>
      </v-row>

      <v-btn
        class="mr-4"
        type="submit"
        form="place_form"
        @click.prevent="save"
      >
        {{ $t("Save") }}
      </v-btn>
    </v-form>
    <div class="text-center">
      <v-dialog
        v-model="showMap"
        width="450"
      >
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            {{ $t("Select location") }}
          </v-card-title>

          <v-card-text>
            <Map :place="place"/>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="primary"
              text
              @click="showMap = false"
            >
              {{ $t("Close") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </div>
  </v-card>
</template>

<script>
  import Map from './Map.vue';
  export default {
    data: () => {
      return {
        place: {
          name: '',
          type: 1,
          owners_name: '',
          owners_patronymic: '',
          owners_surname: '',
          owners_email: '',
          owners_phone: '',
          coords: [],
          comments: ''
        },
        showMap: false,
        name: 'PlaceForm',
        errors: {},
        has_error: false,
        typesList: [
          {key: 1, name: 'Private'},
          {key: 2, name: 'Business'},
          {key: 3, name: 'Other'}
        ]
      }
    },
    components: {
      Map
    },
    created() {
      if( typeof this.$route.params.id !== 'undefined') {
        this.place = this.$store.getters.placeById(this.$route.params.id);
        if (_.isEmpty(this.place)) {
          this.$store.dispatch('placesAll').then(() => {
            this.place = this.$store.getters.placeById(this.$route.params.id);
          });
        }
      }
      //TODO find way to avoid this
      this.typesList.forEach((type, i) => {
        type.name = this.$t(type.name);
      });
    },
    methods: {
      save() {
        this.$store.state.places.current = {};
        this.$store.dispatch('httpRequest', {
          url: this.formUrl,
          method: this.formMethod,
          data: this.formatPlace(),
          mutation: 'getPlaces'
        }).then(() => {
          this.errors = this.$store.state.http.httpErrors;
          let id = this.$store.getters.currentId;
          if (!!id && !isNaN(id)) {
            this.$router.push('/places/' + id);
          }
        });
      },
      formatPlace() {
        let place = Object.assign({}, this.place);
        if (typeof this.place.coords === 'object' 
          && typeof this.place.coords[0] !== 'undefined' 
          && typeof this.place.coords[1] !== 'undefined'
          && !!this.place.coords[0] 
          && !!this.place.coords[1]
          ) {
          place.coords = 'point(' + this.place.coords[0] + ' ' + this.place.coords[1] + ')'; 
        } else {
          place.coords = '';
        }
        return place;
      },
    },
    computed: {
      formMethod() {
        if (this.$route.name === 'PlaceEdit') {
          return 'PUT';
        } else {
          return 'POST';
        }
      },
      formUrl() {
        let url = '/places';
        if (this.$route.name === 'PlaceEdit') {
          url += '/' + this.$route.params.id;
        }
        return url;
      },
      isReady() {
        return ! _.isEmpty(this.place);
      }
    }
  }
  </script>