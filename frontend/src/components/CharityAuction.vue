<template>
  <AuctionTemplate
    :pAuction="pAuction"
  >
    <div>TestCharity</div>
  </AuctionTemplate>
</template>

<script>
export default {
  props: {
    pAuction: {type: Object, default: null}
  },
  components: {
    AuctionTemplate: () => import('../components/AuctionTemplate')
  }
}
</script>

<style>

</style>