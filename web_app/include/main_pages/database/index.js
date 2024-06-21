$(function () {
    fetch_data()
    let ajax_call = null;

    function fetch_data(){
        // let host=""; let database=""; let port=""; let username="";
        if(ajax_call !== null){ajax_call.abort()}
        ajax_call = $.ajax({
            url: 'include/main_pages/database/fetch_active_database.ajax.php',
            type: 'POST',
            cache: false,
            contentType: 'application/json',
            processData: false,
            dataType: 'json',
            success: data => {
                if (data) {
                    $("#host_input").val(data.host)
                    $("#database_input").val(data.database)
                    $("#port_input").val(data.port)
                    $("#username_input").val(data.username)
                }
            },
            //TODO ADD ERROR HANDLING
            error: data => {

            }
        })
    }
})