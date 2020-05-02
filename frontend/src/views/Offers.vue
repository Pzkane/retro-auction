<template>
  <v-app>
    <v-container>
      <v-row>
        <v-col lg="3">
          <v-card>
            <v-card-title>
              <h1 class="display-1">
                Filter list
              </h1>
            </v-card-title>
          </v-card>
        </v-col>
        <v-col>
          <v-card>
            <v-row>
              <v-card-title darken-2>
                <h1 class="display-1">
                  Offer list
                </h1>
              </v-card-title>
              <v-spacer />
              <v-card-actions class="pr-6">
                <v-dialog
                  v-model="addOfferDialog"
                  max-width="1500px"
                >
                  <template #activator="{on}">     
                    <v-btn 
                      v-if="getAuthState()"
                      v-on="on"
                    >
                      Add Offer
                    </v-btn>                                
                  </template>
                  <AddOffer
                    @closeAddOfferDialog="addOfferDialog = false" 
                  />
                </v-dialog>
              </v-card-actions>
            </v-row>
                        
            <v-divider />                        
            <v-container
              id="offers"
              pa-0
            >
              <v-card v-if="isError">
                <ConnectionError :error-code="errorCode" />
              </v-card>
                            
              <v-container
                v-if="isLoading"
                id="loading"
                class="loading"
              >
                <Loading />
              </v-container>
                            
              <v-container
                v-if="!isLoading"
                class="offers-wrapper"
              >
                <v-row
                  v-if="isEmptySet"
                  style="margin-top: 25%;"
                  align="center"
                  justify="center"
                >
                  <v-col lg="3">
                    <v-divider />    
                  </v-col>
                  <v-col lg="3">
                    <p
                      style="text-align: center;"
                      align-content-center
                    >
                      Nothing to show
                    </p>
                  </v-col>
                  <v-col lg="3">
                    <v-divider />    
                  </v-col>
                </v-row>
                <v-container
                  v-for="item in offers"
                  :key="item.id"
                  justify-space-around
                >
                  <v-card style="border-radius: 5px 5px 0 5px;">
                    <v-row ml-5>
                      <v-card-title
                        pl-5
                        class="headline"
                      >
                        {{ item.title }}
                      </v-card-title>
                    </v-row>
                    <v-row>
                      <v-col lg="4">
                        <v-img
                          class="image"
                          :src="item.image"
                          alt="No Image"
                        />
                      </v-col>

                      <v-col>
                        <v-card-text>{{ item.body }}</v-card-text>
                      </v-col>
                    </v-row>
                  </v-card>
                  <v-row
                    class="justify-end"
                    mr-5
                  >
                    <v-dialog
                      v-model="showOfferDialog"
                      max-width="1500px"
                    >
                      <template #activator="{on}">     
                        <!-- <v-btn 
                                                    v-on="on"
                                                    v-if="getAuthState()"
                                                >Add Offer</v-btn>      -->
                        <v-btn
                          x-large
                          style="border-radius: 0 0 5px 5px;margin-right: 11px"
                          color="primary"
                          v-on="on"
                        >
                          More
                        </v-btn>                           
                      </template>
                      <ShowOffer
                        :offer="item"
                      />
                    </v-dialog>                                      
                  </v-row>
                </v-container>
              </v-container>    
            </v-container>
            <v-divider />
            <v-pagination 
              v-model="page_number"
              style="margin: 15px;"
              :length="page_count"
              :total-visible="7"
              :disabled="isPaginationDisabled"
              @input="offers_update"
              @next="offers_update"
              @previous="offers_update"
            />
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </v-app>
</template>

<script>
import AddOffer from '@/components/AddOffer.vue'
import ShowOffer from '@/components/ShowOffer.vue'
import Loading from '@/components/Loading.vue'
import ConnectionError from '@/components/ConnectionError.vue'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
    name: 'Offers',
    components: {
        AddOffer,
        ShowOffer,
        Loading,
        ConnectionError
    },
    data() {
        return {
            offers: [],
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
        },
        showMore(itemID) {
            return this.offers[itemID];
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