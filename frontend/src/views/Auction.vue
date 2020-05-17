<template>
  <v-container
    class="wrapper"
  >
    <v-row>
      <v-col
        md="6"
      >
        <CharityAuction
          v-if="activeCharityAuction"
          :pAuction="activeCharityAuction"
          @updateAuction="fetchActiveAuctions()"
        />
      </v-col>
      <v-col
        md="6"
      >
        <CommercialAuction
          v-if="activeCommercialAuction"
          :pAuction="activeCommercialAuction"
          @updateAuction="fetchActiveAuctions()"
        />
      </v-col>
    </v-row>
    <v-container
      class="history-dialog"
    >
      <v-dialog
        v-model="showHistoryDialog"
        style="width: 100%;"
        fullscreen
      >
        <template
          #activator="{ on }"
        >
          <v-btn
            class="history-btn"
            v-on="on"
            large
          >
            History
          </v-btn>
        </template>

        <v-container
          class="history-container"
        >
          <v-row>
            <div
              class="close-btn-container"
            >
              <v-btn
                class="close-btn"
                @click="showHistoryDialog = false"
                icon
                outlined
              >
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </div>
          </v-row>
          <v-row>
            <AuctionHistory 
              :pAuctionArray="charityAuctions"
              pType="charity"
            />
          </v-row>
          <v-row>
            <AuctionHistory
              :pAuctionArray="commercialAuctions"
              pType="commercial"
            />
          </v-row>
        </v-container>
      </v-dialog>
    </v-container>
  </v-container>
</template>

<script>
import axios from 'axios'

export default {
  components: {
    AuctionHistory: () => import('../components/AuctionHistory'),
    CharityAuction: () => import('../components/CharityAuction'),
    CommercialAuction: () => import('../components/CommercialAuction')
  },
  data () {
    return {
      activeCharityAuction: null,
      activeCommercialAuction: null,

      charityAuctions: [],
      commercialAuctions: [],

      showHistoryDialog: false
    }
  },
  created () {
    this.fetchAuctions()
  },
  methods: {
    fetchActiveAuctions() {
      axios
        .get('http://127.0.0.1:8000/api/auctions')
        .then(res => {          
          const {data:{data}} = res
          let activeAuctions;
          if (!data) {
            return
          } else if (data.length) {
            activeAuctions = data
          } else {
            activeAuctions = [data]
          }

          this.activeCharityAuction = activeAuctions.find(auction => {
            return auction.type === 'charity'
          })

          this.activeCommercialAuction = activeAuctions.find(auction => {
            return auction.type === 'commercial'
          })
        })
        .catch(err => {
          console.log(`Error fetching active auctions: ${err}`)          
        })
    },
    fetchDismissedAuctions() {
      axios
        .get('http://127.0.0.1:8000/api/auctions/dismissed')
        .then(res => {
          const {data:{data}} = res
          let dismissedAuctions;
          if (!data) {
            return
          } else if (data.length) {
            dismissedAuctions = data
          } else {
            dismissedAuctions = [data]
          }

          this.charityAuctions = dismissedAuctions.filter(auction => {
            return auction.type === 'charity'
          })
          
          this.commercialAuctions = dismissedAuctions.filter(auction => {
            return auction.type === 'commercial'
          })
        })
        .catch(err => {
          console.log(`Error fetching dismissed auctions: ${err}`)          
        })
    },
    fetchAuctions () {
      this.fetchActiveAuctions()
      this.fetchDismissedAuctions()
    }
  }
}
</script>

<style scoped>
  .close-btn {
    float: right;
    margin-right: 20px;
  }
  .close-btn-container {
    width: 100%;
  }
  .history-btn {
    position: fixed;
    margin: 0;
    width: 100%;
    left: 0;
    bottom: 0;
    border: 1px solid;
    border-radius: 25px 25px 0 0;
  }
  .history-container {
    height: 100%;
    min-width: 100%;
    background-color: white;
  }
  .history-dialog {
    text-align-last: end;
    position: absolute;
    top: 0;
    right: 0;
  }
  .wrapper {
    margin-bottom: 100px;
  }
</style>