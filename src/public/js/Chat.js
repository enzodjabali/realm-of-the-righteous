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

            let d = new Date();
            let currentDate = d.getFullYear() + "-" +((d.getMonth()+1).length !== 2 ? "0" + (d.getMonth() + 1) : (d.getMonth()+1)) + "-" + (d.getDate().length !== 2 ?"0" + d.getDate() : d.getDate());

            for (let i = 0; i < chatMessages.length; i++) {
                let username = chatMessages[i]['username'];
                let message = chatMessages[i]['message'];
                let date = "";

                if (currentDate === chatMessages[i]['date']) {
                    date = "today";
                } else {
                    date = chatMessages[i]['date'];
                }

                document.getElementById('message-list').innerHTML += '<a><b>' + username + '</b> (' + date + '): ' + message + '</a><br>';
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
                $(".toast").toast('show');
                $(".toast-body").html(JSON.parse(response.responseText).response);
            });
        });
        return false;
    });
});
