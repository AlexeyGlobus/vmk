<template>
  <v-card elevation="2" class="pa-2 mt-3" autocomplete="off">
    <v-alert prominent type="error"v-if="has_error">
      <v-row align="center">
        <v-col class="grow">
          Saving error
        </v-col>
      </v-row>
    </v-alert>
    <v-form ref="place_form" id="place_form" @keyup.native.enter.prevent.stop="save">
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
          ></v-text-field>
          <v-select
            v-model="place.type"
            :items="typesList"
            item-value="key" 
            item-text="name"
            :label="$t('Place type')"
          ></v-select>
          <v-text-field
            v-model="place.lat"
            :label="$t('Latitude')"
            required
          ></v-text-field>
          <v-text-field
            v-model="place.lng"
            :label="$t('Longitude')"
            required
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
          ></v-text-field>
          <v-text-field
            v-model="place.owners_patronymic"
            :label="$t('Owners patronymic')"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_surname"
            :label="$t('Owners surname')"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_email"
            :label="$t('Owners email')"
            type="email"
          ></v-text-field>
          <v-text-field
            v-model="place.owners_phone"
            :label="$t('Owners phone')"
            type="tel"
          ></v-text-field>
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
                      <Map :place="place" v-if="true"/>
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
          lat: '',
          lng: ''
        },
        showMap: false,
        name: 'PlaceForm',
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
    methods: {
      save(e) {
        console.log(this.place);
      }
    },
    created() {
      //TODO find way to avoid this
      this.typesList.forEach((type, i) => {
        type.name = this.$t(type.name);
      });
    }
  }
  </script>