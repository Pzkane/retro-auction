<template>
  <v-app v-if="$auth.ready()">
    <v-container>
      {{authAdmin}}
    </v-container>
    <v-tabs fixed-tabs v-model="activeTab">
      <v-tab to="/">Home</v-tab>
      <v-tab to="/offers">Offers</v-tab>
      <v-tab to="/about">About</v-tab>
      <v-tab v-if="!getAuthState()" to="/signup">Sign Up</v-tab>
      <v-tab v-if="$auth.check()" to="/dashboard">Dashboard</v-tab>
      <v-tab v-if="authAdmin" to="/admin">Control Panel</v-tab>
      <v-tab v-if="$auth.user().role === 'super_admin'" to="/sadmin">System Managment</v-tab>
      <v-divider :vertical="true"></v-divider>
      <v-menu
        v-if="!getAuthState()"
        :close-on-click="true"
        :close-on-content-click="getLoginButton()"
        :offset-x="true"
        :offset-y="true"
      >
        <template v-slot:activator="{ on }">
          <v-btn 
            style="height: 100%; width: 100%; border-radius: 0"
            max-width="10%"
            fill-height
            text
            v-on="on"
          >
            Log In
          </v-btn>
        </template>

        <v-list>
          <v-list-item>
            <Login/>
          </v-list-item>
        </v-list>
      </v-menu>

      <v-btn 
        v-if="getAuthState()"
        style="height: 100%; width: 100%; border-radius: 0"
        max-width="10%"
        fill-height
        text
        :loading="isLoading"
        :disabled="isLoading"
        @click="logout"
      >
        Log Out
      </v-btn>

      <v-tab-item id="/">
        <router-view v-if="activeTab === '/'"/>
      </v-tab-item>
      <v-tab-item id="/offers">
        <router-view v-if="activeTab === '/offers'"/>
      </v-tab-item>
      <v-tab-item id="/about">
        <router-view v-if="activeTab === '/about'"/>
      </v-tab-item>
      <v-tab-item id="/signup">
        <router-view v-if="activeTab === '/signup'"/>
      </v-tab-item>
      <v-tab-item id="/dashboard">
        <router-view v-if="activeTab === '/dashboard'"/>
      </v-tab-item>
      <v-tab-item id="/admin">
        <router-view v-if="activeTab === '/admin'"/>
      </v-tab-item>
      <v-tab-item id="/sadmin">
        <router-view v-if="activeTab === '/sadmin'"/>
      </v-tab-item>
    </v-tabs>
  </v-app>
</template>

<script>
import Login from '@/components/Login'
import { mapGetters, mapMutations } from 'vuex'

export default {
  name: 'app',
  components: {
    Login
  },
  data() {
    return {
      activeTab: null,

      isLoading: false
    }
  },
  computed: {
    authAdmin: function () {
      if (this.$auth.user().role === 'admin' || this.$auth.user().role === 'super_admin') {
        return true
      }

      return false
    }
  },
  created() {
    this.$auth.ready(function () {
        if (this.$auth.token()) {
          this.fadeLogin()
          this.changeAuthState()
        }
    });
  },
  methods: {
    ...mapGetters([
      'getLoginButton',
      'getAuthState'
    ]),
    ...mapMutations([
      'changeAuthState',
      'fadeLogin'
    ]),
    logout() {
      this.isLoading = true
      this.$auth.logout({
        success: function () {
          this.isLoading = false
          this.fadeLogin()
          this.changeAuthState()
        },
        error: function () {
          console.log("Something went wrong with Your logout!")
        },
      })
    }
  },
}
</script>

<style scoped>

</style>