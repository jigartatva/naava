<template>
  <div id="app">
    <v-app
      id="inspire"
      class="grey lighten-3"
    >
      <v-toolbar
        dark
        fixed
        app
      >
        <v-toolbar-title>
          <img
            alt="Vue logo"
            src="./assets/Logo_Naava.png"
          >
        </v-toolbar-title>
      </v-toolbar>
      <v-content class="pt-0">
        <v-container fill-height>
          <v-layout>
            <v-flex xs12>
              <v-layout
                wrap
                xs12
                class="customer"
              >
                <v-flex
                  xs12
                  :class="showCustomerListing ? 'd-flex' : 'd-none'"
                >
                  <v-card class="elevation-0">
                    <v-card-title
                      heading
                      class="pa-0 px-4"
                    >
                      <h2
                        class="heading mb-0 primary--text"
                      >
                        Customer
                      </h2>
                      <v-spacer />
                      <v-flex xs3>
                        <v-text-field
                          v-model="searchCustomerString"
                          label="Search"
                          prepend-icon="search"
                          @input="searchCustomer"
                        />
                      </v-flex>
                    </v-card-title>
                    <v-divider />
                    <v-card-text class="px-0">
                      <v-container grid-list-lg>
                        <v-layout wrap>
                          <v-flex
                            xs12
                            md3
                            sm6
                          >
                            <v-card
                              class="fill-height add-user elevation-0"
                              @click.prevent="addCustomerClick"
                            >
                              <v-card-text>
                                <span class="text-xs-center d-inline-block add-user-icon">
                                  <v-icon
                                    class="grey--text text--lighten-1"
                                  >
                                    add_circle_outline
                                  </v-icon>
                                  <br>
                                  <span class="grey--text text--lighten-1">Add New Customer</span>
                                </span>
                              </v-card-text>
                            </v-card>
                          </v-flex>
                          <v-flex
                            v-for="(customer, index) in customers"
                            :key="index"
                            xs12
                            md3
                            sm6
                          >
                            <CustomerDetails
                              :customer="customer"
                              @getCustomerEvent="getCustomers"
                              @editCustomerEvent="editCustomer"
                            />
                          </v-flex>
                          <v-flex
                            xs12
                            text-xs-center
                            mt-3
                          >
                            <v-pagination
                              v-show="customerPagination.total_page>0"
                              v-model="customerPagination.current_page"
                              small
                              :length="customerPagination.total_page"
                              @input="getCustomers"
                            />
                          </v-flex>
                        </v-layout>
                      </v-container>
                    </v-card-text>
                  </v-card>
                </v-flex>
                <v-flex
                  xs12
                  :class="showCustomerForm ? 'd-flex' : 'd-none'"
                >
                  <CustomerForm
                    ref="customerFormRef"
                    @updateCustomersEvent="updateCustomer"
                    @closeFormEvent="closeCustomerForm"
                    @submitCustomerEvent="createCustomer"
                  />
                </v-flex>
              </v-layout>

              <!-- Wall Groups -->
              <v-layout
                wrap
                xs12
                class="customer"
              >
                <v-flex
                  xs12
                  :class="(showCustomerForm && showGroupListing ) ? 'd-flex' : 'd-none'"
                >
                  <v-card class="elevation-0">
                    <v-card-title
                      heading
                      class="px-4 d-flex"
                    >
                      <h2
                        class="heading mb-0 primary--text"
                      >
                        Wall Groups
                      </h2>
                    </v-card-title>
                    <v-divider />
                    <v-card-text class="px-0 d-flex">
                      <v-container grid-list-lg>
                        <v-layout wrap>
                          <v-flex
                            xs12
                            md3
                            sm6
                          >
                            <v-card
                              class="fill-height add-user elevation-0"
                              @click.native="addWallGroupClick"
                            >
                              <v-card-text>
                                <span class="text-xs-center d-inline-block add-user-icon">
                                  <v-icon
                                    class="grey--text text--lighten-1"
                                  >
                                    add_circle_outline
                                  </v-icon>
                                  <br>
                                  <span class="grey--text text--lighten-1">Add Wall Group</span>
                                </span>
                              </v-card-text>
                            </v-card>
                          </v-flex>
                          <v-flex
                            v-for="(group,index) in customerGroups"
                            v-show="customer.groups.length>0"
                            :key="index"
                            xs12
                            md3
                            sm6
                          >
                            <GroupDetails
                              :group="group"
                              @editGroupEvent="editGroup"
                              @groupDeleteEvent="groupDelete"
                            />
                          </v-flex>
                          <v-flex
                            xs12
                            text-xs-center
                            mt-3
                          >
                            <v-pagination
                              v-show="groupPagination.total_page > 0"
                              v-model="groupPagination.current_page"
                              small
                              :length="groupPagination.total_page"
                              @input="setGroupPagination"
                            />
                            <!-- @next="nextGroup"
                            @previousGroup="previousGroup"-->
                          </v-flex>
                        </v-layout>
                      </v-container>
                    </v-card-text>
                  </v-card>
                </v-flex>
                <v-flex
                  xs12
                  :class="(showCustomerForm && showGroupForm) ? 'd-flex' : 'd-none'"
                >
                  <WallGroupForm
                    ref="wallGroupFormRef"
                    @addWallGroupToUserEvent="addWallGroupToUser"
                    @closeFormEvent="closeWallGroupForm"
                    @updateWallgroupDataEvent="setUpdatedWallgroupData"
                  />
                </v-flex>
              </v-layout>

              <!-- Maintenance Contacts -->
              <v-layout
                wrap
                xs12
                class="customer"
              >
                <v-flex
                  xs12
                  :class="(showGroupForm && showMaintainerListing) ? 'd-flex' : 'd-none'"
                >
                  <v-card class="elevation-0">
                    <v-card-title
                      heading
                      class="px-4 d-flex"
                    >
                      <h2
                        class="heading mb-0 primary--text"
                      >
                        Maintenance Contacts
                      </h2>
                    </v-card-title>
                    <v-divider />
                    <v-card-text
                      class="px-0"
                      :class="addMaintainer ? 'd-none' : 'd-flex'"
                    >
                      <v-container grid-list-lg>
                        <v-layout wrap>
                          <v-flex
                            xs12
                            md3
                            sm6
                          >
                            <v-card
                              class="fill-height add-user elevation-0"
                              @click.native="addMaintainerClick"
                            >
                              <v-card-text>
                                <span class="text-xs-center d-inline-block add-user-icon">
                                  <v-icon
                                    class="grey--text text--lighten-1"
                                  >
                                    add_circle_outline
                                  </v-icon>
                                  <br>
                                  <span
                                    class="grey--text text--lighten-1"
                                  >
                                    Add Maintenance Contacts
                                  </span>
                                </span>
                              </v-card-text>
                            </v-card>
                          </v-flex>
                          <v-flex
                            v-for="(maintainer,index) in groupMaintainers"
                            v-show="wallgroup.maintainers.length>0"
                            :key="index"
                            xs12
                            md3
                            sm6
                          >
                            <MaintainerDetails
                              :maintainer="maintainer"
                              @editMaintainerEvent="editMaintainer"
                              @maintainerDeleteEvent="maintainerDelete"
                            />
                          </v-flex>
                          <v-flex
                            xs12
                            text-xs-center
                            mt-3
                          >
                            <v-pagination
                              v-model="maintainerPagination.current_page"
                              small
                              :length="maintainerPagination.total_page"
                              @input="setMaintainerPagination"
                            />
                          </v-flex>
                        </v-layout>
                      </v-container>
                    </v-card-text>
                  </v-card>
                </v-flex>
                <v-flex
                  xs12
                  :class="(showGroupForm && showMaintainerForm) ? 'd-flex' : 'd-none'"
                >
                  <MaintainerForm
                    ref="maintainerFromRef"
                    @addMaintainerToWallGroupEvent="addMaintainerToWallGroup"
                    @closeFormEvent="closeMaintainerForm"
                  />
                </v-flex>
              </v-layout>
            </v-flex>
          </v-layout>
        </v-container>
      </v-content>
      <v-snackbar
        v-model="alertMessage"
        bottom
      >
        {{ messageText }}
        <v-btn
          color="yellow"
          flat
          @click="alertMessage = false"
        >
          Close
        </v-btn>
      </v-snackbar>
    </v-app>
  </div>
</template>
<style scoped>
.v-toolbar {
  background-color: #1b5c3d !important;
  border-color: #1b5c3d !important;
}
.add-user {
  cursor: pointer;
}
.add-user >>> .v-card__text {
  height: 100%;
  display: flex;
}
.add-user >>> .v-card__text .add-user-icon {
  margin: auto;
  font-size: 22px;
}
.add-user >>> .v-card__text .add-user-icon i {
  font-size: 50px;
}
.add-user {
  border: 2px dashed #d2d2d2 !important;
}
.add-user:hover {
  border: 2px dashed #1b5c3d !important;
}
.add-user:hover >>> .v-card__text .add-user-icon i,
.add-user:hover >>> .v-card__text .add-user-icon span {
  color: #1b5c3d !important;
}
</style>

<script>
import 'vuetify/dist/vuetify.min.css';
import axios from 'axios';
import CustomerDetails from './components/CustomerDetails.vue';
import GroupDetails from './components/GroupDetails.vue';
import MaintainerDetails from './components/MaintainerDetails.vue';
import MaintainerForm from './components/Form/MaintainerForm.vue';
import WallGroupForm from './components/Form/WallGroupForm.vue';
import CustomerForm from './components/Form/CustomerForm.vue';
import * as env from './environments/environment.json';

export default {
  name: 'App',
  components: {
    CustomerDetails,
    GroupDetails,
    MaintainerDetails,
    MaintainerForm,
    WallGroupForm,
    CustomerForm,
  },
  data: () => ({
    drawer: null,
    searchCustomerString: '',
    addCustomer: false,
    page: 1,
    addWallGroup: false,
    addMaintainer: false,
    customerEditMode: false,
    groupEditMode: false,
    maintainerEditMode: false,
    alertMessage: false,
    messageText: '',
    items: ['option1', 'option2'],
    customer: {
      groups: [],
    },
    wallgroup: {
      maintainers: [],
    },
    customerGroups: [],
    groupMaintainers: [],
    customers: null,
    total_page: null,
    current_page: 1,
    customerPagination: {
      total_page: 0,
      current_page: 0,
      limit: 2,
    },
    groupPagination: {
      total_page: 0,
      current_page: 0,
      limit: 2,
    },
    maintainerPagination: {
      total_page: 0,
      current_page: 0,
      limit: 2,
    },
    customerCurrentPage: 1,
    groupCurrentPage: 1,
    maintainerCurrentPage: 1,

    showCustomerForm: false,
    showCustomerListing: true,
    showGroupForm: false,
    showGroupListing: false,
    showMaintainerForm: false,
    showMaintainerListing: false,
  }),

  mounted() {
    this.getCustomers();
  },

  methods: {
    getCustomers() {
      const config = {
        headers: {
          'Content-Type': 'application/json',
        },
      };
      axios
        .get(
          `${env.API_URL}customers?page=${
            this.customerPagination.current_page
          }&search=${this.searchCustomerString}`,
          config,
        )
        .then((response) => {
          this.customers = response.data.data.data;
          this.customerPagination.total_page = response.data.data.last_page;
          this.customerPagination.current_page = response.data.data.current_page;
          this.customerCurrentPage = this.customerPagination.current_page;

          this.showCustomerForm = false;
          this.showCustomerListing = true;
        });
    },
    addCustomerClick() {
      this.customer.groups = [];
      this.showCustomerForm = true;
      this.showCustomerListing = false;
      this.showGroupListing = true;
      this.showGroupForm = false;
      this.groupPagination.current_page = 1;
      this.groupPagination.total_page = 1;
      this.setGroupPagination();
    },
    createCustomer() {
      if (this.$refs.customerFormRef.$refs.customerDetailsForm.validate()) {
        axios
          .post('https://www.anasource.com/team4/naava/public/api/customers', {
            customer: this.$refs.customerFormRef.customer,
          })
          .then(() => {
            this.messageText = 'Customer Added!';
            this.alertMessage = true;
            this.$refs.customerFormRef.initCustomer();
            this.getCustomers();
          });
      }
    },
    editCustomer(data) {
      this.customerEditMode = true;
      this.customer = data;

      this.addCustomer = false;
      this.groupEditMode = false;
      this.maintainerEditMode = false;

      this.$refs.customerFormRef.customerEditMode = true;
      this.$refs.customerFormRef.customer = data;

      this.$refs.customerFormRef.addCustomer = false;
      this.$refs.wallGroupFormRef.groupEditMode = false;
      this.$refs.maintainerFromRef.maintainerEditMode = false;
      this.$refs.wallGroupFormRef.initWallGroup();
      this.$refs.maintainerFromRef.initMaintainer();

      this.showCustomerForm = true;
      this.showCustomerListing = false;
      this.showGroupListing = true;
      this.showGroupForm = false;

      this.groupPagination.current_page = 1;

      if (this.customer.groups.length < this.groupPagination.limit) {
        this.groupPagination.total_page = 1;
      } else {
        // eslint-disable-next-line
        this.groupPagination.total_page = Math.ceil(this.customer.groups.length / this.groupPagination.limit);
      }

      this.setGroupPagination();
    },
    updateCustomer() {
      this.messageText = 'Customer Updated!';
      this.alertMessage = true;
      this.getCustomers();
    },
    closeCustomerForm() {
      this.addCustomer = false;
      this.customerEditMode = false;
      this.addWallGroup = false;
      this.groupEditMode = false;
      this.addMaintainer = false;
      this.maintainerEditMode = false;
      this.$refs.wallGroupFormRef.initWallGroup();

      this.showCustomerListing = true;
      this.showCustomerForm = false;
      this.showGroupForm = false;
      this.showGroupListing = false;
      this.showMaintainerForm = false;
      this.showMaintainerListing = false;
    },
    searchCustomer() {
      if (this.searchCustomerString.trim().length >= 3 || this.searchCustomerString === '') {
        this.getCustomers();
      }
    },

    /* Wallgrop methods */
    addWallGroupClick() {
      this.showGroupForm = true;
      this.showGroupListing = false;
      this.showMaintainerListing = true;
      this.showMaintainerForm = false;
      this.wallgroup.maintainers = [];
      this.maintainerPagination.current_page = 1;
      this.maintainerPagination.total_page = 1;
      this.setMaintainerPagination();
    },
    addWallGroupToUser(newWallGroup) {
      this.$refs.customerFormRef.customer.groups.push(newWallGroup);
      this.customer.groups = this.$refs.customerFormRef.customer.groups;

      this.showGroupForm = false;
      this.showGroupListing = true;

      this.groupPagination.current_page = 1;

      const groupLength = this.customer.groups.length;

      if (groupLength < this.groupPagination.limit) {
        this.groupPagination.total_page = 1;
      } else {
        this.groupPagination.total_page = Math.ceil(groupLength / this.groupPagination.limit);
      }
      this.messageText = 'Wall Group Added!';
      this.alertMessage = true;
      this.setGroupPagination();
      // this.$refs.wallGroupFormRef.initWallGroup();
    },
    editGroup(index) {
      this.groupEditMode = true;
      this.addWallGroup = false;

      this.showGroupListing = false;
      this.showGroupForm = true;
      this.showMaintainerListing = true;
      this.showMaintainerForm = false;

      this.wallgroup = this.customer.groups[index];

      this.$refs.wallGroupFormRef.wallgroup = this.wallgroup;
      this.$refs.wallGroupFormRef.groupEditMode = true;

      this.maintainerPagination.current_page = 1;

      this.setMaintainerPagination();
    },
    setUpdatedWallgroupData(data) {
      this.messageText = 'Wall Group Updated!';
      this.alertMessage = true;
      this.$refs.customerFormRef.customer.groups = data;
      this.customer.groups = this.$refs.customerFormRef.customer.groups;
      this.setGroupPagination();
    },
    setGroupPagination() {
      this.customerGroups = [];
      let starting = (this.groupPagination.current_page - 1) * this.groupPagination.limit;
      const ending = starting + this.groupPagination.limit;

      if (starting < 0) {
        starting = 0;
      }
      const referenceGroups = this.customer.groups;

      for (let i = starting; i < ending; i += 1) {
        if (referenceGroups[i]) {
          const temp = referenceGroups[i];
          temp.index = i;

          this.customerGroups.push(temp);
        }
      }

      if (this.customerGroups.length === 0 && this.groupPagination.current_page !== 1) {
        this.groupPagination.current_page = this.groupPagination.current_page - 1;
        this.groupPagination.total_page = this.groupPagination.total_page - 1;
        this.setGroupPagination();
      }
    },
    closeWallGroupForm() {
      this.addWallGroup = false;
      this.groupEditMode = false;
      this.addMaintainer = false;
      this.maintainerEditMode = false;
      this.$refs.wallGroupFormRef.initWallGroup();
      this.showGroupListing = true;
      this.showGroupForm = false;
    },
    groupDelete(index) {
      this.customer.groups = this.customer.groups.filter((val, i) => {
        if (i === index) {
          return false;
        }
        return true;
      });
      this.$refs.customerFormRef.customer.groups = this.customer.groups;
      this.messageText = 'Wall Group Deleted!';
      this.alertMessage = true;
      this.setGroupPagination();
    },

    /* Maintainers methods */
    addMaintainerToWallGroup(newMantainer) {
      this.$refs.wallGroupFormRef.wallgroup.maintainers.push(newMantainer);
      this.wallgroup.maintainers = this.$refs.wallGroupFormRef.wallgroup.maintainers;

      this.showMaintainerListing = true;
      this.showMaintainerForm = false;
      const maintainerLength = this.wallgroup.maintainers.length;
      if (maintainerLength < this.maintainerPagination.limit) {
        this.maintainerPagination.total_page = 1;
      } else {
        // eslint-disable-next-line
        this.maintainerPagination.total_page = Math.ceil(maintainerLength / this.maintainerPagination.limit);
      }
      this.messageText = 'Maintainer Added!';
      this.alertMessage = true;
      this.setMaintainerPagination();
    },
    addMaintainerClick() {
      this.showMaintainerForm = true;
      this.showMaintainerListing = false;
    },
    editMaintainer(index) {
      this.maintainerEditMode = true;
      this.$refs.maintainerFromRef.maintainerEditMode = true;
      this.$refs.maintainerFromRef.maintainer = this.wallgroup.maintainers[
        index
      ];

      this.showMaintainerForm = true;
      this.showMaintainerListing = false;
    },
    closeMaintainerForm() {
      this.addMaintainer = false;
      this.maintainerEditMode = false;
      this.$refs.maintainerFromRef.initMaintainer();
      // this.$refs.maintainerFromRef.maintainerEditMode = false

      this.showMaintainerListing = true;
      this.showMaintainerForm = false;
    },
    maintainerDelete(index) {
      this.wallgroup.maintainers = this.wallgroup.maintainers.filter(
        (val, i) => {
          if (i === index) {
            return false;
          }
          return true;
        },
      );
      this.$refs.wallGroupFormRef.wallgroup.maintainers = this.wallgroup.maintainers;
      this.messageText = 'Maintainer Deleted!';
      this.alertMessage = true;
      this.setMaintainerPagination();
    },
    cancelMaintainer() {
      this.$refs.maintainerFromRef.initMaintainer();

      this.showMaintainerForm = false;
      this.showMaintainerListing = true;
    },
    setMaintainerPagination() {
      this.groupMaintainers = [];
      const referecneMaintainers = this.wallgroup.maintainers;

      // calculate total pages
      const maintainerLength = this.wallgroup.maintainers.length;
      if (maintainerLength < this.maintainerPagination.limit) {
        this.maintainerPagination.total_page = 1;
      } else {
        // eslint-disable-next-line
        this.maintainerPagination.total_page = Math.ceil(maintainerLength / this.maintainerPagination.limit);
      }

      let starting = (this.maintainerPagination.current_page - 1) * this.maintainerPagination.limit;
      const ending = starting + this.maintainerPagination.limit;

      if (starting < 0) {
        starting = 0;
      }

      for (let i = starting; i < ending; i += 1) {
        if (referecneMaintainers[i]) {
          const temp = referecneMaintainers[i];
          temp.index = i;
          this.groupMaintainers.push(temp);
        }
      }

      if (this.groupMaintainers.length === 0 && this.maintainerPagination.current_page !== 1) {
        this.maintainerPagination.current_page = this.maintainerPagination.current_page - 1;
        this.maintainerPagination.total_page = this.maintainerPagination.total_page - 1;
        this.setMaintainerPagination();
      }
    },

    /* General methods */
    clickCancel() {
      this.addCustomer = false;
      this.addWallGroup = false;
      this.addMaintainer = false;
      this.$refs.customerFormRef.initCustomer();
      this.$refs.wallGroupFormRef.initWallGroup();
      this.$refs.maintainerFromRef.initMaintainer();

      this.showCustomerForm = false;
      this.showCustomerListing = true;

      this.showGroupListing = false;
      this.showGroupForm = false;
      this.showMaintainerForm = false;
      this.showMaintainerListing = false;
    },
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
</style>
