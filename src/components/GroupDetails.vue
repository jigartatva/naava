<template>
  <v-card class="grey lighten-3">
    <v-card-title>
      <h2 class="primary--text">
        {{ group.name }}
      </h2>
    </v-card-title>
    <v-card-text>
      <p>{{ group.street }}, {{ group.streetTwo }}</p>
    </v-card-text>
    <v-card-actions>
      <v-spacer />
      <v-btn
        flat
        class="primary--text"
        @click="confirmDelete"
      >
        Delete
      </v-btn>
      <v-btn
        class="primary white--text"
        @click="editGroup"
      >
        Edit
      </v-btn>
    </v-card-actions>
    <confirm-dailog
      message="Are you sure you want to delete this wall group?"
      :dailog-model="confirmationDailog"
      @clickConfirmEvent="deleteGroup"
      @clickCloseEvent="closeConfirm"
    />
  </v-card>
</template>

<script>
import axios from 'axios';
import ConfirmDailog from './ConfirmDailog.vue';
import * as env from '../environments/environment.json';

export default {
  name: 'GroupDetails',
  components: { ConfirmDailog },
  props: { group: { type: Object, required: true } },

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
    editGroup() {
      this.$emit('editGroupEvent', this.group.index);
    },
    deleteGroup() {
      if ('id' in this.group) {
        axios
          .delete(
            `${env.API_URL}wallgroups/${
              this.group.id
            }`,
          )
          .then(() => {
            this.confirmationDailog = false;
            this.$emit('groupDeleteEvent', this.group.index);
          });
      } else {
        // delete this.group;
        this.confirmationDailog = false;
        this.$emit('groupDeleteEvent', this.group.index);
      }
    },
  },
};
</script>

<style scoped>
</style>
