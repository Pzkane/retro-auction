<template>
  <div>
    <p>
      Server is not responding at the moment. <br>
      Try again later. <br>
      Error code: {{ errorCode }}
    </p>
  </div>
</template>

<script>
export default {
  props: {
    errorCode: {type: Number, default: null}
  }
}
</script>

<style>
    
</style>