<template>
  <v-card>
    <v-card-title
      heading
      class="px-4"
    >
      <h2
        v-if="maintainer.index || maintainer.index == 0"
        class="heading mb-0 primary--text"
      >
        Edit Maintenance Contacts
      </h2>
      <h2
        v-else
        class="heading mb-0 primary--text"
      >
        Add Maintenance Contacts
      </h2>
    </v-card-title>
    <v-divider />
    <v-card-text>
      <v-form ref="maintainerDetailsForm">
        <v-container class="pa-0">
          <v-layout wrap>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="maintainer.title"
                label="Title*"
                :rules="titleRule"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-text-field
                v-model="maintainer.name"
                label="Name*"
                :rules="nameRules"
              />
            </v-flex>
            <v-flex
              xs12
              md4
            >
              <v-text-field
                v-model="maintainer.phone"
                :rules="phoneRules"
                label="Phone Number*"
              />
            </v-flex>
            <v-flex
              xs12
              md4
            >
              <v-text-field
                v-model="maintainer.mobile_phone"
                :rules="mobileRules"
                label="Mobile Number*"
              />
            </v-flex>
            <v-flex
              xs12
              md4
            >
              <v-text-field
                v-model="maintainer.email"
                :rules="emailRules"
                label="Email Address*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="maintainer.contact_type"
                :rules="contactTypeRule"
                :items="contact_type"
                label="Contact Type*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="maintainer.priority_contacting_method"
                :items="priority_contacting_methods"
                :rules="contactingMethodRule"
                label="Priority Contacting Method*"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="maintainer.secondary_contacting_method"
                :items="secondary_contacting_methods"
                label="Secondary Contacting Method"
              />
            </v-flex>
            <v-flex
              xs12
              md3
            >
              <v-select
                v-model="maintainer.spoken_language"
                :rules="spokenLangRule"
                :items="spoken_languages"
                label="Spoken Language*"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-textarea
                v-model="maintainer.address"
                name
                label="Address, if it differes from main customer address"
              />
            </v-flex>
            <v-flex
              xs12
              md6
            >
              <v-textarea
                v-model="maintainer.notes"
                name
                label="Notes / Comments"
              />
            </v-flex>
          </v-layout>
        </v-container>
      </v-form>
    </v-card-text>
    <v-card-actions
      v-if="maintainer.index || maintainer.index == 0"
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
        @click.prevent="updateMaintainer"
      >
        Update Maintainer
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
        @click.prevent="addMaintainerToWallGroup"
      >
        Add Maintainer
      </v-btn>
    </v-card-actions>
  </v-card>
</template>
<script>
import axios from 'axios';
import * as env from '../../environments/environment.json';

export default {
  name: 'MaintainerForm',
  data: () => ({
    contact_type: [
      'Water filler',
      'Backup water filler/foreman',
      'Backup of backup',
      'Maintenance contact',
      'Maint. contact and water filler',
    ],
    priority_contacting_methods: [
      'SMS',
      'Email',
      'Phone',
      'Mobile',
      'Pushover service',
    ],
    secondary_contacting_methods: [
      'SMS',
      'Email',
      'Phone',
      'Mobile',
      'Pushover service',
    ],
    spoken_languages: [
      'Finnish',
      'English',
      'Russian',
      'Swedish',
      'Korean',
      'German',
    ],
    maintainer: {
      name: null,
      title: null,
      phone: null,
      mobile_phone: null,
      email: null,
      contact_type: null,
      priority_contacting_method: null,
      secondary_contacting_method: null,
      spoken_language: null,
      address: null,
      notes: null,
    },
    maintainerEditMode: false,
    valid: false,
    titleRule: [
      v => !!v || 'Title is required',
      v => (v && v.length <= 100) || 'Title must be less than 100 characters',
    ],
    nameRules: [
      v => !!v || 'Name is required',
      v => (v && v.length <= 100) || 'Name must be less than 100 characters',
    ],
    phoneRules: [
      v => !!v || 'Phone number is required',
      v => /^(0|[1-9][0-9]*)$/.test(v) || 'Phone must be numeric',
    ],
    mobileRules: [
      v => !!v || 'Mobile is required',
      v => (v && (v.toString().length === 10)) || 'Mobile number must be of 10 digits',
    ],
    emailRules: [
      v => !!v || 'Email is required',
      v => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(.\w{2,3})+$/.test(v) || 'Email must be valid',
    ],
    contactTypeRule: [v => !!v || 'Contact Type is required'],
    contactingMethodRule: [v => !!v || 'Method is required'],
    spokenLangRule: [v => !!v || 'Language is required'],
  }),
  methods: {
    addMaintainerToWallGroup() {
      if (this.$refs.maintainerDetailsForm.validate()) {
        this.$emit('addMaintainerToWallGroupEvent', this.maintainer);
        this.$emit('closeFormEvent');
      }
    },
    initMaintainer() {
      this.$refs.maintainerDetailsForm.resetValidation();
      this.maintainer = {
        name: null,
        title: null,
        phone: null,
        mobile_phone: null,
        email: null,
        contact_type: null,
        priority_contacting_method: null,
        secondary_contacting_method: null,
        spoken_language: null,
        address: null,
        notes: null,
      };
    },
    updateMaintainer() {
      if (this.$refs.maintainerDetailsForm.validate()) {
        if ('id' in this.maintainer) {
          // call update maintainer api, need to send only maintainer object
          const maintainerId = this.maintainer.id;
          axios
            .put(
              `${env.API_URL}maintainers/${maintainerId}`,
              {
                maintainer: this.maintainer,
              },
            )
            .then(() => {
              this.clickFormCancel();
            });
        } else {
          this.clickFormCancel();
        }
      }
    },
    clickFormCancel() {
      this.$emit('closeFormEvent');
      // this.initMaintainer();
    },
  },
};
</script>
