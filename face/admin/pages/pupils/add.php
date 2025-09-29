<link rel="stylesheet" href="css/bootsrap.css">
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Добавление ученика(цы)</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="?page=2"  method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Имя</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Фамилия</label>
                    <input type="text" name="surname" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Очество</label>
                    <input type="text" name="patronymic" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">День рождения</label>
                    <input type="date" name="birthday" class="form-control" id="exampleInputPassword1" placeholder="">
                  </div>
                  <label for="">Пол</label>
                  <select name="gender" id="" class="form-control">
                    <option value="male">Мужской</option>
                    <option value="female">Женский</option>
                  </select>
                  <label for="">Класс</label>
                  <select name="grade" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                  </select>
                  <label for="">Группа</label>
                  <select name="class" id="" class="form-control">
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                  </select>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit"  name="save" class="btn btn-primary">Отправить</button>
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