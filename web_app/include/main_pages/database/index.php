<div class="page-header">
    <h3 class="page-title">Database</h3>
</div>
<form id="load_table">
    <div class="row settings_class">
        <div class="col-lg">
            <label for="host_input">Host:</label>
            <input id="host_input" type="text" class="form-control" name="host_input" value="">
        </div>
        <div class="col-lg">
            <label for="database_input">Database:</label>
            <input id="database_input" type="text" class="form-control" name="database_input" value="">
        </div>
        <div class="col-lg">
            <label for="port_input">Port:</label>
            <input id="port_input" type="text" class="form-control" name="port_input" value="3306">
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-lg">
            <label for="username_input">Username:</label>
            <input id="username_input" type="text" class="form-control" name="username_input" value="">
        </div>
        <div class="col-lg">
            <label for="password_input">Password:</label>
            <input id="password_input" type="password" class="form-control" name="password_input" value="">
        </div>
    </div>
    <div class="row" style="margin-top: 20px">
        <div class="col-lg" style="text-align: right">
            <button type="submit" class="btn btn-warning mr-2" data-class="settings">Update</button>
        </div>
    </div>
</form>