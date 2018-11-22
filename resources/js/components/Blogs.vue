<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blogs Table</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Created</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="blog in blogs.data" :key="blog.id">
                            <td>{{blog.id}}</td>
                            <td>{{blog.title}}</td>
                            <td>{{blog.body}}</td>
                            <td>{{blog.created_at | myDate}}</td>
                            <td>
                                <a href="#" @click="editModal(blog)"><i class="fa fa-edit blue"></i></a>
                                <a href="#" @click="deleteBlog(blog.id)"><i class="fa fa-trash red"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="blogs" @pagination-change-page="getResults">
                  
                </pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!--Modal-->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" v-show="!editmode" id="exampleModalLabel">Add New</h5>
                <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Update Blog</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <form @submit.prevent="editmode ? updateBlog() : createBlog()">

              <div class="modal-body">
                
                <div class="form-group">
                  <input v-model="form.title" type="text" name="title" placeholder="Title" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                  <has-error :form="form" field="title"></has-error>
                </div>

                <div class="form-group">
                  <textarea v-model="form.body" type="text" name="body" placeholder="Short Description For Blog" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('body') }"></textarea>
                  <has-error :form="form" field="body"></has-error>
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
              </div>

              </form>

            </div>
          </div>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode : false,
                blogs : {},
                form: new Form({
                    id: '',
                    title: '',
                    body: ''
                })
            }
        },

        methods : {
          getResults(page = 1) {
            axios.get('api/blogs?page=' + page)
              .then(response => {
                this.blogs = response.data;
              });
          },

          updateBlog(){
            this.$Progress.start();
            this.form.put('api/blogs/'+this.form.id)
            .then(()=>{
              $('#addNew').modal('hide');
              swal(
                'Success!',
                'Information Has Been Updated Successfully!',
                'success'
              )
              this.$Progress.finish();
              Fire.$emit('response');
            })
            .catch(()=>{
              this.$Progress.fail();
            })
          },

          editModal(blog){
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(blog);
          },

          newModal(){
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
          },

          deleteBlog(id){
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              })
            .then((result) => {
                if (result.value) {

                  this.form.delete('api/blogs/'+id)
                  .then(()=>{
                      swal(
                        'Deleted!',
                        'Blog Has Been Deleted Successfully!',
                        'success'
                      )
                      Fire.$emit('response');
                  })
                  .catch(()=>{
                    swal('Failed', 'Something Went Wrong', 'warning');
                  })

                }
            })
          },

          loadBlogs(){
            axios.get('api/blogs').then(({data}) => (this.blogs = data));
          },

          createBlog(){
            this.$Progress.start();
            this.form.post('api/blogs')

            .then(() => {
              Fire.$emit('response');
              $('#addNew').modal('hide');

              toast({
                type: 'success',
                title: 'Blog Created Successfully!'
              })

              this.$Progress.finish();
            })
            .catch(() => {
              this.$Progress.fail();
            })
            
          }
        },

        created() {
          this.loadBlogs();
          Fire.$on('response',() => {
            this.loadBlogs();
          })
        }
    }
</script>
