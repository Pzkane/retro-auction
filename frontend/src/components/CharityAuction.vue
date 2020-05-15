<template>
  <AuctionTemplate
    :pAuction="pAuction"
    @updateAuction="fetchUpdatedAuctions()"
  >
    <v-container>
      <v-row>
        <v-progress-linear
          height="25"
          :value="totalProgress"
        >
          Progress
          <v-spacer />
          {{ totalAmount }} / {{ pAuction.auction_data[0].goal || 0 }}$
        </v-progress-linear>
      </v-row>
    </v-container>
  </AuctionTemplate>
</template>

<script>
export default {
  components: {
    AuctionTemplate: () => import('./AuctionTemplate')
  },
  props: {
    pAuction: {type: Object, default: null}
  },
  computed: {
    totalAmount: function () {
      return this.$store.getters['charityTotal']
    },
    totalProgress: function () {
      return (this.totalAmount / this.pAuction.auction_data[0].goal) * 100
    }
  },
  methods: {
    fetchUpdatedAuctions () {
      this.$emit('updateAuction')
    }
  }
}
</script>

<style>

</style>