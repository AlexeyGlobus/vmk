<template>
  <div v-if="isReady">
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
			    	v-for="(accessRight, index) in filteredAccessRights" 
			    	:key="index"
		        >
		          <td class="text-left">
		          	<p>
			          	{{ $t(getTableName(accessRight.table_name)) }}
			          </p>
		        	</td>
		          <td class="text-left">{{ $t(getRoleName(accessRight.role)) }}</td>
		          <td>
      		      <v-checkbox
						      v-model="accessRight.rights.create"
				    		>
	    					</v-checkbox>
		          </td>
		          <td>
      		      <v-checkbox
						      v-model="accessRight.rights.read"
				    		>
	    					</v-checkbox>
		          </td> 
		          <td>
      		      <v-checkbox
						      v-model="accessRight.rights.update"
				    		>
	    					</v-checkbox>
		          </td>
		          <td>
      		      <v-checkbox
						      v-model="accessRight.rights.delete"
				    		>
	    					</v-checkbox>
		          </td> 
		          <td>
		          	<a v-if="canEdit" href="#" @click.prevent="save(accessRight)">Save</a>
		          </td>
		        </tr>
		      </tbody>
		    </template>
		  </v-simple-table>
	  </v-card>
    <h3 v-else>{{ $t('403 Access denied') }}</h3>
	</div>
</template>

<script>
	export default {
		data: () => {
			return {
				table_name: 'access_rights',
				isReady: false,
				prevTableName: ''
			}
		},
    created() {
      this.$store.dispatch('accessRightsAll')
    	.then(() => {
    		this.isReady = !!this.$store.state.accessRights.all.length;
    	});
    },
		computed: {
			//TODO
			canEdit() {
				return true;
			},
			filteredAccessRights() {
				return this.$store.state.accessRights.all.filter(accessRight => {return true})
			}
		},
		methods: {
			tableNameIsChanged(name) {
				let isChanged = (name != this.prevTableName);
				this.prevTableName = name;
				return isChanged;
			},
			getTableName (table) {
				return this.$store.getters.tableName(table) + '';
			},
			getRoleName (role) {
				return this.$store.getters.roleName(role) + '';
			},
			save(a) {
				console.log(a)
			} 
		}
	}
</script>

<style scoped>
	h3, h4 {
		color: rgba(0, 0, 0, 0.70);
	}
</style>