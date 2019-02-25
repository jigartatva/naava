<template>
  <v-dialog
    v-model="dailogModel"
    max-width="450"
  >
    <v-card>
      <v-card-title class>
        <h2>{{ message }}</h2>
      </v-card-title>
      <v-card-actions>
        <v-spacer />
        <v-btn
          color="primary"
          flat="flat"
          @click="emmitCloseEvent"
        >
          No
        </v-btn>
        <v-btn
          color="primary"
          @click="emmitConfirmEvent"
        >
          Yes
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'ConfirmDailog',
  props: ['message', 'dailogModel'],
  mounted() {
    if (this.message === '' || typeof (this.message) === 'undefined') {
      this.message = 'Are you sure you want to delete this item?';
    }
  },
  methods: {
    confirmDelete() {
      this.dailogModel = true;
    },
    closeConfirm() {
      this.dailogModel = false;
    },
    emmitConfirmEvent() {
      this.$emit('clickConfirmEvent');
    },
    emmitCloseEvent() {
      this.$emit('clickCloseEvent');
    },
  },
};
</script>

<style scoped>
</style>
