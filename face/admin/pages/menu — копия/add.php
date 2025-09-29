<link rel="stylesheet" href="css/bootsrap.css">
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Блюдо</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="?page=14"  method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Img</label>
                    <input type="file" name="img" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Text</label>
                    <input type="text" name="text" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="number"  class="form-control" id="exampleInputPassword1" name="price">
                  </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit"  name="save" class="btn btn-primary">Submit</button>
                </div>
                
              </form>
              
            </div>
            <!-- /.card -->
 
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
 </div>