<style>
    .widget-user-header{
        background-position: center center;
        background-size: cover;
    }
</style>
<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">

                <div class="card card-widget widget-user">
                  <div class="widget-user-header text-white" style="background-image:url('./img/user-cover.jpg'); height: 250px;">
                    <h3 class="widget-user-username">{{ this.form.name }}</h3>
                    <h5 class="widget-user-desc">{{ this.form.type }}</h5>
                  </div>
                  <div class="widget-user-image">
                    <img class="img-circle" :src="getProfilePhoto()" alt="User Photo">
                  </div>
                  <div class="card-footer">
                    <div class="row">
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header">3,200</h5>
                          <span class="description-text">SALES</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4 border-right">
                        <div class="description-block">
                          <h5 class="description-header">13,000</h5>
                          <span class="description-text">FOLLOWERS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-4">
                        <div class="description-block">
                          <h5 class="description-header">35</h5>
                          <span class="description-text">PRODUCTS</span>
                        </div>
                        <!-- /.description-block -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                </div>

            </div>


            <div class="col-md-12">
                <div class="card">
                  <div class="card-header p-2">
                    <ul class="nav nav-pills">
                      <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                      <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                  </div><!-- /.card-header -->
                  <div class="card-body">
                    <div class="tab-content">

                      <div class="tab-pane" id="activity">
                        <h1>Display User Activity</h1>
                      </div>

                      <div class="tab-pane active show" id="settings">
                        <form class="form-horizontal">
                          <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                              <input type="text" v-model="form.name" class="form-control" id="name" placeholder="Name" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                              <input type="email" v-model="form.email" class="form-control" id="email" placeholder="Email Address" :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="experience" class="col-sm-2 control-label">Experience</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" v-model="form.bio" id="experience" placeholder="Experience"></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                            <div class="col-sm-10">
                              <input type="file" @change="updateProfile" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="password" class="col-sm-12 col-md-12 control-label">Password (leave empty if not changing)</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" v-model="form.password" id="password" placeholder="Password" :class="{ 'is-invalid': form.errors.has('password') }">
                              <has-error :form="form" field="password"></has-error>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-12">
                              <button type="submit" @click.prevent="updateInfo" class="btn btn-success">Update</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>


        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form : new Form({
                    id: '',
                    name : '',
                    email : '',
                    password : '',
                    type : '',
                    bio : '',
                    photo : ''
                })
            }
        },

        mounted() {
            console.log('Profile Component mounted.')
        },

        methods: {
            getProfilePhoto(){
                let photo = (this.form.photo.length > 200) ? this.form.photo : 'img/profile/'+this.form.photo;
                return photo;
            },

            updateInfo(){
                this.$Progress.start();
                if(this.form.password == ''){
                    this.form.password = undefined;
                }
                this.form.put('/api/profile')
                .then(()=>{
                    Fire.$emit('response');
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                })
            },

            updateProfile(e){
                let file = e.target.files[0];
                let reader = new FileReader();
                let limit = 1024 * 1024 * 2;
                if(file['size'] > limit){
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    })
                    return false;
                }
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            }
        },

        created() {
            axios.get('/api/profile')
            .then(({ data }) => (this.form.fill(data)));
        }
    }
</script>
