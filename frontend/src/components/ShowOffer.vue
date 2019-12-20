<template>
    <v-form>
        <v-card>
            <v-card-title>
                {{ offer.title }}
            </v-card-title>
            <v-card-text>
                {{ offer.body }}
            </v-card-text>
            <v-card-text>
                <v-container>
                    <v-card>
                        <v-img 
                            v-for="image in images" :key="image"
                            :src="image"
                            max-width="200px"
                            max-height="200px"
                            class="d-inline-block ma-5"
                        ></v-img>
                    </v-card>
                </v-container>
            </v-card-text>
        </v-card>
    </v-form>
</template>

<script>
import axios from 'axios'

export default {
    props: {
        offer: {type: Object, default: null}
        // isOpened: false
    },
    data() {
        return {
            images: []
        }
    },
    created() {
        this.getImages()
    },
    methods: {
        getImages() {
            let req = 'http://127.0.0.1:8000/api/offer-media/'+this.offer.id
            axios
                .get (req)
                .then ((result) => {
                    result.data.file_path.forEach(element => {
                        this.images.push(element)
                    });
                })
                .catch((err) => {
                    console.log(err)
                })
        }
    },
}
</script>