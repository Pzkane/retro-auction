<template>
    <v-form ref="ofForm">
        <v-card style="overflow: hidden;" max-width="100%">
            <v-card-title>
                Add Offer
                <v-spacer></v-spacer>
                <v-btn icon v-on:click="closeDialog()">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text>
                <v-text-field
                    :rules="[rules.required]"
                    :counter="32"
                    v-model="title"
                    placeholder="Your Title ..."
                    label="Title"
                ></v-text-field>
                <v-textarea
                    :rules="[rules.required]"
                    :counter="600"
                    v-model="body"
                    placeholder="Your Description ..."
                    label="Description"
                ></v-textarea>
            </v-card-text>
            <v-card-actions class="pb-0">
                <v-container class="pa-0">
                    <v-row class="pl-3 pr-5">
                        <v-file-input
                            :rules="[scoped_rules.filesRequired]"
                            multiple
                            width="50%"
                            v-model="files"
                        ></v-file-input>
                        <v-container>
                            <v-row class="align-center justify-center">
                                <v-card
                                    width="100%"
                                    v-if="files"
                                    class="block"
                                    color="blue-grey lighten-5"
                                >
                                    <v-img class="d-inline-block ma-5" v-for="image in files" :key="image"
                                            max-width="200px"
                                            max-height="200px"
                                            v-bind:src="makeUrl(image)"
                                    ></v-img>
                                    <!-- <v-card
                                        :elevation="hover ? 12 : 2"
                                        :class="{ 'on-hover': hover }"
                                    >
                                        <v-img class="d-inline-block ma-5" v-for="image in files" :key="image"
                                            max-width="200px"
                                            max-height="200px"
                                            v-bind:src="makeUrl(image)"
                                        ></v-img>
                                    </v-card> -->
                                </v-card>
                            </v-row>
                        </v-container>
                    </v-row>
                    
                    <v-row class="pa-0">
                        <!-- escape buttons -->
                        <v-btn 
                            style="border-radius: 0 0 0 5px;"
                            text color="primary" d-inline-block width="50%" height="50px"
                            @click="submit()"
                        >Submit</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn 
                            style="border-radius: 0 0 5px 0;"
                            text d-inline-block width="50%" height="50px"
                            v-on:click="closeDialog()"
                        >Cancel</v-btn>
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
    data() {
        return {
            title: null,
            body: null,
            files: [],
            path: null, // debug var

            rules: external_rules,
            scoped_rules: {
                filesRequired: v => (!!v && this.files.length >=1) || 'You must attach a least 1 image',
            }
        }
    },
    methods: {
        checkFiles() {
            console.log(this.files)
        },
        makeUrl(file) {
            return URL.createObjectURL(file)
        },
        submit() {
            if (this.$refs.ofForm.validate()) {
                let offerData = new FormData()
                console.log(this.$auth.user().id)
                offerData.append('user_id', this.$auth.user().id)
                offerData.append('title', this.title)
                offerData.append('body', this.body)
                // offerData
                for (let i = 0; i < this.files.length; i++) {
                    offerData.append('images[]', this.files[i], this.files[i].name)                    
                }
                // this.files.forEach(function (image, index) {
                //     offerData.append('image['+index+']', image[index], image[index].name)
                // })

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
                    .post('http://127.0.0.1:8000/api/addOffer', offerData, config)
                    .then ((response) => {
                        console.log(response)
                        alert('success post')
                    })
                    .catch ((err) => {
                        console.log(err)
                    })
            }
        },
        closeDialog() {
            this.title = null
            this.body = null
            this.files = []
            this.path = null
            this.formattedFiles = []
            this.$emit('closeAddOfferDialog')
        }
        // check() {
        //     this.path = URL.createObjectURL(this.file)
        //     console.log(this.path)
        // }
    },
}
</script>