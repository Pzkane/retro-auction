<template>
  <AuctionTemplate
    :pAuction="pAuction"
  >
    <div>TestCommercial</div>
  </AuctionTemplate>
</template>

<script>
export default {
  components: {
    AuctionTemplate: () => import('./AuctionTemplate')
  },
  props: {
    pAuction: {type: Object, default: null}
  }
}
</script>

<style>

</style>