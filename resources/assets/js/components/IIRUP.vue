<template>
  <div class>
    <!-- /.row -->
    <div class="row mt-4" v-if="$gate.isAdminOrAuthor()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h1
              class="card-title mt-2"
            >Inventory and Inspection Report of Unserviceable Property (IIRUP)</h1>
          </div>
          <!-- /.card-body -->
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
export default {
  data() {
    return {
      disposals: {}
    };
  },

  created() {
    if (this.$gate.isAdminOrUserOrAuthor()) {
      axios.get("api/disposal").then(({ data }) => (this.disposals = data)); //Remove the previous (this.users =data.data) into data only
    }
  }
};
</script>


// Command for this (npm run watch && php artisan serve)
