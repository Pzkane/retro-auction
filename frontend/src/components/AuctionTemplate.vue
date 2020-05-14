<template>
  <v-card>
    <v-card-title>
      <ImageLightbox
        class="lightbox"
        :src="imgSrc()"
      />
      {{ pAuction.auction_object.name }}
    </v-card-title>
    
    <v-card-text>
      <slot />
      <v-container>
        <div
          v-for="participant in pAuction.participants"
          :key="participant.id"
        >
          <v-divider />
          <v-container
            class="participant-row"
          >
            <v-row>
              <v-col
                cols="2"
              >
                <div>
                  <v-img
                    class="profile-pic"
                    :src="participant.avatar_path"
                    width="32"
                    height="32"
                  />
                </div>
              </v-col>
              <v-col
                cols="5"
                class="participant-col"
              >
                {{ participant.username }}
              </v-col>
              <v-col
                class="participant-col"
              >
                <v-chip>
                  {{ participant.amount }}$
                </v-chip>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
import VuetifyExtensions from './extensions/index'

export default {
  components: {
    ImageLightbox: () => import('./helpers/ImageLightbox')
  },
  props: {
    pAuction: {type: Object, default: null}
  },
  data () {
    return {
      total_amount: 0
    }
  },
  created () {
    this.getTotalAmount()
    this.setTotalAmount()
  },
  methods: {
    getTotalAmount () {
      this.pAuction.participants.map(participant => {
        this.total_amount += participant.amount
      })
    },
    imgSrc () {
      if (this.pAuction) {
        return this.pAuction.auction_object.preview_image
      }
      return ''
    },
    setTotalAmount () {
      let operation
      switch (this.pAuction.type) {
        case 'charity':
          operation = 'setCharityTotal'
          break
      
        case 'commercial':
          operation = 'setCommercialTotal'
          break
      }
      this.$store.commit(operation, this.total_amount)
    }
  }
}
</script>

<style scoped>
  .lightbox {
    width: 100%;
  }
  .participant-col {
    align-self: center;
  }
  .participant-row {
    padding: 0;
  }
  .profile-pic {
    border-radius: 50%;
  }
</style>