import { VImg } from 'vuetify/lib'

export default {
    name: 'v-img-nologger',
    extends: VImg,
    methods: {
        onError () {
            this.$emit('error')
        }
    }
};