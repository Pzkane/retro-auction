<template>
  <v-list
    flat
  >
    <v-list-item-group
      v-if="pAuctions"
    >
      <v-list-item
        v-for="auction in pAuctions"
        :key="auction.id"
      >
        <v-list-item-content>
          <v-list-item-title
            class="item-title"
          >
            <div>
              {{ auction.auction_object.name }}
            </div>
            <div
              v-if="isFinished() && activeAuction"
            >
              <h3>Finished</h3>
            </div>
            <v-spacer />
            EXPAND
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-item-group>
  </v-list>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    pAuctions: {type: Array, default: null},
    pIsActive: {type: Boolean, default: false}
  },
  data () {
    return {
      activeAuction: null
    }
  },
  created () {
    if (this.pIsActive) {
      this.activeAuction = this.pAuctions[0]
    }
  },
  methods: {
    isFinished () {
      if (this.activeAuction) {
        switch (this.activeAuction.type) {
          case 'charity':
            let sum = 0
            this.activeAuction.participants.map(participant => sum += participant.amount)
            if (sum >= this.activeAuction.auction_data[0].goal) {
              return true
            }
            return false
        
          case 'commercial':
            if (new Date().toLocaleDateString() > new Date(this.activeAuction.auction_data[0].end_date).toLocaleDateString()) {
              return true
            }
            return false
        }
      }
      return false
    }
  }
}
</script>

<style scoped>
  .item-title {
    display: flex;
  }
</style>