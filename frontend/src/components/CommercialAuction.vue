<template>
  <AuctionTemplate
    :pAuction="pAuction"
    :pUsePayPal="false"
  >
    <v-container
      class="bid-container"
    >
      <div
        class="crucial-info-container"
      >
        <h2
          class="font-weight-light"
        >
          Starting bid: {{ pAuction.auction_data[0].start_bid }} EUR
        </h2>
        <v-spacer />
        <h3
          class="font-weight-light"
        >
          Ends on: <span class="font-weight-bold">{{ new Date(pAuction.auction_data[0].end_date).toLocaleDateString() }}</span>
        </h3>
      </div>

      <v-row
        v-if="checkUserParticipation"
      >
        <v-col
          class="bid-col"
        >
          <v-text-field
            v-model="bid"
            class="bid-field"
            :value="pAuction.auction_data[0].start_bid"
            :rules="[scoped_rules.commericalAmount]"
            label="Amount (EUR)"
            outlined
          />
        </v-col>
        <v-col
          class="bid-col"
        >
          <v-dialog
            v-model="showConfirmationDialog"
          >
            <template #activator="{ on }">
              <v-btn
                depressed
                color="primary"
                v-on="on"
                @click="showConfirmationDialog = true"
              >
                Place bid
              </v-btn>
            </template>

            <v-card
              v-if="!isPaid"
            >
              <v-card-title>
                Attention!
              </v-card-title>
              <v-card-text>
                By placing a bid of {{ bid }} EUR
                You agree to pay the delivered amount within
                24 hours after the end of the auction.
                Continue?
              </v-card-text>
              <v-card-actions>
                <v-btn
                  text
                  color="primary"
                  @click="submitBid()"
                >
                  Ok
                </v-btn>
                <v-btn
                  text
                  color="error"
                  @click="showConfirmationDialog = false"
                >
                  Cancel
                </v-btn>
              </v-card-actions>
            </v-card>

            <v-card
              v-if="isPaid"
            >
              <v-card-title>
                {{ response.status }}
              </v-card-title>
              <v-card-text>
                {{ response.message }}
              </v-card-text>
              <v-card-actions>
                <v-btn
                  block
                  depressed
                  @click="closeDialog()"
                >
                  Ok
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </v-row>
    </v-container>
  </AuctionTemplate>
</template>

<script>
import axios from 'axios'
import insertAuctionParticipant from '../plugins/insertAuctionParticipant'

export default {
  components: {
    AuctionTemplate: () => import('./AuctionTemplate')
  },
  props: {
    pAuction: {type: Object, default: null}
  },
  data () {
    return {
      bid: this.pAuction.auction_data[0].start_bid,
      scoped_rules: {
        commericalAmount: v => (!!v && v >= this.pAuction.auction_data[0].start_bid) || 'Invalid amount'
      },
      showConfirmationDialog: false,

      response: {
        status: null,
        message: ''
      },
      isPaid: false
    }
  },
  computed: {
    checkUserParticipation: function (params) {
      if (this.isUserIsLogged && !this.pAuction.participants.find(participant => 
        participant.id === this.$auth.user().id
      )) {
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
  methods: {
    closeDialog () {
      this.showConfirmationDialog = false
      this.$emit('updateAuction')
    },
    async submitBid () {
      const insertStatus = await insertAuctionParticipant(
        this.$auth.token(),
        this.$auth.user().id,
        this.pAuction.id,
        this.bid,
        this.response,
        this.isPaid
      )
      this.response.status = insertStatus.response.status
      this.response.message = insertStatus.response.message
      this.isPaid = insertStatus.isPaid
    }
  }
}
</script>

<style scoped>
  .bid-col {
    align-self: center;
  }
  .bid-container {
    padding: 0;
  }
  .bid-field {
    margin-top: 30px;
  }
  .crucial-info-container {
    display: flex;
  }
</style>