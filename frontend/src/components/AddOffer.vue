<template>
  <div>
    <v-form 
      ref="ofForm"
      v-if="!response.status"
    >
      <v-card
        style="overflow: hidden;"
        max-width="100%"
      >
        <v-card-title>
          <h1
            class="headline font-weight-regular"
          >
            Add Offer
          </h1> 
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
            outlined
          />
          <v-row>
            <v-col>
              <v-textarea
                v-model="body"
                :rules="[rules.required]"
                :counter="600"
                rows="9"
                placeholder="Offer Description ..."
                label="Description"
                outlined
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
                    v-for="part in partObjects"
                    :key="part.id"
                  >
                    <v-col>
                      <v-text-field
                        v-model="part.label"
                        :rules="[rules.required]"
                        :counter="32"
                        placeholder="Part Label ..."
                        label="Label"
                        outlined
                      />
                    </v-col>
                    <v-col
                      v-if="categories.length"
                    >
                      <v-select
                        v-model="part.category"
                        required
                        label="Category"
                        solo
                        :items="categories"
                        item-text="label"
                        item-value="id"
                      />
                    </v-col>
                    <v-btn
                      v-if="part.id !== 0"
                      icon
                      @click="removeNewPart(part.id)"
                    >
                      <v-icon>mdi-close</v-icon>
                    </v-btn>
                  </v-row>
                  <v-row
                    v-if="!areCategoriesFilled"
                  >
                    <div
                      class="caption-category"
                    >
                      Provide a category for each part.
                    </div>
                  </v-row>
                  <v-btn 
                    class="mx-2"
                    fab
                    dark
                    color="#616161"
                    @click="addNewPart()"
                  >
                    <v-icon dark>
                      mdi-plus
                    </v-icon>
                  </v-btn>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-text-field
                v-model="contactPhone"
                :rules="[scoped_rules.contactPhone]"
                :counter="12"
                label="Contact Phone"
                outlined
              />
            </v-col>
            <v-col>
              <v-text-field
                :value="contactEmail"
                disabled
                label="Contact Email"
                outlined
              />
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
                          v-for="(image, index) in files"
                          :key="index"
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

            <div>
              <v-row 
                class="caption caption-alert-wrapper"
              >
                <div
                  class="caption-alert-container"
                >
                  <v-icon
                    small
                  >
                    mdi-alert-outline
                  </v-icon>
                  Check the information validity before submitting.
                </div>
              </v-row>
            </div>
            
            <v-divider />

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
    <v-card
      v-if="response.status"
    >
      <v-card-title>
        {{ response.status }}
      </v-card-title>
      <v-card-text>
        {{ response.message }}
      </v-card-text>
      <v-btn
        class="dismiss-btn"
        depressed
        block
        @click="closeDialog(true)"
      >
        Ok
      </v-btn>
    </v-card>
  </div>
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
      contactEmail: null,
      contactPhone: null,

      rules: external_rules,
      scoped_rules: {
        contactPhone: v => (!!v && v.length > 6 && v.length < 40 && /^[0-9]+$/.test(v)) || 'Provide a valid phone number without any symbols',
        filesRequired: v => (!!v && this.files.length >=1) || 'You need to attach at least 1 image'
      },

      partObjects: [
        {
          id: 0,
          label: null,
          category: null
        }
      ],
      categories: [],
      areCategoriesFilled: false,

      response: {
        status: null,
        message: null
      }
    }
  },
  watch: {
    partObjects: {
      deep: true,
      handler: function () {
        this.areCategoriesFilled = true
        this.partObjects.map(part => {
          if (!part.category) {
            this.areCategoriesFilled = false
          }
        })
      }
    }
  },
  created () {
    this.contactEmail = this.$auth.user().email
  },
  mounted () {
    if (this.pCategories) {
      this.categories = this.pCategories
    }
  },
  beforeDestroy () {
    this.closeDialog()
  },
  methods: {
    addNewPart () {
      this.partObjects.push({
        id: this.partObjects.length,
        label: null,
        category: null
      })
    },
    closeDialog (afterSubmit = false) {
      this.title = null
      this.body = null
      this.contactPhone = null
      this.files = []
      this.path = null
      this.formattedFiles = []
      this.areCategoriesFilled = false
      this.partObjects = [
        {
          id: 0,
          label: null,
          category: null
        }
      ]
      this.response = {
        status: null,
        message: null
      }
      if (!afterSubmit) {
        this.$refs.ofForm.reset()
      }
      
      this.$emit('closeAddOfferDialog')
    },
    makeUrl (file) {
      return URL.createObjectURL(file)
    },
    removeNewPart (partId) {
      let filtered = this.partObjects.filter(part => (part.id !== partId))
      if (filtered.length) {
        let prevPartId = 0
        filtered.map(part => {
          if (part.id > 0) {
            if (part.id !== prevPartId + 1) {
              part.id = prevPartId + 1
            }
            prevPartId = part.id
          }
        })
      }
      this.partObjects = filtered.length ? filtered : [filtered]
    },
    submit () {
      if (this.$refs.ofForm.validate() && this.areCategoriesFilled) {
        const offerData = new FormData()
        offerData.append('user_id', this.$auth.user().id)
        offerData.append('title', this.title)
        offerData.append('body', this.body)
        offerData.append('contact_phone', this.contactPhone)
        offerData.append('contact_email', this.contactEmail)
        offerData.append('preview_image_id', 0)
        offerData.append('parts', JSON.stringify(this.partObjects))
        // offerData
        for (let i = 0; i < this.files.length; i++) {
          offerData.append('images[]', this.files[i], this.files[i].name)                    
        }

        const config = { 
          headers: { 
            'Authorization': 'Bearer '+this.$auth.token(),
            'Content-Type': 'multipart/form-data' 
          }
        }
        axios
          .post('http://127.0.0.1:8000/api/auth/offer/add', offerData, config)
          .then (res => {
            switch (res.status) {
              case 200:
                this.response.status = 'Success'
                this.response.message = 'Offer has been successfully submitted!'
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
  .caption-alert-container {
    border-radius: 10px;
    background-color: sandybrown;
    text-align: center;
  }
  .caption-alert-wrapper {
    display: inline;
  }
  .caption-category {
    margin: 0 auto;
    border-radius: 5px;
    border: 1px solid lightgrey;
    width: 100%;
    padding: 5px;
    margin-bottom: 15px;
    text-align: center;
    background-color: rgb(241, 241, 241);
  }
  .dismiss-btn {
    margin: 0 auto;
  }
  .file-input-card {
    width: 100%;
  }
</style>