<div class="page-header">
    <h3 class="page-title">Dashboard</h3>
</div>
<?php
$arr_code = ['128512', '128513', '128515', '128516', '128519', '128522'];
$smiley_code = array_rand($arr_code);
$smiley_code = $arr_code[$smiley_code];
$smiley_code = '&#' . $smiley_code . ';';
//    $smiley_code = '&#128540;';
?>
<!--<br>-->
<!--<br>-->
<h5 style="font-size: 20px;">
    Welcome, <?= ucfirst($user->firstName) . ' ' . ucfirst($user->lastName) . '! ' . $smiley_code ?></h5>
<div class="row">
    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Revenue</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">$32123</h2>
                            <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Revenue</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">$32123</h2>
                            <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h5>Revenue</h5>
                <div class="row">
                    <div class="col-8 col-sm-12 col-xl-8 my-auto">
                        <div class="d-flex d-sm-block d-md-flex align-items-center">
                            <h2 class="mb-0">$32123</h2>
                            <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
                        </div>
                        <h6 class="text-muted font-weight-normal">11.38% Since last month</h6>
                    </div>
                    <div class="col-4 col-sm-12 col-xl-4 text-center text-xl-right">
                        <i class="icon-lg mdi mdi-codepen text-primary ml-auto"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <img src="/Logimo/images/Untitled.jpg" alt="map" style="height: 200px; width: 100%">
    </div>
    <div>
        graph
    </div>
</div>
<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <h4 class="card-title mb-1">Latest News:</h4>
                    <p class="text-muted mb-1">Date</p>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="preview-list">
                            <div class="preview-item border-bottom">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-primary">
                                        <i class="mdi mdi-file-document"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content d-sm-flex flex-grow">
                                    <div class="flex-grow">
                                        <h6 class="preview-subject">Admin dashboard design</h6>
                                        <p class="text-muted mb-0">Broadcast web app mockup</p>
                                    </div>
                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                        <p class="text-muted">15 minutes ago</p>
                                        <p class="text-muted mb-0">30 tasks, 5 issues </p>
                                    </div>
                                </div>
                            </div>
                            <div class="preview-item border-bottom">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="mdi mdi-cloud-download"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content d-sm-flex flex-grow">
                                    <div class="flex-grow">
                                        <h6 class="preview-subject">Wordpress Development</h6>
                                        <p class="text-muted mb-0">Upload new design</p>
                                    </div>
                                    <div class="mr-auto text-sm-right pt-2 pt-sm-0">
                                        <p class="text-muted">1 hour ago</p>
                                        <p class="text-muted mb-0">23 tasks, 5 issues </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row justify-content-between">
                    <h4 class="card-title mb-1">Chatbot:</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Order Status</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input">
                                        <i class="input-helper"></i></label>
                                </div>
                            </th>
                            <th> Client Name</th>
                            <th> Order No</th>
                            <th> Product Cost</th>
                            <th> Project</th>
                            <th> Payment Mode</th>
                            <th> Start Date</th>
                            <th> Payment Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input">
                                        <i class="input-helper"></i></label>
                                </div>
                            </td>
                            <td>
                                <img src="assets/images/faces/face1.jpg" alt="image">
                                <span class="pl-2">Henry Klein</span>
                            </td>
                            <td> 02312</td>
                            <td> $14,500</td>
                            <td> Dashboard</td>
                            <td> Credit card</td>
                            <td> 04 Dec 2019</td>
                            <td>
                                <div class="badge badge-outline-success">Approved</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input">
                                        <i class="input-helper"></i></label>
                                </div>
                            </td>
                            <td>
                                <img src="assets/images/faces/face2.jpg" alt="image">
                                <span class="pl-2">Estella Bryan</span>
                            </td>
                            <td> 02312</td>
                            <td> $14,500</td>
                            <td> Website</td>
                            <td> Cash on delivered</td>
                            <td> 04 Dec 2019</td>
                            <td>
                                <div class="badge badge-outline-warning">Pending</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input">
                                        <i class="input-helper"></i></label>
                                </div>
                            </td>
                            <td>
                                <img src="assets/images/faces/face5.jpg" alt="image">
                                <span class="pl-2">Lucy Abbott</span>
                            </td>
                            <td> 02312</td>
                            <td> $14,500</td>
                            <td> App design</td>
                            <td> Credit card</td>
                            <td> 04 Dec 2019</td>
                            <td>
                                <div class="badge badge-outline-danger">Rejected</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input">
                                        <i class="input-helper"></i></label>
                                </div>
                            </td>
                            <td>
                                <img src="assets/images/faces/face3.jpg" alt="image">
                                <span class="pl-2">Peter Gill</span>
                            </td>
                            <td> 02312</td>
                            <td> $14,500</td>
                            <td> Development</td>
                            <td> Online Payment</td>
                            <td> 04 Dec 2019</td>
                            <td>
                                <div class="badge badge-outline-success">Approved</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-check form-check-muted m-0">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input">
                                        <i class="input-helper"></i></label>
                                </div>
                            </td>
                            <td>
                                <img src="assets/images/faces/face4.jpg" alt="image">
                                <span class="pl-2">Sallie Reyes</span>
                            </td>
                            <td> 02312</td>
                            <td> $14,500</td>
                            <td> Website</td>
                            <td> Credit card</td>
                            <td> 04 Dec 2019</td>
                            <td>
                                <div class="badge badge-outline-success">Approved</div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>