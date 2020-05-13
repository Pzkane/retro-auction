import { components } from '../vuetifyDismantle'
const VImg = components.VImg

export default {
    name: 'v-img-nologger',
    extends: Vue,
    methods: {
        onError () {
            this.$emit('error')
        }
    }
};