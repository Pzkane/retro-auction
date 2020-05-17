<template>
  <div>
    <div
      v-if="pIsTiled"
    >
      <v-card>
        <v-card-title>
          <div
            class="profile-pic"
          >
            <v-img
              width="32"
              height="32"
              :src="pOffer.preview_image"
            />
          </div>
          {{ pOffer.title }}

          <v-spacer />
          <v-dialog
            v-model="showOfferDialog"
            max-width="1500px"
          >
            <template #activator="{on}">     
              <v-btn
                text
                v-on="on"
              >
                Expand
              </v-btn>                           
            </template>
            <ShowOffer
              :pCategories="pCategories"
              :pOffer="pOffer"
              @closeShowDialog="showOfferDialog = false"
            />
          </v-dialog>
        </v-card-title>
      </v-card>
    </div>
    
    <div
      v-if="!pIsTiled"
    >
      <v-card style="border-radius: 5px 5px 0 5px;">
        <v-row ml-5>
          <v-card-title
            pl-5
            class="headline"
          >
            {{ pOffer.title }}
          </v-card-title>
        </v-row>
        <v-row>
          <v-col lg="4">
            <image-lightbox
              :pMaxHeight="'250px'"
              :src="pOffer.preview_image"
            />
          </v-col>

          <v-col>
            <v-card-text>{{ pOffer.body }}</v-card-text>
          </v-col>
        </v-row>
      </v-card>
      <v-row
        class="justify-end"
        mr-5
      >
        <v-dialog
          v-model="showOfferDialog"
          max-width="1500px"
        >
          <template #activator="{on}">     
            <v-btn
              x-large
              style="border-radius: 0 0 5px 5px;margin-right: 11px"
              color="primary"
              v-on="on"
            >
              More
            </v-btn>                           
          </template>
          <ShowOffer
            :pCategories="pCategories"
            :pOffer="pOffer"
            @closeShowDialog="showOfferDialog = false"
          />
        </v-dialog>                                      
      </v-row>
    </div>
  </div>
</template>

<script>
import ImageLightbox from '@/components/helpers/ImageLightbox.vue'
import ShowOffer from '@/components/ShowOffer.vue'

export default {
  components: {
    ImageLightbox,
    ShowOffer
  },
  props: {
    pCategories: { type: Array, default: null },
    pOffer: {type: Object, default: null},
    pIsTiled: {type: Boolean, default: false},
  },
  data () {
    return {
      showOfferDialog: false
    }
  }
}
</script>

<style scoped>
  .profile-pic {
    margin-right: 30px;
  }
</style>