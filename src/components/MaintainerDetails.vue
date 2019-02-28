<template>
  <v-card class="grey lighten-3">
    <v-card-title>
      <span class="primary--text">{{ maintainer.title }}&nbsp;</span>
      <h2 class="primary--text">
        {{ maintainer.name }}
      </h2>
    </v-card-title>
    <v-card-text>
      <span class="new-line-span">Phone: {{ maintainer.phone }}</span>
      <span class="new-line-span">Mobile: {{ maintainer.mobile_phone }}</span>
      <span class="new-line-span">Email: {{ maintainer.email }}</span>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn
        flat
        class="primary--text"
        @click.prevent="confirmDelete"
      >
        Delete
      </v-btn>
      <v-btn
        class="primary white--text"
        @click.prevent="editMaintainer(maintainer.index)"
      >
        Edit
      </v-btn>
    </v-card-actions>
    <confirm-dailog
      message="Are you sure you want to delete this maintainer?"
      :dailog-model="confirmationDailog"
      @clickConfirmEvent="deleteMaintainer"
      @clickCloseEvent="closeConfirm"
    />
  </v-card>
</template>

<script>
import axios from 'axios';
import ConfirmDailog from './ConfirmDailog.vue';
import * as env from '../environments/environment.json';

export default {
  name: 'MaintainerDetails',
  components: { ConfirmDailog },
  props: { maintainer: { type: Object, required: true } },

  data: () => ({
    confirmationDailog: false,
  }),
  update() {

  },
  methods: {
    confirmDelete() {
      this.confirmationDailog = true;
    },
    closeConfirm() {
      this.confirmationDailog = false;
    },
    editMaintainer() {
      this.$emit('editMaintainerEvent', this.maintainer.index);
    },
    deleteMaintainer() {
      if ('id' in this.maintainer) {
        axios
          .delete(`${env.API_URL}maintainers/${this.maintainer.id}`)
          .then(() => {
            this.confirmationDailog = false;
            this.$emit('maintainerDeleteEvent', this.maintainer.index);
          });
      } else {
        this.confirmationDailog = false;
        this.$emit('maintainerDeleteEvent', this.maintainer.index);
      }
    },
  },
};
</script>
