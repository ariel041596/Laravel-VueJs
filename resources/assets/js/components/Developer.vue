<template>
  <div>
    <div class="row justify-content-center" v-if="$gate.isAdminOrAuthor()">
      <passport-clients></passport-clients>
      <passport-authorized-clients></passport-authorized-clients>
      <passport-personal-access-tokens></passport-personal-access-tokens>
      <div v-if="!$gate.isAdminOrAuthor()">
        <NotFound></NotFound>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
<style>
</style>

