<link rel="stylesheet" href="css/bootsrap.css">
<div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Добавление учителя(ницы)</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="?page=10"  method="post" enctype="multipart/form-data">
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
                    <label for="exampleInputPassword1">Возраст</label>
                    <input type="number" name="age" class="form-control" id="exampleInputPassword1" placeholder="">
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
                  <label for="">Предмет</label>
                  <select name="subject" id="" class="form-control">
                    <option value="Русский язык">Русский язык</option>
                    <option value="Английский язык">Английский язык</option>
                    <option value="Биология">Биология</option>
                    <option value="География">География</option>
                    <option value="Алгебра">Алгебра</option>
                    <option value="Геометрия">Геометрия</option>
                    <option value="История">История</option>
                    <option value="Обществознание">Обществознание</option>
                    <option value="Информатика">Информатика</option>
                    <option value="Физика">Физика</option>
                    <option value="Химия">Химия</option>
                    <option value="Физкультура">Физкультура</option>
                    <option value="Забони давлатӣ">Забони давлатӣ</option>
                  </select>
                  <label for="">Категория специальности</label>
                  <select name="category_of_specialty" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="highest">Высшая</option>
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