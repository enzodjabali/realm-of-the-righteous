<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-light">
        private chat

        <div id="player-list">

        </div>
    </div>
</div>

<script>
    $(function(){
        $.get("api/v1/player/getAll", function(response) {
            $('.spinner-border').addClass("visually-hidden");
            $('#player-list').html("");

            for (let i = 0; i < response.length; i++) {
                let id = response[i]['id'];
                let username = response[i]['username'];
                let lastActivity = response[i]['last_activity'];

                let activity = (Math.floor(new Date().getTime() / 1000) - lastActivity) > 7 ? '<span class="badge text-bg-secondary me-1">Offline</span>' : '<span class="badge text-bg-valid me-1">Online</span>';
                $('#player-list').append('<div onclick="displayChat(id, username)" class="mt-2 mb-2">' + activity + ' ' + username + '<span>Test</span></div><hr>');
            }
        });
    });

    function displayChat(id, username) {



    }

</script>