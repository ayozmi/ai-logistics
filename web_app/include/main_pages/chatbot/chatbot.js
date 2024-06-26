$(function () {
    let ajax_call = null;
    $("#send-chat").on("click", null, null, function () {
        let message = $("#chatbot-input");
        const main_chat = $("#chat-main");
        let date = getCurrentDateTime();
        main_chat.append("<div class=\"row\" style=\"justify-content: right\">\n" +
            "                        <div class=\"bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3\">\n" +
            "                            <div class=\"text-md-center text-xl-left\">\n" +
            "                                <h6 class=\"mb-1\">" + message.val() + "</h6>\n" +
            "                                <p class=\"text-muted mb-0\" style=\"text-align: right\">" + date + "</p>\n" +
            "                            </div>\n" +
            "                        </div>\n" +
            "                    </div>");
        main_chat.append("<div class=\"row\">\n" +
            "                        <img src=\"images/spinner.svg\" alt=\"loading..\" width='200px'>\n" +
            "                    </div>");
        send_chat(message.val());
        message.val("");
    })

    function getCurrentDateTime() {
        let now = new Date();
        let year = now.getFullYear();
        let month = (now.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-based
        let day = now.getDate().toString().padStart(2, '0');
        let hours = now.getHours().toString().padStart(2, '0');
        let minutes = now.getMinutes().toString().padStart(2, '0');

        return `${day}/${month}/${year} ${hours}:${minutes}`;
    }

    function send_chat(message){
        if (ajax_call !== null){
            ajax_call = ajax_call.abort();
        }
        console.log(message)
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
                let date = getCurrentDateTime();
                const main_chat = $("#chat-main");
                response = response.replace(/\n/g, "<br>");
                main_chat.children().last().remove();
                main_chat.append("<div class=\"row\" style=\"justify-content: left\">\n" +
                    "                        <div class=\"bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3\">\n" +
                    "                            <div class=\"text-md-center text-xl-left\">\n" +
                    "                                <h6 class=\"mb-1\">" + response + "</h6>\n" +
                    "                                <p class=\"text-muted mb-0\" style=\"text-align: right\">" + date + "</p>\n" +
                    "                            </div>\n" +
                    "                        </div>\n" +
                    "                    </div>");
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.log('Response body:', xhr.responseText);
            }
        })
    }
})