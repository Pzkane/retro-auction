<template>
  <v-card
    outlined
  >
    <v-card-title>
      <ImageLightbox
        class="lightbox"
        :src="imgSrc()"
      />
      <h2
        class="auction-object-title font-weight-light"
      >
        {{ pAuction.auction_object.name }}
      </h2>
    </v-card-title>
    
    <v-card-text>
      <slot />
      <v-container
        v-if="!isUserIsLogged"
      >
        <h3>You need to Log In to be able to participate</h3>
      </v-container>
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
                  {{ participant.amount }} EUR
                </v-chip>
              </v-col>
            </v-row>
          </v-container>
        </div>
      </v-container>
    </v-card-text>
    <v-card-actions
      v-if="checkPayPal"
    >
      <v-container
        v-if="canUserParticipate"
      >
        <v-text-field
          v-model="amount"
          label="Amount (EUR)"
          outlined
          clearable
          :rules="[scoped_rules.charityAmount]"
        />
        <v-btn
          @click="showPayPalDialog = true"
          block
          depressed
          color="#ffc439"
          :disabled="!correctAmount"
        >
          Participate
        </v-btn>
        <modal-dialog
          v-if="showPayPalDialog"
          class="modal"
          @closeModal="closePayPalDialog()"
        >
          <v-card>
            <v-container>
              <PayPal
                class="dialog"
                :pAmount="Number(amount)"
                :pProduct="auctionProduct"
              />
            </v-container>
          </v-card>
        </modal-dialog>
      </v-container>
    </v-card-actions>
  </v-card>
</template>

<script>
import PayPal from 'vue-paypal-checkout'

export default {
  components: {
    ImageLightbox: () => import('./helpers/ImageLightbox'),
    ModalDialog: () => import('./helpers/ModalDialog'),
    PayPal: () => import('./PayPal')
  },
  props: {
    pAuction: {type: Object, default: null},
    pUsePayPal: {type: Boolean, default: true}
  },
  data () {
    return {
      amount: 100.00,
      paypal: {
        sandbox: 'AfmV7MYZEqRm0p_NtJREd41YtDYyRm5LVkxeXnnQW1kRs9YK2hCG3ItNUzecp173afMRFOZoJWq9jhMu',
        production: '<production client id>'
      },
      total_amount: 0,
      showPayPalDialog: false,
      auctionProduct: {},

      scoped_rules: {
        charityAmount: v => (!!v && v > 0 && v <= (this.pAuction.auction_data[0].goal - this.total_amount)) || 'Invalid amount'
      },
    }
  },
  computed: {
    canUserParticipate: function () {
      if (this.pAuction.participants.find(participant => participant.id === this.$auth.user().id)) {
        return false
      }
      return true
    },
    checkPayPal: function () {
      if (Object.keys(this.$auth.user()).length && this.pUsePayPal) {
        return true
      }
      return false
    },
    correctAmount: function () {
      if (this.total_amount >= this.pAuction.auction_data[0].goal) {
        return false
      }
      if (this.amount > 0 && this.amount <= (this.pAuction.auction_data[0].goal - this.total_amount)) {
        return true
      }
      return false
    },
    isUserIsLogged: function () {
      if (Object.keys(this.$auth.user()).length !== 0) {
        return true
      }
      return false
    }
  },
  watch: {
    pAuction: function () {
      this.getTotalAmount()
      this.setTotalAmount()
    }
  },
  created () {
    this.getTotalAmount()
    this.setTotalAmount()

    this.auctionProduct = {
      auctionId: this.pAuction.id,
      description: this.pAuction.auction_object.name
    }
  },
  methods: {
    closePayPalDialog () {
      this.showPayPalDialog = false
      this.$emit('updateAuction')
    },
    getTotalAmount () {
      this.total_amount = 0
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
  .auction-object-title {
    margin-top: 10px;
  }
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