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
                        ></v-img>
                        <v-card-title primary-title>
                            <div>
                                <h3 class="headline mb-0">{{$auth.user().username}}</h3>
                                <div>
                                    {{$auth.user().name}} {{$auth.user().surname}}
                                </div>
                            </div>
                        </v-card-title>
                        <v-card-actions>
                            <v-btn @click="getUserInfo()" text color="primary">text</v-btn>
                            <v-btn text color="primary">text</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>

                <v-col>
                    <v-card>
                        <v-card-title primary-title>
                            <div>
                                <h3 class="headline mb-0">Placed Offers</h3>
                                <div class="subtitle mb-0">
                                    Your placed offers
                                </div>
                            </div>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col lg="2">
                                        <v-img 
                                            src="../assets/logo.png"
                                            height="100px"
                                            width="100px"
                                        ></v-img>
                                    </v-col>

                                    <v-col lg="3">
                                        <h3>TitlTitleTitleTitleTitleTitleTitleTitlee</h3>
                                    </v-col>

                                    <v-col>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nesciunt corrupti officia dolores architecto odio necessitatibus consequatur iste, magnam itaque expedita culpa accusantium rem molestiae asperiores voluptate omnis minus, eius vel?</p>
                                    </v-col>
                                </v-row>
                                <v-divider></v-divider>
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
// import Axios from 'axios'

export default {
    components: {
        // Offers
    },
    data() {
        return {
            username: null,
            name: null,
            surname: null
        }
    },
    created: {
        fetchUser () {
            this.getUserInfo()
        }
    },
    methods: {
        getUserInfo() {
            this.$auth.fetch({
                params: {},
                success: function () {
                    
                },
                error: function () {
                    
                }
            })
        },
    },
}
</script>

<style scoped>
    
</style>