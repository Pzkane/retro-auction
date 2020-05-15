<template>
  <v-form>
    <v-card>
      <v-card-title>
        {{ pOffer.title }}
        <v-spacer />
        <v-btn
          icon
          @click="closeDialog()"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-card
          style="margin-bottom: 10px"
          outlined
        >
          <v-card-title
            class="font-weight-light"
          >
            Description
          </v-card-title>
          <v-card-text>
            {{ pOffer.body }}
          </v-card-text>
        </v-card>
        <v-card
          outlined
          v-if="parts.length"
        >
          <v-card-title
            class="font-weight-light"
          >
            Parts
          </v-card-title>
          <v-card-text>
            <v-data-table
              :headers="headers"
              :items="partsItems"
              :items-per-page="5"
              item-key="label"
              group-by="category"
              show-group-by
              dense
            />
          </v-card-text>
        </v-card>
        <v-container>
          <v-card>
            <image-lightbox
              v-for="image in images"
              :key="image"
              :src="image"
              class="image d-inline-block ma-5"
            />
          </v-card>
        </v-container>

        <v-container
          class="contacts"
        >
          <h3>
            Contacts
          </h3>
          <v-row>
            <v-col>
              <h3 class="subtitle-1">
                Phone: <span class="constacts-data">{{ pOffer.contact_phone }}</span>
              </h3>
            </v-col>
            <v-col>
              <h3 class="subtitle-1">
                Email: <span class="constacts-data">{{ pOffer.contact_email }}</span>
              </h3>
            </v-col>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-form>
</template>

<script>
import axios from 'axios'

export default {
  components: {
    ImageLightbox: () => import('./helpers/ImageLightbox')
  },
  props: {
    pCategories: {type: Array, default: null},
    pOffer: {type: Object, default: null}
    // isOpened: false
  },
  data() {
    return {
      images: [],
      parts: [],

      // table data
      headers: [
        {
          text: 'Label',
          align: 'start',
          value: 'label'
        },
        {
          text: 'Category',
          value: 'category'
        }
      ],
      partsItems: []
    }
  },
  created() {
    this.getImages()
    this.getParts()
  },
  methods: {
    closeDialog () {
      this.$emit('closeShowDialog')
    },
    getCategoryName (categoryId) {
      const category = this.pCategories.find(category => { return category.id === categoryId })
      return category.label
    },
    getImages () {
      const req = 'http://127.0.0.1:8000/api/offer_media/'+this.pOffer.id
      axios
        .get (req)
        .then ((result) => {
          result.data.photo_path.forEach(element => {
            this.images.push(element)
          });
        })
        .catch((err) => {
          console.log(err)
        })
    },
    async getParts () {
      const req = 'http://127.0.0.1:8000/api/offer/'+this.pOffer.id
      axios
        .get (req)
        .then ((result) => {
          const {data:{data}} = result
          this.parts = data.parts
          this.getTableContents()
        })
        .catch((err) => {
          console.log(err)
        })
    },
    getTableContents () {
      for (const part of this.parts) {
        this.partsItems.push({
          'label': part.part,
          'category': this.getCategoryName(part.category)
        })
      }
    }
  },
}
</script>

<style scoped>
  .contacts {
    border: 1px solid lightgrey;
    border-radius: 5px;
  }
  .constacts-data {
    font-weight: bold;
  }
  .image {
    max-width: 200px;
    max-height: 200px;
  }
</style>