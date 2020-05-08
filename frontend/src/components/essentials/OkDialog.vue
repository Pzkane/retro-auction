<template>
  <div>
    <v-container>
      <slot />
    </v-container>
  </div>
</template>

<script>
export default {
  methods: {
    dismiss () {
      this.$emit.dismissed()
    }
  }
}
</script>

<style>
  .dialog {
    position: relative;
  }
  .modal {
    position: absolute;
    background-color: rgba(red, green, blue, 1);
    width: 100%;
    height: 100%;
  }
</style>