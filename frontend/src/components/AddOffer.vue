<template>
  <v-form ref="ofForm">
    <v-card
      style="overflow: hidden;"
      max-width="100%"
    >
      <v-card-title>
        <h1
          class="headline font-weight-regular"
        >Add Offer</h1> 
        <v-spacer />
        <v-btn
          icon
          @click="closeDialog()"
        >
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="title"
          :rules="[rules.required]"
          :counter="32"
          placeholder="Offer Title ..."
          label="Title"
        />
        <v-row>
          <v-col>
            <v-textarea
              v-model="body"
              :rules="[rules.required]"
              :counter="600"
              placeholder="Offer Description ..."
              label="Description"
            />
          </v-col>
          <v-col>
            <v-card
              outlined
            >
              <v-card-title
                class="title font-weight-light"
              >
                Parts
              </v-card-title>
              <v-card-text>
                <v-row
                  v-for="part in partObjects" :key="part.id"
                >
                  <v-col>
                    <v-text-field
                      v-model="part.label"
                      :rules="[rules.required]"
                      :counter="32"
                      placeholder="Part Label ..."
                      label="Label"
                    />
                  </v-col>
                  <v-col
                    v-if="categories.length"
                  >
                    <v-select
                      v-model="part.category"
                      :rules="[rules.requiredSelect]"
                      required
                      label="Category"
                      solo
                      :items="categories"
                      item-text="label"
                      item-value="id"
                    ></v-select>
                  </v-col>
                  <v-btn
                    v-if="part.id !== 0"
                    icon
                    @click="removeNewPart(part.id)"
                  >
                    <v-icon>mdi-close</v-icon>
                  </v-btn>
                </v-row>
                <v-btn 
                  class="mx-2" fab dark color="green"
                  @click="addNewPart()"
                >
                  <v-icon dark>mdi-plus</v-icon>
                </v-btn>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
      <v-card-actions class="pb-0">
        <v-container class="pa-0">
          <v-row class="pl-3 pr-5">
            <v-card
              class="file-input-card"
              outlined
            >
              <v-card-text>
                <v-file-input
                  v-model="files"
                  :rules="[scoped_rules.filesRequired]"
                  multiple
                  width="50%"
                />
                <v-container>
                  <v-row class="align-center justify-center">
                    <v-card
                      v-if="files"
                      width="100%"
                      class="block"
                      color="blue-grey lighten-5"
                    >
                      <v-img
                        v-for="image in files"
                        :key="image"
                        class="d-inline-block ma-5"
                        max-width="200px"
                        max-height="200px"
                        :src="makeUrl(image)"
                      />
                    </v-card>
                  </v-row>
                </v-container>
              </v-card-text>
            </v-card>
          </v-row>
          
          <v-divider></v-divider>

          <v-row class="pa-0">
            <!-- escape buttons -->
            <v-btn 
              style="border-radius: 0 0 0 5px;"
              text
              color="primary"
              d-inline-block
              width="50%"
              height="50px"
              @click="submit()"
            >
              Submit
            </v-btn>
            <v-spacer />
            <v-btn 
              style="border-radius: 0 0 5px 0;"
              text
              d-inline-block
              width="50%"
              height="50px"
              @click="closeDialog()"
            >
              Cancel
            </v-btn>
          </v-row>
        </v-container>
      </v-card-actions>
    </v-card>
  </v-form>
</template>

<script>
import external_rules from '@/plugins/rules/rules.js'
import axios from 'axios'

export default {
  props: {
    pCategories: { type: Array, default: null }
  },
  data() {
    return {
      title: null,
      body: null,
      files: [],
      path: null, // debug var

      rules: external_rules,
      scoped_rules: {
        filesRequired: v => (!!v && this.files.length >=1) || 'You need to attach at least 1 image',
        requiredSelect: v => (!!v) || 'Select category'
      },

      partObjects: [
        {
          id: 0,
          label: null,
          category: {}
        }
      ],
      categories: []
    }
  },
  mounted () {
    if (this.pCategories) {
      this.categories = this.pCategories
    }
  },
  methods: {
    addNewPart () {
      this.partObjects.push({
        id: this.partObjects.length,
        label: null,
        category: {}
      })
    },
    closeDialog () {
      this.title = null
      this.body = null
      this.files = []
      this.path = null
      this.formattedFiles = []
      this.partObjects = [
        {
          id: 0,
          label: null,
          category: null
        }
      ]
      this.$refs.ofForm.reset()
      this.$emit('closeAddOfferDialog')
    },
    makeUrl (file) {
      return URL.createObjectURL(file)
    },
    removeNewPart (partId) {
      const filtered = this.partObjects.filter(part => (part.id !== partId))
      this.partObjects = filtered
    },
    submit () {
      if (this.$refs.ofForm.validate()) {
        const offerData = new FormData()
        console.log(this.$auth.user().id)
        offerData.append('user_id', this.$auth.user().id)
        offerData.append('title', this.title)
        offerData.append('body', this.body)
        offerData.append('preview_image_id', 0)
        offerData.append('parts', JSON.stringify(this.partObjects))
        // offerData
        for (let i = 0; i < this.files.length; i++) {
          offerData.append('images[]', this.files[i], this.files[i].name)                    
        }

        // debug //
        for (var key of offerData.entries()) {
          console.log(key[0] + ', ' + key[1])
        }
        const config = { 
          headers: { 
            'Authorization': 'Bearer '+this.$auth.token(),
            'Content-Type': 'multipart/form-data' 
          }
        }
        axios
          .post('http://127.0.0.1:8000/api/auth/addOffer', offerData, config)
          .then ((response) => {
            console.log(response)
            alert('success post')
          })
          .catch ((err) => {
            console.log(err)
          })
      }
    }
  }
}
</script>

<style scoped>
  .file-input-card {
    width: 100%;
  }
</style>