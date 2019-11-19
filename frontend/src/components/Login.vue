<template>
    <v-container fill-height>
        <v-form ref="lForm">
            <v-text-field @keypress.enter.native="login"
                label="Username or Email"
                prepend-icon="mdi-account"
                v-model="loginData"
                :rules="[rules.required]"
            ></v-text-field>
            <v-text-field @keypress.enter.native="login"
                label="Password"
                prepend-icon="mdi-lock"
                v-model="password"
                type="password"
                :rules="[rules.required]"
            ></v-text-field>
            <v-expand-transition>
                <p 
                    v-show="isError"
                    style="color: red;"
                    class="subtitle-2 pl-4"
                ><v-icon color="red" size="17px" class="pr-0 pb-1">mdi-alert</v-icon> Wrong username/email or password</p>
            </v-expand-transition>
            <v-card-actions>
                <v-btn
                    class="mx-auto"
                    text
                    @click="login"
                    :disabled="isLoading"
                    :loading="isLoading"
                >Sign In</v-btn>
            </v-card-actions>
        </v-form>
    </v-container>
</template>

<script>
import { mapMutations } from 'vuex'
import external_rules from  '@/plugins/rules/rules.js'

export default {
    data() {
        return {
            loginData: null,
            password: null,
            info: 'null',

            isLoading: false,

            rules: external_rules,

            errors: {},
            isError: false
        }
    },
    methods: {
        ...mapMutations([
            'fadeLogin',
            'changeAuthState'
        ]),
        login() {
            if (this.$refs.lForm.validate()){
                this.isError = false
                this.isLoading = true
                let that = this
                this.$auth.login({
                    data: {
                        email: that.loginData,
                        username: that.loginData,
                        password: that.password
                    },
                    success: function() {
                        this.isLoading = false
                        this.fadeLogin()
                        this.changeAuthState()
                        const redirectTo = this.redirect ? this.redirect.from.name : this.$auth.user().role === 'super_admin' ? 'sadmin.dashboard' : this.$auth.user().role === 'admin' ? 'admin.dashboard' : 'dashboard'
                        this.$router.push({name: redirectTo})
                    },
                    error : function() {
                        this.isLoading = false
                        this.isError = true
                    },
                    rememberMe: true,
                    fetchUser: true,
                })
            }
        }
    }
}
</script>

<style scoped>
    .form {
        z-index: 1;
    }
</style>