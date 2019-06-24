<template>
  <div id="el">
    <input v-model="form.sale_quantity">
    <input v-model="form.sale_rate">
    <input :value="form.sale_quantity*form.sale_rate">
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        sale_quantity: 0,
        sale_rate: 0,
        sale_total: 0
      }
    };
  }
};
</script>
