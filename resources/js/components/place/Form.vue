<template>
  <v-card elevation="2" class="pa-4" autocomplete="off" min-width="89%">
    <v-alert prominent type="error"v-if="has_error">
      <v-row align="center">
        <v-col class="grow">
          Saving error
        </v-col>
      </v-row>
    </v-alert>
    <v-form ref="place_form" id="place_form" @keyup.native.enter.prevent.stop="save">
      <v-row
        align="center"
        justify="center"
      >
        <v-col
          cols="12"
          sm="12"
          md="6"
          lg="6"
        >
          <v-text-field
            v-model="name"
            :label="$t('Alias')"
            required
          ></v-text-field>
          <v-select
            v-model="type"
            :items="typesList"
            item-value="key" 
            item-text="name"
            :label="$t('Place type')"
          ></v-select>

          <Map :place="place" v-if="true"/>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          md="6"
          lg="6"
        >
          <v-text-field
            v-model="owners_name"
            :label="$t('Owners name')"
          ></v-text-field>
          <v-text-field
            v-model="owners_patronymic"
            :label="$t('Owners patronymic')"
          ></v-text-field>
          <v-text-field
            v-model="owners_surname"
            :label="$t('Owners surname')"
          ></v-text-field>
          <v-text-field
            v-model="owners_email"
            :label="$t('Owners email')"
            type="email"
          ></v-text-field>
          <v-text-field
            v-model="owners_phone"
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
  </v-card>

</template>

<script>
  import Map from './Map.vue';
  export default {
    data: () => {
      return {
        place: {
          name: 'New place',
          lat: `${process.env.MIX_BING_MAP_CENTER_LAT}`,
          lng: `${process.env.MIX_BING_MAP_CENTER_LNG}`
        },
        name: '',
        type: '',
        owners_name: '',
        owners_patronymic: '',
        owners_surname: '',
        owners_email: '',
        owners_phone: '',
        lat: '', 
        lng: '',
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

      }
    },
  }
  </script>