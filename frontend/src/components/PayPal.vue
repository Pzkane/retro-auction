<template>
  <div>
    <div v-if="!isPaid">
      <div
        class="description"
      >
        <h1>Auction participation amount</h1>
        <h2>{{ product.description }}</h2>

        <div
          class="price"
        >
          <h1>{{ product.price }} EUR</h1>
        </div>
      </div>
    </div>

    <div v-if="isPaid">
      <h1>{{ response.status }}</h1>
      <h1>{{ response.message }}</h1>
      <v-btn
        block
        @click="closePayPal()"
      >
        Ok
      </v-btn>
    </div>

    <div
      v-if="!isPaid"
    >
      <div
        class="loading-container"
        v-if="!isLoaded"
      >
        <v-progress-circular
          class="loading"
          indeterminate
          color="white"
        />
      </div>
      <div
        class="paypal-container"
        ref="paypal"
      />
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    pAmount: { type: Number, default: 0 },
    pProduct: { type: Object, default: null },
  },
  data () {
    return {
      isLoaded: false,
      isPaid: false,
      product: {
        price: 0,
        description: ""
      },

      response: {
        status: null,
        message: ''
      }
    };
  },
  created () {
    this.product.price = this.pAmount
    this.product.description = this.pProduct.description
    console.log(this.pProduct.auctionId);
    
  },
  mounted () {
    const script = document.createElement("script")
    script.src = "https://www.paypal.com/sdk/js?currency=EUR&client-id=AfmV7MYZEqRm0p_NtJREd41YtDYyRm5LVkxeXnnQW1kRs9YK2hCG3ItNUzecp173afMRFOZoJWq9jhMu"
    script.addEventListener("load", this.loadPayPalComponent)
    document.body.appendChild(script);
  },
  methods: {
    closePayPal () {
      this.$emit('closeModal')
    },
    loadPayPalComponent: function() {
      window.paypal.Buttons({
        style: {
          size: 'small',
          color: 'gold',
          shape: 'pill',
          label: 'checkout',
        },
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [
              {
                description: this.product.description,
                amount: {
                  currency_code: "EUR",
                  value: this.product.price
                }
              }
            ]
          })
        },
        onApprove: async (data, actions) => {
          const order = await actions.order.capture();
          console.log(order);
          if (order.status === "COMPLETED") {
            this.insertAuctionParticipant(this.product.price)
          }
        },
        onError: err => {
          console.log(err);
        }
      })
      .render(this.$refs.paypal)
        .then(() => {
          this.isLoaded = true
        })
    },
    insertAuctionParticipant (price) {
      const config = { 
        headers: { 
          'Authorization': 'Bearer '+this.$auth.token(),
          'Content-Type': 'multipart/form-data' 
        }
      }
      const participantData = new FormData()
      console.log(this.$auth.user().id)
      participantData.append('auction_id', this.pProduct.auctionId)
      participantData.append('user_id', this.$auth.user().id)
      participantData.append('amount', price)

      axios
        .post(
          'http://127.0.0.1:8000/api/auth/addParticipant',
          participantData,
          config
        )
        .then(res => {
          switch (res.status) {
            case 200:
              this.response.status = 'Success'
              this.response.message = `Successfull participation in the auction!`
              break

            case 500:
              this.response.status = 'Error'
              this.response.message = 'Server is not responging. Error code: 500'
              break
          
            default:
              this.response.status = 'Hmm...'
              this.response.message = 'Something went wrong...'
              break
          }
          this.isPaid = true;
        })
    }
  }
}
</script>

<style scoped>
  .description {
    text-align: center;
  }
  .loading {
    top: 50%;
  }
  .loading-container {
    position: absolute;
    background-color:rgba(0, 0, 0, 0.561);
    top: 0;
    left: 0;
    width: 100%;
    text-align-last: center;
    height: 100%;
    z-index: 90;
  }
  .paypal-container {
    position: relative;
    z-index: 0;
  }
  .price {
    border: 1px solid lightgrey;
    border-radius: 50px;
  }
</style>