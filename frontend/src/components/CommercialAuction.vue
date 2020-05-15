<template>
  <AuctionTemplate
    :pAuction="pAuction"
    :pUsePayPal="false"
  >
    <v-container
      class="bid-container"
    >
      <h2>Starting bid: {{ pAuction.auction_data[0].start_bid }} EUR</h2>
      <v-row>
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

            <v-card>
              <v-card-title>
                Attention
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
          </v-dialog>
        </v-col>
      </v-row>
    </v-container>
  </AuctionTemplate>
</template>

<script>
import axios from 'axios'

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
      showConfirmationDialog: false
    }
  },
  methods: {
    submitBid () {

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
</style>