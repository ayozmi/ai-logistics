<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
        <a class="sidebar-brand brand-logo" href="/Boxcom/index.php"><img src="/Logimo/images/logo.png" alt="logo"></a>
        <a class="sidebar-brand brand-logo-mini" href="/Boxcom/index.php"><img src=""
                                                                               alt="logo" width="50px"></a>
    </div>
    <ul class="nav">
        <li class="nav-item profile">
            <div class="profile-desc">
                <div class="profile-pic">
                    <div class="count-indicator">
                        <img class="img-xs rounded-circle" src="<?= getProfilePicture($user->id) ?>"
                             alt="Profile Picture">
                        <span class="count bg-success"></span>
                    </div>
                    <div class="profile-name">
                        <h5 class="mb-0 font-weight-normal"><?php echo ucfirst($user->firstName) . ' ' . ucfirst($user->lastName) ?></h5>
                        <span><?php echo ucfirst($user->profile) ?></span>
                    </div>
                </div>
            </div>
        </li>
        <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
        </li>
        <?php
        $pages = getAllPages($user->profileId);
        foreach ($pages as $page) {
            $parent_controller = "";
            $show = "";
            $active = "";
            if (isset($_GET['id'])) {
                if ($_GET['id'] == $page->id) {
                    $show = "show";
                    $active = "active";
                }
            }
            $key = false;
            if ($page->has_child != null) {
                $children = get_children(intval($page->id));
                $key = in_array($_GET['id'], array_column($children, 'idPage'));
                if ($key !== false) {
                    $show = "show";
                    $active = "active";
                }
            }
            if ($page->has_child != null) {
                $parent_controller = 'data-toggle="collapse" aria-expanded="true" aria-controls="ui-basic"';
            }
            ?>
            <li class="nav-item menu-items <?= $active ?>">
                <a class="nav-link collapsed" data-browse="<?= $page->folder ?>" data-id="<?= $page->id ?>"
                   href="<?= $page->folder ?>" <?= $parent_controller ?>>
              <span class="menu-icon">
                <i class="mdi <?= $page->icon ?>"></i>
              </span>
                    <span class="menu-title"><?= $page->name ?></span>
                    <?php
                    if ($parent_controller != "") {
                        echo '<i class="mdi mdi-arrow-down-drop-circle-outline arrow_sidebar" style="margin: 0 5px;"></i>';
                    }
                    ?>
                </a>
                <?php
                if ($page->has_child != null) {
                    if ($key !== false) {
                        $show = "show";
                    }
                    ?>
                    <div class="collapse <?= $show ?>" id="ui-basic" style="cursor: pointer;">
                        <ul class="nav flex-column sub-menu">
                            <?php
                            foreach ($children as $child) {
                                if ($_GET['id'] == $child['idPage']){
                                    $active = "active";
                                }
                                else{
                                    $active = "";
                                }
                                echo '<li class="nav-item">
                                    <a class="nav-link ' .$active . '" data-browse="' . $child["folderPage"] . '" data-id="' . $child["idPage"] . '">' . $child["namePage"] . '</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                }
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
</nav>