<template>
  <div class>
    <div class="row justify-content-center">
      <div class="col-md-12 mt-5">
        <!-- <h3>Not Found</h3> -->
        <section class="page_404">
          <div class="container">
            <div class="row">
              <div class="col-sm-12">
                <div class="col-sm-12 col-sm-offset-1 text-center">
                  <div class="four_zero_four_bg">
                    <h1 class="text-center">404</h1>
                  </div>

                  <div class="contant_box_404">
                    <h3 class="h2">Look like you're lost</h3>

                    <p>the page you are looking for not avaible!</p>
                    <router-link to="/dashboard" class="nav-link">
                      <button type="button" class="btn btn-secondary">Go Back</button>
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
/*======================
    404 page
=======================*/

.page_404 {
  padding: 40px 0;
  background: #fff;
  font-family: "Arvo", serif;
}

.page_404 img {
  width: 100%;
}

.four_zero_four_bg {
  background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
  height: 400px;
  background-position: center;
}

.four_zero_four_bg h1 {
  font-size: 80px;
}

.four_zero_four_bg h3 {
  font-size: 80px;
}

.link_404 {
  color: #fff !important;
  padding: 10px 20px;
  background: #39ac31;
  margin: 20px 0;
  display: inline-block;
}
.contant_box_404 {
  margin-top: -50px;
}
</style>

