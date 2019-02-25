<template>
  <v-card>
    <v-card-title
      heading
      class="px-4"
    >
      <h2
        v-if="customer.id"
        class="heading mb-0 primary--text"
      >
        Edit Customer
      </h2>
      <h2
        v-else
        class="heading mb-0 primary--text"
      >
        Add New Customer
      </h2>
    </v-card-title>
    <v-divider />
    <v-card-text>
      <v-form ref="customerDetailsForm">
        <v-container class="pa-0">
          <v-layout wrap>
            <v-flex xs12>
              <v-text-field
                v-model="customer.name"
                :rules="nameRules"
                label="Name*"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="customer.street"
                :rules="streetRule"
                label="Street 1*"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="customer.street_two"
                :rules="street2Rule"
                label="Street 2*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-autocomplete
                v-model="customer.country"
                :items="countries"
                :rules="countryRule"
                color="blue"
                item-text="name"
                label="Select Country*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-autocomplete
                v-model="customer.state"
                :items="states"
                :rules="stateRule"
                color="blue"
                item-text="name"
                label="Select State*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-autocomplete
                v-model="customer.city"
                :items="cities"
                :rules="cityRule"
                color="blue"
                item-text="name"
                label="Select City*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-text-field
                v-model="customer.zipcode"
                label="Zipcode"
                :rules="zipCodeRule"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="customer.business_id"
                :rules="BusnessIdRule"
                label="Business ID*"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="customer.service_team_geo_area"
                label="Service Team / Geological Area"
              />
            </v-flex>
            <v-radio-group v-model="customer.company_type">
              <v-radio
                v-for="(type,index) in companyTypes"
                :key="index"
                color="primary"
                :label="type.label"
                :value="type.value"
              />
            </v-radio-group>
          </v-layout>
        </v-container>
      </v-form>
    </v-card-text>
    <v-card-actions
      v-if="customer.id"
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
        @click.prevent="updateCustomer"
      >
        update customer
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
        @click="submitCustomer"
      >
        Submit
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import axios from 'axios';
import * as env from '../../environments/environment.json';

export default {
  name: 'CustomerForm',
  data: () => ({
    customerEditMode: false,
    customer: {
      name: null,
      street: null,
      street_two: null,
      city: null,
      state: null,
      zipcode: null,
      country: null,
      business_id: null,
      service_team_geo_area: null,
      company_type: 'private',
      groups: [],
    },
    companyTypes: [
      { label: 'Is Private Household?', value: 'private' },
      { label: 'Is Company?', value: 'company' },
    ],
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
    zipCodeRule: [v => !!v || 'ZipCode is required', v => /^(0|[1-9][0-9]*)$/.test(v) || 'ZipCode must be numeric'],
    cityRule: [v => !!v || 'City is required'],
    BusnessIdRule: [
      v => !!v || 'Business ID is required',
      v => (v && (v.toString().length >= 3)) || 'Business ID must be greter then 3 characters',
      v => /^(0|[1-9][0-9]*)$/.test(v) || 'Business ID must be numeric',
    ],
  }),
  updated() {
    // this.$refs.customerDetailsForm.resetValidation();
  },
  methods: {
    initCustomer() {
      this.$refs.customerDetailsForm.resetValidation();
      this.customer = {
        name: null,
        street: null,
        street_two: null,
        city: null,
        state: null,
        zipcode: null,
        country: null,
        business_id: null,
        service_team_geo_area: null,
        company_type: 'private',
        groups: [],
      };
    },
    clickFormCancel() {
      this.$emit('closeFormEvent');
      this.initCustomer();
    },
    updateCustomer() {
      if (this.$refs.customerDetailsForm.validate()) {
        // call update customer api, need to send only customer request
        const customerId = this.customer.id;
        axios
          .put(
            `${env.API_URL}customers/${customerId}`,
            {
              customer: this.customer,
            },
          )
          .then(() => {
            this.$emit('updateCustomersEvent');
            this.clickFormCancel();
          });
      }
    },
    submitCustomer() {
      if (this.$refs.customerDetailsForm.validate()) {
        this.$emit('submitCustomerEvent');
      }
    },
  },
};
</script>
