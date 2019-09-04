<template>
  <div class>
    <!-- /.row -->
    <div class="row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h1 class="card-title mt-2">Inventory Custodian Slip</h1>
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
    <div v-if="!$gate.isAdminOrAuthor()">
      <NotFound></NotFound>
    </div>
  </div>
</template>

<script>
// import validate from 'validate.js'
export default {
  name: "ics-list",
  data() {
    return {
      invetorys: {}
    };
  },
  created() {
    if (this.$gate.isAdminOrUserOrAuthor()) {
      axios.get("api/inventory").then(({ data }) => (this.invetorys = data)); //Remove the previous (this.users =data.data) into data only
    }
  }
};
</script>

<style>
</style>


// Command for this (npm run watch && php artisan serve)
