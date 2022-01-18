<template>
  <v-card 
	  elevation="2" 
	  class="pa-2 mt-3" 
	  autocomplete="off"
	  v-if="$store.getters.userCan('read-' + table_name)"
  >
  	Access rights form template
  </v-card>
  <h3 v-else>{{ $t('403 Access denied') }}</h3>
</template>

<script>
	export default {
		data: () => {
			return {
				table_name: 'access_rights'
			}
		},
        mounted() {
            this.$store.dispatch('accessRightsAll');
        },
		computed: {
			canEdit() {
				return true;
			}
		}
	}
</script>