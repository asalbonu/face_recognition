<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">РИТМ : Распознавание и <br>Интеллектуальный<br> Технологический<br> Мониторинг</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
        <div class="info">
          <a href="#" class="d-block"><?=$_SESSION['surname']." ".$_SESSION['username'];?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Поиск" aria-label="Поиск">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    
               <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
              Ученики(цы)
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=1" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Добавить</p>
                </a>
              </li>
             
            </ul><ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=3" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
              Журналы
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=7" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Журналы посешаемости</p>
                </a>
              </li>
             
            </ul><ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=8" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Журналы оценок</p>
                </a>
              </li>
             
            </ul>
          </li> 
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
              Учителя
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=9" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Добавить</p>
                </a>
              </li>
             
            </ul><ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=11" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Список</p>
                </a>
              </li>
             
            </ul>
          </li> 
               <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
              Расписание
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="?page=15" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Добавить</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?page=16" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Изменить</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="?page=17" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Вывод</p>
                </a>
              </li>
            </ul>
          </li> 
            </ul>
          
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>