<template>
  <v-card
    outlined
  >
    <v-card-title>
      {{ pTopic.title }}
      <v-spacer></v-spacer>
      <v-btn
        icon
        @click="fetchComments()"
      >
        <v-icon>mdi-autorenew</v-icon>
      </v-btn>
      <v-btn
        icon
        @click="closeTopic()"
      >
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-card-title>
    <v-card-subtitle>
      Added by: {{ pTopic.author_data.username }}
      <v-spacer></v-spacer>
      Added on: {{ pTopic.created_at }}
    </v-card-subtitle>
    <v-card-text
      class="font-weight-regular"
    >
      {{ pTopic.body }}
    </v-card-text>

    <v-card-text>
      <v-container
        v-if="$auth.user().id"
      >
        <v-form
          ref="comForm"
        >
          <v-textarea
            v-model="body"
            :rules="[rules.required]"
            :counter="600"
            rows="4"
            placeholder="Comment ..."
            label="Comment"
            outlined
          />
          <v-btn
            text
            @click="submitComment()"
          >
            Submit
          </v-btn>
        </v-form>

      </v-container>
      <v-container
        style="max-height: 700px; overflow: auto;"
        v-if="comments.length"
      >
        <v-card
          outlined
        >
          <v-card-text>
            <v-container>
              <v-row
                v-for="comment in comments"
                :key="comment.id"
              >
                <v-row>
                  <v-col
                    cols="3"
                  >
                    <v-row
                      class="profile-col"
                    >
                      <v-img
                        class="profile-pic"
                        width="32"
                        height="32"
                        :src="comment.author_data.avatar_path"
                      ></v-img>
                    </v-row>
                    <v-row
                      class="profile-col"
                    >
                      {{ comment.author_data.username }}
                    </v-row>
                  </v-col>

                  <v-col>
                    {{ comment.body }}
                  </v-col>
                </v-row>
                
                <v-row>
                  Added on: {{ comment.created_at }}
                </v-row>
              </v-row>
            </v-container>
          </v-card-text>
        </v-card>
      </v-container>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from 'axios'
import external_rules from '../plugins/rules/rules'

export default {
  props: {
    pTopic: {type: Object, default: null}
  },
  data () {
    return {
      comments: [],
      rules: external_rules,
      body: null
    }
  },
  created () {
    this.fetchComments()
  },
  methods: {
    closeTopic () {
      this.$emit('closeDialog')
    },
    fetchComments () {
      this.comments = []
      const path = `http://127.0.0.1:8000/api/forum/comments?topic=${this.pTopic.id}`
      axios
        .get(path)
        .then(res => {
          const {data:{data}} = res
          if (data){
            this.comments = data
          }
        })
        .catch(err => {
          console.log(err)
        })
    },
    submitComment () {
      if (this.$refs.comForm.validate()) {
        const commentData = new FormData()
        commentData.append('user_id', this.$auth.user().id)
        commentData.append('body', this.body)
        commentData.append('topic_id', this.pTopic.id)

        const config = { 
          headers: { 
            'Authorization': 'Bearer '+this.$auth.token(),
            'Content-Type': 'multipart/form-data' 
          }
        }
        axios
          .post('http://127.0.0.1:8000/api/auth/forum/comment/add', commentData, config)
          .then (res => {
            this.$refs.comForm.reset()
            this.fetchComments()
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
  .profile-col {
    place-content: center;
  }
  .profile-pic {
    border-radius: 50%;
    max-width: 32px;
  }
</style>