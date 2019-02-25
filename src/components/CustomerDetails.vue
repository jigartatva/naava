<template>
  <v-card class="grey lighten-3">
    <v-card-title>
      <h2 class="primary--text">
        {{ customer.name }}
      </h2>
    </v-card-title>
    <v-card-text>
      <p>{{ customer.street }}, {{ customer.street_two }}</p>
      <span>#{{ customer.business_id }}</span>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn
        flat
        class="primary--text"
        @click="confirmDelete(customer.id)"
      >
        Delete
      </v-btn>
      <v-btn
        class="primary white--text"
        @click="editCustomer"
      >
        Edit
      </v-btn>
    </v-card-actions>
    <confirm-dailog
      message="Are you sure you want to delete this customer?"
      :dailog-model="confirmationDailog"
      @clickConfirmEvent="deleteCustomer"
      @clickCloseEvent="closeConfirm"
    />
  </v-card>
</template>

<script>
import axios from 'axios';
import ConfirmDailog from './ConfirmDailog.vue';
import * as env from '../environments/environment.json';

export default {
  name: 'CustomerDetails',
  components: { ConfirmDailog },
  props: { customer: { type: Object, required: true } },

  data: () => ({
    confirmationDailog: false,
  }),

  methods: {
    confirmDelete() {
      this.confirmationDailog = true;
    },
    closeConfirm() {
      this.confirmationDailog = false;
    },
    deleteCustomer() {
      axios
        .delete(
          `${env.API_URL}customers/${this.customer.id}`,
        )
        .then(() => {
          this.confirmationDailog = false;
          this.$emit('getCustomerEvent');
        });
    },
    editCustomer() {
      axios
        .get(
          `${env.API_URL}customers/${this.customer.id}/edit`,
        )
        .then((response) => {
          this.$emit('editCustomerEvent', response.data.data);
        });
    },
  },
};
</script>

<style scoped>
</style>
