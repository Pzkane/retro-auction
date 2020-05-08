<template>
  <v-container>
    <v-row>
      <v-col>
        <CharityAuction />
      </v-col>
      <v-col>
        <CommercialAuction />
      </v-col>
      <v-col>c</v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  components: {
    CharityAuction: () => import('../components/CharityAuction'),
    CommercialAuction: () => import('../components/CommercialAuction')
  }
}
</script>

<style>

</style>