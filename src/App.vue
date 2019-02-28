<template>
  <div id="app">
    <v-app
      id="inspire"
      class="grey lighten-3"
    >
      <AppHeader />
      <CustomerPage />
    </v-app>
  </div>
</template>
<style>
.v-toolbar {
  background-color: #1b5c3d !important;
  border-color: #1b5c3d !important;
}
</style>
<script>
import AppHeader from './components/AppHeader.vue';
import CustomerPage from './components/CustomerPage.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
    CustomerPage,
  },
};
</script>
<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
.new-line-span {
  display: block !important;
}
</style>
