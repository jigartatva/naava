import Vue from 'vue';
import Vuetify from 'vuetify';
import App from './App.vue';

Vue.config.productionTip = false;
Vue.use(Vuetify, {
  theme: {
    primary: '#1b5c3d',
    secondary: '#b0bec5',
    accent: '#8c9eff',
    error: '#b71c1c',
  },
});

new Vue({
  render: h => h(App),
}).$mount('#app');

// Helpers
