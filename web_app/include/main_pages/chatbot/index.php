<?php
$date = date('d/m/Y H:i');
?>
<script src="/Logimo/include/main_pages/chatbot/chatbot.js" defer></script>
<style>
    .bg-gray-dark{
        max-width: 50%;
    }
</style>
<div class="row">
    <div class="col-md-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body" style="position: relative; min-height: 500px;">
                <h4 class="card-title" style="color: #FFAB00">🤖 Logimobot:</h4>
                <div id="chat-main" style="margin-bottom: 50px">
                    <div class="row">
                        <div class="bg-gray-dark d-flex d-md-block d-xl-flex flex-row py-3 px-4 px-md-3 px-xl-4 rounded mt-3">
                            <div class="text-md-center text-xl-left">
                                <h6 class="mb-1">Hola, soy Logibot, ¿como puedo ayudarte?</h6>
                                <p class="text-muted mb-0" style="text-align: right"><?php echo $date?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="row add-items d-flex" style="position: absolute; width: 100%; bottom: 0;">
                        <div class="col-lg-11">
                            <input type="text" class="form-control todo-list-input" id="chatbot-input" placeholder="Message Logimobot...">
                        </div>
                        <div class="col-lg-1" style="padding-left: 0">
                            <button class="add btn btn-primary todo-list-add-btn" id="send-chat" style="height: 100%">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>