<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Private chat</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-light">
        <div id="player-list"></div>

        <div id="private-chat" class="visually-hidden">
            <div class="mb-3">
                <button class="btn btn-form-cancel" onclick="$('#player-list').removeClass('visually-hidden');$('#private-chat').addClass('visually-hidden');">
                   <i class="bi bi-arrow-left-square-fill"></i>
                </button>
                <span id="mate-username"></span>
            </div>
            <span id="mate-id" class="visually-hidden"></span>
            <div id="private-message-list" class="card-body overflow-y-scroll" style="height: 400px"></div>

            <div class="mt-3">
                <form id="private-chat-form" method="post" class="input-group">
                    <input type="text" class="form-control me-2 shadow-none" name="privateMessage" id="privateMessage">
                    <div class="input-group-prepend">
                        <button class="btn btn-form-submit h-100" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function stopDisplayChat(refreshIntervalId) {
        if (refreshIntervalId !== false) {
            clearInterval(refreshIntervalId);
        }
    }

    function displayChat(id) {
        $('#player-list').addClass("visually-hidden");

        let refreshIntervalId = setInterval(() => {
            $.get("api/v1/privateChat/getAll?matePlayerId=" + id, function (response) {
                let offcanvas = document.getElementById('offcanvasRight');
                offcanvas.addEventListener('hidden.bs.offcanvas', function () {
                    $('#player-list').removeClass('visually-hidden');
                    $('#private-chat').addClass('visually-hidden');
                    stopDisplayChat(refreshIntervalId);
                });

                if ($("#private-chat").hasClass("visually-hidden")) {
                    stopDisplayChat(refreshIntervalId);
                }

                $('#private-message-list').html("");

                for (let i = 0; i < response.length; i++) {
                    let sender = response[i]['sender'];
                    let message = response[i]['message'];

                    $('#private-message-list').append('<b>' + sender + '</b>: ' + message + '<br>');

                }

            });
        }, 500);

        $('#private-message-list').html("");
        return refreshIntervalId;
    }

    let currentChat = false;

    let offcanvas = document.getElementById('offcanvasRight');
    offcanvas.addEventListener('show.bs.offcanvas', function () {
        $('#player-list').html("");

        $(function(){
            $.get("api/v1/player/getAll", function(response) {
                for (let i = 0; i < response.length; i++) {
                    let id = response[i]['id'];
                    let username = response[i]['username'];
                    let lastActivity = response[i]['last_activity'];

                    let isMe = "";
                    if (username == "<?= $sessionUsername ?>") {
                        isMe = "(me)";
                    }

                    let activity = (Math.floor(new Date().getTime() / 1000) - lastActivity) > 7 ? '<span class="badge text-bg-secondary me-1">Offline</span>' : '<span class="badge text-bg-valid me-1">Online</span>';
                    $('#player-list').append('<div onclick="stopDisplayChat(currentChat);currentChat = displayChat('+ id +');$(\'#player-list\').addClass(\'visually-hidden\');$(\'#private-chat\').removeClass(\'visually-hidden\');$(\'#mate-username\').html(\'' + username + '\');$(\'#mate-id\').html(\'' + id + '\')" class="select-player pt-2 pb-2">' + activity + ' ' + username + ' ' + isMe + '</div><hr>');

                }
            });
        });
    });

    /**
     * This function calls the chat message insert method
     * If the insert method success the player's message is sent, if not an error message is displayed
     */
    $(function(){
        $("#private-chat-form").submit(function(){
            let matePlayerId = $('#mate-id').text();
            let message = $(this).find("input[name=privateMessage]").val();

            $.post("api/v1/privateChat/insert", {matePlayerId: matePlayerId, message: message}, function(){
                document.getElementById('privateMessage').value = "";
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
</script>
