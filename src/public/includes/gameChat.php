<section class="wrap-container" style="width: 23%">
    <div>
        <ul class="nav nav-tabs justify-content-center border-0">
            <li class="btn btn-form-submit" style="width: 50%" onclick="displayTabChat('chat-tab-logger')">
                Events
            </li>
            <li class="btn btn-form-submit" style="width: 50%" onclick="displayTabChat('chat-tab-general')">
                Chat
            </li>
        </ul>
    </div>

    <div id="chat-tab-logger" class="mt-3">
        <!-- Card of the log list -->
        <div class="card">
            <div class="card-header text-center">
                Events
            </div>
            <div id="event-list" class="card-body overflow-y-scroll" style="height: 400px">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <div id="spinner" class="spinner-border mt-4 mb-4" role="status"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="chat-tab-general" class="mt-3 visually-hidden">
        <!-- Card of the message list -->
        <div class="card">
            <div class="card-header text-center">
                Chat
            </div>
            <div id="message-list" class="card-body overflow-y-scroll" style="height: 400px">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <div id="spinner" class="spinner-border mt-4 mb-4" role="status"></div>
                </div>
            </div>
            <form id="chat-form" method="post" class="input-group card-footer text-body-secondary">
                <input type="text" class="form-control shadow-none me-2" name="message" id="message">
                <div class="input-group-prepend">
                    <button class="btn btn-form-submit h-100" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</section>
