<div class="page-header">
    <h3 class="page-title"> Users </h3>
</div>
<div class="row">
    <div class="col-lg grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table userTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Birth Date</th>
                            <th>Sex</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $userObj = new User();
                        $users = $userObj->getAllUsers();
                        foreach ($users as $userOne) {
                            if ($userOne['profileUser'] >= 100) {
                                $class = 'badge-danger';
                            }
                            if ($userOne['profileUser'] >= 120) {
                                $class = 'badge-warning';
                            }
                            echo "<tr>";
                            echo "<td><img class='img-xs rounded-circle' src='" . getProfilePicture($userOne['idUser']) . "' alt='' style='width: 50px; height: 50px;'></td>   ";
                            echo "<td>" . $userOne['firstName'] . " " . $userOne['lastName'] . "</td>";
                            echo "<td><a href='mailto:" . $userOne['emailUser'] . "'>" . $userOne['emailUser'] . "</td>";
                            echo "<td>" . $userOne['phoneNumber'] . "</td>";
                            echo "<td>" . date("d/m/Y", strtotime($userOne['birthDate'])) . "</td>";
                            echo match (intval($userOne['sexUser'])) {
                                1 => "<td>Male</td>",
                                2 => "<td>Female</td>",
                                default => "<td>Other</td>",
                            };
                            echo "<td><label class='badge " . $class . "'>" . $userObj->getProfile($userOne['profileUser']) . "</label></td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".userTable").fancyTable({
            pagination: true,
            perPage: 10,
            globalSearch: false,
            searchable: false,
            sortable: false,
        });
    });
</script>