$(function () {
    let ajax_call = null;
    fetch_data();

    function fetch_data() {
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
                "<td>" + data.content[i][0] + "</td>" +
                "<td>" + data.content[i][1] + "</td>" +
                "<td>" + data.content[i][2] + "</td>" +
                "<td>" + data.content[i][3] + "</td>" +
                "<td>" + data.content[i][6] + "</td>" +
                "<td>" + data.content[i][5] + "</td>";

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
})