<template>
  <v-card>
    <v-card-title
      heading
      class="px-4"
    >
      <h2
        v-if="wallgroup.index || wallgroup.index == 0"
        class="heading mb-0 primary--text"
      >
        Edit Wall Groups
      </h2>
      <h2
        v-else
        class="heading mb-0 primary--text"
      >
        Add Wall Groups
      </h2>
    </v-card-title>
    <v-divider />
    <v-card-text>
      <v-form
        ref="wallGroupDetailForm"
        v-model="valid"
      >
        <v-container class="pa-0">
          <v-layout wrap>
            <v-flex xs12>
              <v-text-field
                v-model="wallgroup.name"
                :rules="nameRules"
                label="Name*"
                autofocus
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="wallgroup.street"
                :rules="streetRule"
                label="Street 1*"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="wallgroup.street_two"
                :rules="street2Rule"
                label="Street 2*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="wallgroup.country"
                :rules="countryRule"
                :items="countries"
                color="primary"
                item-text="name"
                label="Select Country*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="wallgroup.state"
                :items="states"
                :rules="stateRule"
                color="primary"
                item-text="name"
                label="Select State*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="wallgroup.city"
                :rules="cityRule"
                :items="cities"
                color="primary"
                item-text="name"
                label="Select City*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-text-field
                v-model="wallgroup.zipcode"
                :rules="zipCodeRule"
                label="Zipcode*"
              />
            </v-flex>
            <v-flex xs12>
              <v-text-field
                v-model="wallgroup.service_team_geo_area"
                label="Service Team / Geological Area"
              />
            </v-flex>
          </v-layout>
        </v-container>
      </v-form>
    </v-card-text>
    <v-card-actions
      v-if="wallgroup.index || wallgroup.index == 0"
      class="px-4"
    >
      <v-spacer />
      <v-btn
        flat
        class="primary--text"
        @click.prevent="clickFormCancel"
      >
        Cancel
      </v-btn>
      <v-btn
        class="primary white--text"
        @click.prevent="updateWallGroup"
      >
        Update Wall Group
      </v-btn>
    </v-card-actions>
    <v-card-actions
      v-else
      class="px-4"
    >
      <v-spacer />
      <v-btn
        flat
        class="primary--text"
        @click.prevent="clickFormCancel"
      >
        Cancel
      </v-btn>
      <v-btn
        class="primary white--text"
        @click.prevent="addWallGroupToUser"
      >
        Add Wall Group
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import axios from 'axios';
import * as env from '../../environments/environment.json';

export default {
  name: 'WallGroupForm',
  data: () => ({
    wallgroup: {
      name: null,
      street: null,
      street_two: null,
      city: null,
      state: null,
      zipcode: null,
      country: null,
      service_team_geo_area: null,
      maintainers: [],
    },
    countries: ['Ind', 'Fin'],
    states: ['Guj', 'Maha'],
    cities: ['Ahm', 'Raj'],
    groupEditMode: false,
    valid: false,
    name: 'Default',
    nameRules: [
      v => !!v || 'Name is required',
      v => (v && v.length <= 100) || 'Name must be less than 100 characters',
    ],
    streetRule: [
      v => !!v || 'Street1 is required',
      v => (v && v.length <= 100) || 'Text must be less than 100 characters',
    ],
    street2Rule: [
      v => !!v || 'Street2 is required',
      v => (v && v.length <= 100) || 'Text must be less than 100 characters',
    ],
    countryRule: [v => !!v || 'Country is required'],
    stateRule: [v => !!v || 'State is required'],
    zipCodeRule: [v => !!v || 'ZipCode is required'],
    cityRule: [v => !!v || 'City is required'],
  }),
  methods: {
    initWallGroup() {
      this.$refs.wallGroupDetailForm.resetValidation();
      this.wallgroup = {
        name: null,
        street: null,
        street_two: null,
        city: null,
        state: null,
        zipcode: null,
        country: null,
        service_team_geo_area: null,
        maintainers: [],
      };
    },
    addWallGroupToUser() {
      if (this.$refs.wallGroupDetailForm.validate()) {
        this.$emit('addWallGroupToUserEvent', this.wallgroup);
        this.clickFormCancel();
      }
    },
    updateWallGroup() {
      // call update group api, need to send only wallgroup object
      const wallgroupId = this.wallgroup.id;
      if ('id' in this.wallgroup && this.wallgroup.id) {
        axios
          .put(
            `${env.API_URL}wallgroups/${wallgroupId}`,
            {
              group: this.wallgroup,
            },
          )
          .then((response) => {
            this.$emit('updateWallgroupDataEvent', response.data.data);

            this.clickFormCancel();
            // this.initWallGroup();
          });
      } else {
        this.clickFormCancel();
      }
    },
    clickFormCancel() {
      this.$emit('closeFormEvent');
      // this.initWallGroup();
    },
  },
};
</script>
