<template>
  <div>
    <v-dialog v-model="lightboxDialog">
      <template #activator="{ on }">
        <v-img
          v-on="on"
          :src="src"
        />
      </template>

      <v-container>
        <v-img
          :src="src"
        />
      </v-container>
    </v-dialog>
  </div>
</template>

<script>
export default {
  name: 'ImageLightbox',
  props: {
    src: {type: String, default: null}
  },
  data () {
    return {
      lightboxDialog: false
    }
  }
}
</script>

<style>

</style>