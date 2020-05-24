<template>
  <v-card>
    <v-card-title>
      Users
    </v-card-title>
    <v-card-text>
      <v-container>
        <v-row
          v-for="user in users" :key="user.id"
        >
          {{ user.email }}
        </v-row>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios'

export default {
  data () {
    return {
      users: []
    }
  },
  created () {
    this.fetchUsers()
  },
  methods: {
    fetchUsers () {
      axios
        .get('http://127.0.0.1:8000/api/auth/users')
        .then(res => {
          if (res.data.users.length) {
            this.users = res.data.users
          } else {
            this.users = [res.data.users]
          }
        })
        .catch(err => {
          console.log(err)
        })
    }
  }
}
</script>

<style>

</style>