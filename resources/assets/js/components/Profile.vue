<template>
  <div class>
    <div class="row">
      <div class="col-md-12 mt-4">
        <!-- Widget: user widget style 1 widget-user -->
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <!--style="background-image:url('/img/wallpaper.jpg')" -->

          <div id="profile-background" class="widget-user-header text-white">
            <div class="widget-user-image">
              <img
                id="img-circle"
                class="rounded-circle"
                :src="getProfilePhoto()"
                alt="User Avatar"
              />
            </div>
            <div class>
              <h3 class="username">{{this.form.name}}</h3>
              <h5 class="desc">
                <span class="badge badge-secondary">{{this.form.type}}</span>
              </h5>
            </div>
          </div>
        </div>
      </div>
      <!-- /.widget-user -->

      <!-- </div> -->
      <!-- </div> -->
      <!-- Start for Input Settings -->
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <!-- <li class="nav-item">
                <a class="nav-link active" href="#activity" data-toggle="tab">Activity</a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" href="#settings" data-toggle="tab">Settings</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- /.tab-pane -->

              <!-- TimeLine Inverse -----------------------------------------------------------------------Timeline Inverse -->

              <div id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-12">
                      <input
                        readonly
                        type="text"
                        v-model="form.name"
                        class="form-control"
                        id="name"
                        placeholder="Name"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-12">
                      <input
                        type="email"
                        v-model="form.email"
                        class="form-control"
                        id="email"
                        placeholder="Email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-12">
                      <textarea
                        class="form-control"
                        v-model="form.bio"
                        id="experience"
                        placeholder="Experience"
                        :class="{ 'is-invalid': form.errors.has('bio') }"
                      ></textarea>
                      <has-error :form="form" field="bio"></has-error>
                    </div>
                  </div>-->
                  <!-- Choose File Starts here -->
                  <div class="form-group">
                    <label for="inputExperience" class="col-sm-2 control-label">Upload Photo</label>

                    <div class="col-sm-12">
                      <!-- Class name maybe -form-input -->
                      <input
                        type="file"
                        class="form-control-file"
                        @change="updateProfile"
                        name="avatar"
                        id="photo"
                        aria-describedby="fileHelp"
                        :class="{ 'is-invalid': form.errors.has('photo') }"
                      />
                      <has-error :form="form" field="photo"></has-error>
                      <small
                        id="fileHelp"
                        class="form-text text-muted"
                      >Please upload a valid image file. Size of image should not be more than 2MB.</small>
                    </div>
                  </div>
                  <!-- Choose File Ends Here -->
                  <!-- <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Skills</label>

                    <div class="col-sm-12">
                      <input
                        type="text"
                        v-model="form.bio"
                        class="form-control"
                        id="skills"
                        placeholder="Skills"
                        :class="{ 'is-invalid': form.errors.has('bio') }"
                      />
                      <has-error :form="form" field="bio"></has-error>
                    </div>
                  </div>-->
                  <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-12">
                      <input
                        type="password"
                        v-model="form.password"
                        class="form-control"
                        id="password"
                        placeholder="Password"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                      />
                      <has-error :form="form" field="password"></has-error>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                  </div>-->
                  <div class="form-group">
                    <div class="col-sm-offset col-sm-10">
                      <button
                        @click.prevent="updateInfo"
                        type="submit"
                        class="update-create btn col-lg-2 col-sm-6"
                      >
                        <i class="fas fa-save"></i>&nbsp;Save
                      </button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- End for the Input Settings -->
    <!-- </div> -->
  </div>
</template>

<script>
export default {
  // return data from the request to show profile
  data() {
    return {
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: ""
      })
    };
  },
  methods: {
    // retrieve profile photo on the database
    getProfilePhoto() {
      // return "img/profile/" + this.form.photo;
      // remove the img directory on the devtools
      let photo =
        this.form.photo.length > 200
          ? this.form.photo
          : "img/profile/" + this.form.photo;

      return photo;
    },
    // methods to axios and request to api for validation
    updateInfo() {
      this.$Progress.start();
      this.form
        .put("api/profile")
        .then(() => {
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          toast.fire({
            type: "success",
            title: "Updated successfully"
          });
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    // Function to insert and image using base64
    updateProfile(e) {
      let file = e.target.files[0];
      console.log(file);
      let reader = new FileReader();

      if (file["size"] < 2111775) {
        // let vm = this;
        reader.onloadend = file => {
          this.form.photo = reader.result;
          // console.log('RESULT', reader.result);
        };
        reader.readAsDataURL(file);
      } else {
        swal.fire("Opps", "Your file was too large", "error");
      }
    }
  },
  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
  }
};
</script>

<style scoped>
.update-create {
  background: rgb(22, 70, 143);
  color: white;
  opacity: 0.9;
}
.update-create:hover {
  opacity: 1;
}
.widget-user .card-footer {
  padding: 0;
}
.username {
  padding-top: 150px;
}
.username,
.desc {
  text-align: center;
  color: aliceblue;
}
#profile-background {
  height: 300px !important;
  background: linear-gradient(185deg, #16468f 60%, #ce1126 60%);
}
img {
  vertical-align: middle;
}
</style>


