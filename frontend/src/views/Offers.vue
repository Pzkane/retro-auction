<template>
    <v-app>
        <v-container>
            <v-row>
                <v-col lg="3">
                    <v-card>
                        <v-card-title>
                            <h1 class="display-1">Filter list</h1>
                        </v-card-title>
                    </v-card>
                </v-col>
                <v-col>
                    <v-card>
                        <v-row>
                            <v-card-title darken-2>
                                <h1 class="display-1">Offer list</h1>
                            </v-card-title>
                            <v-spacer></v-spacer>
                            <v-card-actions class="pr-6">
                                <v-dialog v-model="addOfferDialog" max-width="1500px">
                                    <template v-slot:activator="{on}">     
                                        <v-btn 
                                            v-on="on"
                                        >Add Offer</v-btn>                                
                                    </template>
                                    <AddOffer
                                        v-on:closeAddOfferDialog="addOfferDialog = false" 
                                    />
                                </v-dialog>
                            </v-card-actions>
                        </v-row>
                        
                        <v-divider></v-divider>                        
                        <v-container pa-0 id="offers">
                        
                            <v-card v-if="isError">
                                <ConnectionError :errorCode="errorCode" />
                            </v-card>
                            
                            <v-container class="loading" id="loading" v-if="isLoading">
                                <Loading/>
                            </v-container>
                            
                            <v-container class="offers-wrapper" v-if="!isLoading">
                                <v-row v-if="isEmptySet" style="margin-top: 25%;" align="center" justify="center">
                                    <v-col lg="3">
                                        <v-divider></v-divider>    
                                    </v-col>
                                    <v-col lg="3">
                                        <p style="text-align: center;" align-content-center>Nothing to show</p>
                                    </v-col>
                                    <v-col lg="3">
                                        <v-divider></v-divider>    
                                    </v-col>
                                </v-row>
                                <v-container justify-space-around v-for="item in offers" :key="item.id">
                                    <v-card style="border-radius: 5px 5px 0 5px;">
                                        <v-row ml-5>
                                            <v-card-title pl-5 class="headline">{{ item.title }}</v-card-title>
                                        </v-row>
                                        <v-row>
                                            <v-col lg="4">
                                                <v-img class="image" :src="item.image" alt="No Image"></v-img>
                                            </v-col>

                                            <v-col>
                                                <v-card-text>{{ item.body }}</v-card-text>
                                            </v-col>
                                        </v-row>
                                    </v-card>
                                    <v-row justify-end mr-5>
                                        <v-spacer></v-spacer><v-btn x-large style="border-radius: 0 0 5px 5px;margin-right: 11px" color="primary">More</v-btn>
                                    </v-row>
                                </v-container>
                            </v-container>    
                        </v-container>
                        <v-divider></v-divider>
                        <v-pagination 
                            style="margin: 15px;"
                            v-model="page_number"
                            :length="page_count"
                            :total-visible="7"
                            :disabled="isPaginationDisabled"
                            @input="offers_update"
                            @next="offers_update"
                            @previous="offers_update"
                        ></v-pagination>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
import AddOffer from '@/components/AddOffer.vue'
import Loading from '@/components/Loading.vue'
import ConnectionError from '@/components/ConnectionError.vue'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    name: 'offers',
    components: {
        AddOffer,
        Loading,
        ConnectionError
    },
    data() {
        return {
            offers: null,
            page_count: null,
            page_number: 1,

            isPaginationDisabled: false,
            isLoading: true,
            isError: false,
            isEmptySet: false,

            addOfferDialog: false,

            errorCode: null
        }
    },
    created() {
        this.getRequest('http://127.0.0.1:8000/api/offers')
    },
    methods: {
        ...mapGetters([
            'getAuthState',
        ]),
        getRequest(path) {
            axios
                .get(path)
                .then(res => {
                    const {data:{data}} = res
                    if (!data.length)
                        this.isEmptySet = true
                    else
                        this.isEmptySet = false
                    this.setOffers(data)
                    this.isLoading = false
                    const {data:{meta}} = res
                    this.isPaginationDisabled = false
                    this.setPageCount(meta.last_page)
                })
                .catch(err => {
                    this.errorCode = err.response.status
                    this.responseError()
                })
        },
        responseError() {
            this.isLoading = false;
            this.isError = true;
            return true;
        },
        setOffers(data) {
            this.offers = data;
        },
        setPageCount(data) {
            this.page_count = data;
        },
        getPageNumber() {
            return this.page_number;
        },
        getOffers() {
            return this.offers;
        },
        getPageCount() {
            return this.page_count;
        },
        offers_update() {
            this.isPaginationDisabled = true;
            this.isLoading = true;
            this.isError = false;
            let pagePath = 'http://127.0.0.1:8000/api/offers?page=';
            pagePath += this.page_number;
            this.getRequest(pagePath);
        },
        closeAddOfferDialog() {
            this.addOfferDialog = !this.addOfferDialog
        }
    },
}
</script>

<style scoped>
    #offers {
        margin: 0 auto;
        display: block;
        height: 690px;
        /* max-width: 50%; */
        overflow: auto;
    }
    .loading {
        margin: 0 auto;
        padding-top: 25%;
        padding-left: 49%;
    }
    .err {
        padding-top: 12em;
        line-height: 2em;
    }
    #offers h2 {
        text-align: left;
    }
    img {
        padding-left: 12px;
        max-width: 300px;
    }
    .offers {
        overflow: hidden;
        /* border: solid 4px; */
    }
    .offers h2 {
        position: relative;
        /* border: solid 1px red; */
    }
    .offers p {
        position: relative;
        width: 50%;
        float: left;
        /* border: solid 1px red; */
        margin-bottom: 20px;
        text-align: justify;
    }
    .offers button {
        margin-top: 20px;
        margin-right: 50px;
        padding: 20px;
        float: right;
    }
</style>