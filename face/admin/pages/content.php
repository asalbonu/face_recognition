<?php
if (isset($_GET["page"]) && !empty(trim($_GET["page"]))) {
    require_once("config.php");
    $page = $_GET["page"];
    if ($page == "1" ) {
    require_once ('pages/pupils/add.php');
    }
    if ($page == "2" ) {
        require_once ('pages/pupils/insert.php');
        }

        if ($page == "3" ) {
            require_once ('pages/pupils/select.php');
            }
        
        if ($page == "4" ) {
            require_once ('pages/pupils/edit.php');
            }
        if ($page == "5" ) {
            require_once ('pages/pupils/update.php');
            }
        if ($page == "6" ) {
            require_once ('pages/pupils/delete.php');
            }
            if ($page == "7" ) {
            require_once ('pages/journals/journal2.php');
            }
        if ($page == "8" ) {
            require_once ('pages/journals/journal.php');
            }
            if ($page == "9" ) {
    require_once ('pages/teacher/add.php');
    }
    if ($page == "10" ) {
        require_once ('pages/teacher/insert.php');
        }

        if ($page == "11" ) {
            require_once ('pages/teacher/select.php');
            }
        
        if ($page == "12" ) {
            require_once ('pages/teacher/edit.php');
            }
        if ($page == "13" ) {
            require_once ('pages/teacher/update.php');
            }
        if ($page == "14" ) {
            require_once ('pages/teacher/delete.php');
            }
             if ($page == "15" ) {
            require_once ('add_schedule.php');
            }
             if ($page == "16" ) {
            require_once ('update_schedule.php');
            }
             if ($page == "17" ) {
            require_once ('select_schedule.php');
            }
        }
else{
    echo "<p class = 'alert alert-light'>Новых сообщений нету!</p>";
}         

?>