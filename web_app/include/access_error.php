<?php
    if (!isset($_GET['id'])){
        if (!isset($_GET['page'])){
            return;
        }
        if ($_GET['page'] === 'index'){
            return;
        }
        include $include = 'include/error_pages/index.php';
        echo '<script> window.location.href = "' . $include . '?error=403"</script>';
    }
