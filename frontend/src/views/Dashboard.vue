<template>
  <v-app>
    <v-container>
      <v-row>
        <v-col lg="2">
          <v-card>
            <v-img
              class="mx-auto" 
              height="200px" 
              width="200px" 
              src="../assets/logo.png"
            />
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">
                  {{ $auth.user().username }}
                </h3>
                <div>
                  {{ $auth.user().name }} {{ $auth.user().surname }}
                </div>
              </div>
            </v-card-title>
            <v-card-actions>
              <v-dialog
                v-model="editDialog"
                max-width="800px"
              >
                <template #activator="{on}">                                     
                  <v-btn 
                    text 
                    color="primary"
                    v-on="on" 
                  >
                    Edit
                  </v-btn>
                </template>

                <v-card>
                  <v-card-title>Edit profile</v-card-title>
                  <v-card-text>
                    <v-form ref="form">
                      <v-container>
                        <v-row class="align-center">
                          <v-col lg="2">
                            <v-subheader
                              color="black"
                              class="align-center title"
                            >
                              Name
                            </v-subheader>
                          </v-col>
                          <v-col lg="4">
                            <v-text-field
                              v-model="name"
                              :counter="24"
                              :rules="[rules.textOnly, rules.length.name]"
                            />
                          </v-col>
                          <v-col lg="2">
                            <v-subheader
                              color="black"
                              class="title"
                            >
                              Surname
                            </v-subheader>
                          </v-col>
                          <v-col lg="4">
                            <v-text-field
                              v-model="surname"
                              :counter="24"
                              :rules="[rules.textOnly, rules.length.surname]"
                            />
                          </v-col>
                        </v-row>

                        <v-row class="align-center">
                          <v-col lg="2">
                            <v-subheader
                              color="black"
                              class="title"
                            >
                              Username
                            </v-subheader>
                          </v-col>
                          <v-col lg="4">
                            <v-text-field
                              v-model="username"
                              :counter="16"
                              :rules="[rules.length.newUsername]"
                            />
                          </v-col>
                        </v-row>

                        <v-row>
                          <v-expand-transition>
                            <p 
                              v-show="errors.username"
                              style="color: red;"
                              class="subtitle-2 pl-5"
                            >
                              <v-icon
                                color="red"
                                size="17px"
                                class="pr-1"
                              >
                                mdi-alert
                              </v-icon>{{ errors.username ? errors.username[0] : '' }}
                            </p>
                          </v-expand-transition>
                        </v-row>

                        <v-row class="align-center">
                          <v-col lg="2">
                            <v-subheader
                              color="black"
                              class="title"
                            >
                              Email
                            </v-subheader>
                          </v-col>
                          <v-col lg="4">
                            <v-text-field
                              v-model="email"
                              :rules="[rules.newEmail]"
                            />
                          </v-col>

                          <v-col>
                            <v-radio-group
                              v-model="gender"
                              :label="'Gender'"
                              :rules="[rules.requiredItem]"
                              class="pl-4 pt-0 mt-0"
                            >
                              <v-radio
                                color="primary"
                                :label="'Male'"
                                :value="'male'"
                              />
                              <v-radio
                                color="primary"
                                :label="'Female'"
                                :value="'female'"
                              />
                            </v-radio-group>
                          </v-col>
                        </v-row>

                        <v-row>
                          <v-expand-transition>
                            <p 
                              v-show="errors.email"
                              style="color: red;"
                              class="subtitle-2 pl-5"
                            >
                              <v-icon
                                color="red"
                                size="17px"
                                class="pr-1"
                              >
                                mdi-alert
                              </v-icon>{{ errors.email ? errors.email[0] : '' }}
                            </p>
                          </v-expand-transition>
                        </v-row>

                        <v-row class="justify-center">
                          <v-btn
                            text
                            color="primary"
                            @click="changePass = !changePass"
                          >
                            Change Password
                          </v-btn>
                        </v-row>

                        <v-expand-transition>
                          <v-container>
                            <v-text-field
                              v-show="changePass"
                              v-model="password"
                              prepend-icon="mdi-lock"
                              type="password"
                              label="New Password"
                              :counter="16"
                              :rules="[rules.length.newPassword]"
                            />
                            <v-text-field
                              v-show="changePass"
                              v-model="password_confirmation"
                              prepend-icon="mdi-lock"
                              label="Confirm Password"
                              type="password"
                              :rules="[scoped_rules.passwordConfirmation]"
                            />
                          </v-container>
                        </v-expand-transition>
                                                
                        <v-card-actions>
                          <v-btn 
                            :disabled="isLoading"
                            :loading="isLoading"
                            @click="submit()"
                          >
                            Submit
                          </v-btn>
                        </v-card-actions>
                      </v-container>
                    </v-form>
                  </v-card-text>
                </v-card>
              </v-dialog>
                            
              <v-dialog
                v-model="deleteDialog"
                max-width="800px"
              >
                <template #activator="{on}">     
                  <v-btn 
                    text 
                    color="error"
                    v-on="on" 
                  >
                    Delete
                  </v-btn>                                
                </template>

                <v-card>
                  <v-card-title>Delete Account</v-card-title>
                  <v-card-text>
                    <p>Attention: You are deleting Your account. This cannot be undone. Would You like to proceed?</p> 
                  </v-card-text>
                  <v-card-actions>
                    <v-btn
                      color="error"
                      @click="deleteAcc()"
                    >
                      Delete
                    </v-btn>
                    <v-btn
                      color="primary"
                      @click="deleteDialog = !deleteDialog"
                    >
                      Cancel
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-card-actions>
          </v-card>
        </v-col>

        <v-col>
          <v-card>
            <v-card-title primary-title>
              <div>
                <h3 class="headline mb-0">
                  Placed Offers
                </h3>
                <div class="subtitle mb-0">
                  Your placed offers
                </div>
              </div>
            </v-card-title>
            <v-divider />
            <v-card-text>
              <v-container>
                <v-row>
                  <v-col lg="2">
                    <v-img 
                      src="../assets/logo.png"
                      height="100px"
                      width="100px"
                    />
                  </v-col>

                  <v-col lg="3">
                    <h3>Offer title</h3>
                  </v-col>

                  <v-col>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nesciunt corrupti officia dolores architecto odio necessitatibus consequatur iste, magnam itaque expedita culpa accusantium rem molestiae asperiores voluptate omnis minus, eius vel?</p>
                  </v-col>
                </v-row>
                <v-divider />
              </v-container>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
// import Offers from "./Offers.vue"
import axios from 'axios'
import external_rules from '@/plugins/rules/rules.js'

export default {
  components: {
    // Offers
  },
  data() {
    return {
      email: this.$auth.user().email,
      username: this.$auth.user().username,
      name: this.$auth.user().name,
      surname: this.$auth.user().surname,
      gender: this.$auth.user().gender,
      password: null,
      password_confirmation: null,
      scoped_rules: {
        passwordConfirmation: v => ((!v && !this.password) || (v && v == this.password) ) || 'Fields do not match',
      },

      rules: external_rules,

      editDialog: false,
      deleteDialog: false,
      changePass: false,

      userObject: {},

      errors: {},
      errorCode: null,

      isLoading: false,
      isError: false
    }
  },
  created: {
    fetchUser () {
      this.getUserInfo()
    }
  },
  methods: {
    submit () {
      if (this.$refs.form.validate()) {
        this.update();
      }
    },
    update () {
      this.errors = {}
      this.isError = false
      this.isLoading = true
      this.userObject = {
        id: this.$auth.user().id,
        email: this.email,
        username: this.username,
        name: this.name,
        surname: this.surname,
        gender: this.gender,
        password: this.password
      }

      axios.post('http://127.0.0.1:8000/api/auth/userUpdate',
        { 
          id: this.$auth.user().id,
          email: this.email,
          username: this.username,
          name: this.name,
          surname: this.surname,
          gender: this.gender,
          password: this.password
        },
          { 
            headers: {
              'Authorization': 'Bearer '+this.$auth.token(),
            }
        }).then(() => {
          this.$auth.user(this.userObject)
          this.editDialog = false
          this.isLoading = false
        }).catch( err => { 
          if (err.response.status != 422){
            this.isError = true
            this.errorCode = err.response.status
          }
          this.isLoading = false
          this.error = err.response.data.error
          this.errors = err.response.data.errors || {}
        });
    },
    deleteAcc () {
      this.$auth.logout({
        success: function () {
          axios
            .delete('http://127.0.0.1:8000/api/auth/userDelete', this.$auth.user().id)
            .catch( err => {
              console.log('error: ', err)
            })
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