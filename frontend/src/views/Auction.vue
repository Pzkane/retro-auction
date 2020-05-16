<template>
  <v-container>
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
      <v-col
        md="6"
      >
        <v-row>
          <AuctionHistory :pAuctionArray="charityAuctions" />
        </v-row>
        <v-row>
          <AuctionHistory :pAuctionArray="commercialAuctions" />
        </v-row>
      </v-col>
    </v-row>
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
      commercialAuctions: []
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

<style>

</style>