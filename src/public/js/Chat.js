/**
 * This function reloads the messages every 500ms
 */
setInterval(function(){
    /**
     * This function gets all the chat messages and display them
     */
    $(function(){
        $.get("api/v1/chat/getAll", function(response) {
            let chatMessages = response;

            document.getElementById('message-list').innerHTML = '';

            let date = new Date();
            let currentDate = date.toLocaleString("default", { year: "numeric" }) + "-" + date.toLocaleString("default", { month: "2-digit" }) + "-" + date.toLocaleString("default", { day: "2-digit" });

            for (let i = 0; i < chatMessages.length; i++) {
                let username = chatMessages[i]['username'];
                let message = chatMessages[i]['message'];
                let date = "";

                if (currentDate === chatMessages[i]['date']) {
                    date = "today";
                } else {
                    date = chatMessages[i]['date'];
                }

                document.getElementById('message-list').innerHTML += '<b>' + username + '</b> (' + date + '): ' + message + '<br>';
            }
        });
    });
}, 500);

/**
 * This function calls the chat message insert method
 * If the insert method success the player's message is sent, if not an error message is displayed
 */
$(function(){
    $("#chat-form").submit(function(){
        let message = $(this).find("input[name=message]").val();

        $.post("api/v1/chat/insert", {message: message}, function(){
            document.getElementById('message').value = "";
        }).fail(function(response) {
            $(document).ready(function() {
                $(".toast").removeClass('text-bg-valid');
                $(".toast").addClass('text-bg-danger');
                $(".toast").toast('show');
                $(".toast-body").html(JSON.parse(response.responseText).response);
            });
        });
        return false;
    });
});
