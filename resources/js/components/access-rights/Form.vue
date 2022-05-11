<template>
  <div v-if="isReady">
    <v-text-field
		  :label="$t('Search')"
		  v-model="accessRightsSearch"
		  append-icon="mdi-magnify"
		></v-text-field>
	  <v-card 
		  elevation="2" 
		  class="pa-2 mt-3" 
		  autocomplete="off"
		  v-if="$store.getters.userCan('read-' + table_name)"
	  >
		  <v-simple-table v-if="isReady">
		    <template v-slot:default>
		      <thead>
		        <tr>
		          <th class="text-left">
		            {{ $t('Data object') }}
		          </th>
		          <th class="text-left">
		            {{ $t('Role')}}
		          </th>
		          <th class="text-left">
		            C
		          </th>
		          <th class="text-left">
		            R
		          </th>
		          <th class="text-left">
		            U
		          </th>
		          <th class="text-left">
		            D
		          </th>
		          <th class="text-center"></th>
		        </tr>
		      </thead>
		      <tbody>
		        <tr
				    	v-for="(el, index) in filteredAccessRights" 
				    	:key="index"
		        >
		          <td class="text-left">
		          	<p class="text-uppercase font-weight-bold">
			          	{{ $t(getTableName(el.label)) }}
			          </p>
		        	</td>
		          <td class="text-left">{{ $t(getRoleName(el.ar.role)) }}</td>
		          <td>
      		      <v-checkbox
						      v-model="el.ar.rights.create"
				    		>
	    					</v-checkbox>
		          </td>
		          <td>
      		      <v-checkbox
						      v-model="el.ar.rights.read"
				    		>
	    					</v-checkbox>
		          </td> 
		          <td>
      		      <v-checkbox
						      v-model="el.ar.rights.update"
				    		>
	    					</v-checkbox>
		          </td>
		          <td>
      		      <v-checkbox
						      v-model="el.ar.rights.delete"
				    		>
	    					</v-checkbox>
		          </td> 
		          <td>
        		    <v-btn
						      class="ma-2"
						      outlined
						      fab
						      small
					        color="#1976d2"	
						      v-if="canEdit"
						      @click.prevent="update(el.ar)"
						    >
		          		<v-icon>
				            save
				          </v-icon>
				        </v-btn>
		          </td>
		        </tr>
		      </tbody>
		    </template>
		  </v-simple-table>
	  </v-card>
	  <v-expansion-panels accordion class="mt-3">
      <v-expansion-panel>
      <v-expansion-panel-header>Add rule</v-expansion-panel-header>
      <v-expansion-panel-content class="pa-0">
			  <v-simple-table>
			    	<tbody>
		       		<tr>
		          <td class="text-left">
		          	<p class="text-uppercase font-weight-bold">
			          	dropdown table
			          </p>
		        	</td>
		          <td class="text-left">dropdown role</td>
		          <td>
      		      <v-checkbox
						      v-model="newAccessRight.rights.create"
				    		>
	    					</v-checkbox>
		          </td>
		          <td>
      		      <v-checkbox
						      v-model="newAccessRight.rights.read"
				    		>
	    					</v-checkbox>
		          </td> 
		          <td>
      		      <v-checkbox
						      v-model="newAccessRight.rights.update"
				    		>
	    					</v-checkbox>
		          </td>
		          <td>
      		      <v-checkbox
						      v-model="newAccessRight.rights.delete"
				    		>
	    					</v-checkbox>
		          </td> 
		          <td>
        		    <v-btn
						      class="ma-2"
						      outlined
						      fab
						      small
					        color="#1976d2"	
						      v-if="canEdit"
						      @click.prevent="update(newAccessRight)"
						    >
		          		<v-icon>
				            save
				          </v-icon>
				        </v-btn>
		          </td>
		        </tr>
		      </tbody>
		  </v-simple-table>
      </v-expansion-panel-content>
	    </v-expansion-panel>
	  </v-expansion-panels>
	</div>
	    <h3 v-else>{{ $t('403 Access denied') }}</h3>
</template>

<script>
	export default {
		data: () => {
			return {
				table_name: 'access_rights',
				isReady: false,
				accessRightsSearch: '',
				newAccessRight: {
					table_name: '',
					role: 0,
					rights: {
						create: false,
						read: false,
						update: false,
						delete: false
					}
				}
			}
		},
    created() {
      this.$store.dispatch('accessRightsAll')
    	.then(() => {;
    		this.isReady = !!this.$store.state.accessRights.all.length;
    	});
    },
		computed: {
			//TODO
			canEdit() {
				return true;
			},
			filteredAccessRights() {
				let filtered = this.$store.state.accessRights.all.filter(accessRight => {
					let tn = this.$t(this.getTableName(accessRight.table_name)).toLowerCase();
					return !!accessRight.table_name &&
						tn.indexOf(this.accessRightsSearch.toLowerCase()) !== -1;
				});
				let prevTableName = '';
				let result = [];
				filtered.forEach(el => {
					let res = {};
					let label = '';
					if (el.table_name !== prevTableName) {
						label = el.table_name;
					}
					res.ar = el;
					res.label = label;
					prevTableName = el.table_name;
					result.push(res);
				});
				return result;
			}
		},
		methods: {
			getTableName (table) {
				return this.$store.getters.tableName(table) + '';
			},
			getRoleName (role) {
				return this.$store.getters.roleName(role) + '';
			},
			update(data) {
				let rights = 0;
				let result = Object.assign({}, data);
				if (typeof data.rights === 'object') {
					rights = 	data.rights.create * 1 +
										data.rights.read * 2 +
										data.rights.update * 4 +
										data.rights.delete * 8;
				}
				result.rights = rights;
				console.log(result)
			} 
		}
	}
</script>

<style scoped>
	h3, h4 {
		color: rgba(0, 0, 0, 0.70);
	}
  table > tbody > tr > td:first-child, table > tbody > tr > td:nth-child(2) {
		word-break: break-word;
		width: 160px;
	}
	table > tbody > tr > td:first-child > p {
		margin-bottom: 0;
	}
	.v-expansion-panel-content>>> .v-expansion-panel-content__wrap {
  	padding: 0 !important;
	}
</style>