<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <title>Logimo</title>
    <?php
    include('include/access_error.php');
    include('include/head_html.php');
    ?>
    <style>
        .pag{
            text-align: center;
        }
    </style>
</head>
<body>
<div id="main-div" class="container-fluid page-body-wrapper" style="width: 100%;">
    <?php
    include('include/sidebar.php');
    ?>
    <?php
    include('include/header.php');
    ?>
    <div class="main-panel">
        <div class="content-wrapper">
            <?php
            if (!isset($_GET['page'])) {
                $_GET['page'] = 'index';
            }
            $include = 'include/main_pages/' . $_GET['page'] . '/index.php';
            if (!file_exists($include)) {
                $include = 'include/error_pages/index.php';
                echo '<script> window.location.href = "' . $include . '?error=404"</script>';
            }
            include($include);
            ?>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>
</html>
