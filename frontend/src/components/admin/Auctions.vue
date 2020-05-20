<template>
  <v-card
    outlined
  >
    <v-card-title>Active Auctions</v-card-title>
    <v-divider />
    <v-card-subtitle>
      <h3>Charity</h3>
    </v-card-subtitle>
    <AuctionList
      v-if="activeCharityAuction"
      :pAuctions="[activeCharityAuction]"
      :pIsActive="true"
    />
    <v-card-actions
      v-else
    >
      <v-btn
        depressed
        color="primary"
      >
        Add Auction
      </v-btn>
    </v-card-actions>

    <v-card-subtitle>
      <h3>Commercial</h3>
    </v-card-subtitle>
    <AuctionList
      v-if="activeCommercialAuction"
      :pAuctions="[activeCommercialAuction]"
      :pIsActive="true"
    />

    <v-divider />
    <v-card-title>Dismissed Auctions</v-card-title>
    <v-divider />
    <v-card-subtitle>
      <h3>Charity</h3>
    </v-card-subtitle>
    <AuctionList
      :pAuctions="charityAuctions"
    />
    
    <v-card-subtitle>
      <h3>Commercial</h3>
    </v-card-subtitle>
    <AuctionList
      :pAuctions="commercialAuctions"
    />
  </v-card>
</template>

<script>
import fetchAuctions from '../../plugins/fetchAuctions'

export default {
  components: {
    AuctionList: () => import('./AuctionList')
  },
  data () {
    return {
      activeCharityAuction: null,
      activeCommercialAuction: null,

      charityAuctions: [],
      commercialAuctions: [],
    }
  },
  created () {
    this.fetchActiveAuctions()
    this.fetchDismissedAuctions()
  },
  methods: {
    async fetchActiveAuctions() {
      const response = await fetchAuctions('http://127.0.0.1:8000/api/auctions')
      this.activeCharityAuction = response.charityAuctions
      this.activeCommercialAuction = response.commercialAuctions
    },
    async fetchDismissedAuctions() {
      const response = await fetchAuctions('http://127.0.0.1:8000/api/auctions/dismissed', 'dismissed')
      this.charityAuctions = response.charityAuctions
      this.commercialAuctions = response.commercialAuctions
    }
  }
}
</script>

<style scoped>
  .v-card__subtitle {
    padding-top: 20px;
    padding-bottom: 0;
  }
</style>