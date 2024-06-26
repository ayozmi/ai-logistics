$(function () {
    let ajax_call = null;
    fetch_news();
    fetch_cost_prediction();
    function fetch_news() {
        if (ajax_call !== null) {
            ajax_call.abort()
        }
        ajax_call = $.ajax({
            url: 'include/main_pages/news/fetch_news_ajax.php',
            type: 'POST',
            cache: false,
            contentType: 'application/json',
            processData: false,
            data: JSON.stringify({type: 1}),
            dataType: 'json',
            success: data => {
                // console.log(data.content.length);
                for (let i = 0; i < data.content.length; i++) {
                    $("#latest_news").append("<div class=\"preview-list\">\n" +
                        "                            <div class=\"preview-item border-bottom\">\n" +
                        "                                <div class=\"preview-item-content d-sm-flex flex-grow\">\n" +
                        "                                    <div class=\"flex-grow\">\n" +
                        "                                        <h6 class=\"preview-subject\"><a href='" + data.content[i].link + "'>" + data.content[i].title + "</a></h6>\n" +
                        "                                        <p class=\"text-muted mb-0\">" + data.content[i].location + "</p>\n" +
                        "                                    </div>\n" +
                        "                                    <div class=\"mr-auto text-sm-right pt-2 pt-sm-0\">\n" +
                        "                                        <p class=\"text-muted\">" + data.content[i].date + "</p>\n" +
                        "                                    </div>\n" +
                        "                                </div>\n" +
                        "                            </div>\n" +
                        "                        </div>")
                }
            },
            error: data => {

            }
        })
    }

    function fetch_cost_prediction() {
        ajax_call = $.ajax({
            url: 'include/main_pages/cost_predictor/fetch_cost_prediction.ajax.php',
            type: 'POST',
            cache: false,
            contentType: 'application/json',
            processData: false,
            data: JSON.stringify({type: 1}),
            dataType: 'json',
            success: data => {
                write_table(data);
            },
            error: data => {
                // TODO add error handling
            }
        })
    }

    function write_table(data) {
        for (let i = 0; i < data.content.length; i++) {
            // Create the initial part of the row
            let row = "<tr>" +
                "<td style='text-align: right'>" + data.content[i][0] + "</td>" +
                "<td>" + data.content[i][1] + "</td>" +
                "<td>" + data.content[i][2] + "</td>" +
                "<td style='text-align: right'>" + data.content[i][3] + "</td>" +
                "<td>" + data.content[i][6] + "</td>" +
                "<td style='text-align: right'>" + data.content[i][5] + "</td>";

            // Log the value of data.content[i][4]
            console.log(data.content[i][4]);

            // Append the badge based on the value of data.content[i][4]
            if (data.content[i][4] == "0") {
                row += "<td><div class='badge badge-outline-success'>On time</div></td>";
            } else {
                row += "<td><div class='badge badge-outline-danger'>Delayed</div></td>";
            }

            // Close the row
            row += "</tr>";

            // Append the complete row to the table
            $("#data_table").append(row);
        }
        $(".fancytbl").fancyTable({
            sortColumn: 5,
            sortOrder: 'DESC',
            pagination: true,
            perPage: 5,
            exactMatch: false,
            paginationClass: "btn btn-primary",
            pagClosest: 2,
            searchable: true,
            sortable: true,
            paginationElement: '.pagination-fancy',
            globalSearch: false,
            inputStyle: "border: 1px solid #2c2e33;\n" +
                "  height: calc(2.25rem + 2px);\n" +
                "  font-weight: normal;\n" +
                "  font-size: 0.875rem;\n" +
                "  padding: 0.625rem 0.6875rem;\n" +
                "  background-color: #2A3038;\n" +
                "  border-radius: 2px;\n" +
                "    border-top-right-radius: 2px;\n" +
                "    border-bottom-right-radius: 2px;\n" +
                "  color: #ffffff;",
        })
        $('.fancySearchRow th').eq(6).html('');
    }

    $("#send-chat").on("click", null, null, function () {
        let message = $("#chatbot-input");
        const main_chat = $("#chat-main");
        main_chat.append("<div class=\"preview-item-content d-flex flex-grow\">\n" +
            "                            <div class=\"flex-grow\">\n" +
            "                                <div class=\"d-flex d-md-block d-xl-flex justify-content-between\">\n" +
            "                                    <h6 class=\"preview-subject\">You:</h6>\n" +
            "                                </div>\n" +
            "                                <p class=\"text-muted\">" + message.val() + "</p>\n" +
            "                            </div>\n" +
            "                        </div>");
        send_chat(message.val());
        message.val("");
    });

    function send_chat(message){
        $.ajax({
            url: 'https://886e-77-227-78-31.ngrok-free.app/twilio/',
            type: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Optional: Some CORS proxies require this header
            },
            data: {
                From: "whatsapp:+34611712480",
                Body: message
            },
            success: function (response){
                const main_chat = $("#chat-main");
                response = response.replace(/\n/g, "<br>");
                main_chat.append("<div class=\"preview-item-content d-flex flex-grow\">\n" +
                    "                            <div class=\"flex-grow\">\n" +
                    "                                <div class=\"d-flex d-md-block d-xl-flex justify-content-between\">\n" +
                    "                                    <h6 class=\"preview-subject\">Logibot:</h6>\n" +
                    "                                </div>\n" +
                    "                                <p class=\"text-muted\">" + response + "</p>\n" +
                    "                            </div>\n" +
                    "                        </div>")
            },error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Response body:', xhr.responseText);
            }
        })
    }
})