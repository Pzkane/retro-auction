<template>
  <v-card>
    <v-card-title>
      <v-img
        :src="imgSrc()"
      ></v-img>
    </v-card-title>
    
    <v-card-text>
      <slot></slot>
      <v-container>
        <v-row
          v-for="participant in pAuction.participants" :key="participant.id"
        >
          {{ participant.id }}
        </v-row>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  props: {
    pAuction: {type: Object, default: null}
  },
  data () {
    return {
    }
  },
  methods: {
    imgSrc () {
      if (this.pAuction) {
        return this.pAuction.auction_object.preview_image
      }
      return ''
    }
  }
}
</script>

<style>

</style>