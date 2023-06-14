<section class="wrap-container" style="z-index: 10;">
    <div>
        <ul class="nav nav-tabs justify-content-center border-0">
            <li class="btn btn-form-submit" style="width: 33%" onclick="displayTabHUD('hud-tab-general')">
                General
            </li>
            <li class="btn btn-form-submit" style="width: 33%" onclick="displayTabHUD('hud-tab-tower-shop')">
                Buy Tower
            </li>
            <li class="btn btn-form-submit" style="width: 33%">
                Settings
            </li>
        </ul>
    </div>

    <div id="hud-tab-general" class="mt-3">
        <h4 id="life" class="health-stats text-center mb-3 pt-2 pb-2">Current Health: 100❤️</h4>
        <div class="d-flex game-stats">
            <div id="money" class="p-2 flex-fill w-25"></div>
            <div id="gold-per-minute" class="p-2 flex-fill w-25">⏱️ 0 g/min</div>
        </div>
        <div class="d-flex game-stats">
            <div id ="killedEnemies" class="p-2 flex-fill w-25"></div>
            <div id="wave-counter" class="p-2 flex-fill w-25"></div>
        </div>

        <div class="hud-button mb-3 mt-2" style="height: 20%; width: 100%">
            <p id="play-game">Play game</p>
        </div>

        <div class="hud-button mb-3" style="height: 20%; width: 100%">
            <a href="#">Boost Tower Speed ⚡ 999G</a>
        </div>

        <div class="hud-button mb-3" style="height: 20%; width: 100%">
            <a href="#">Arrow Volley 🏹 999G</a>
        </div>

        <div class="hud-button mb-3" style="height: 20%; width: 100%">
            <a href="#">Boost Tower Range 🔍 999G</a>
        </div>

        <div id="game-logger"></div>
    </div>

    <div id="hud-tab-tower-shop" class="mt-3 visually-hidden">

        <div class="d-flex flex-wrap">
            <div id="button-buy-tower-container" class="d-flex flex-wrap">

            </div>
        </div>
    </div>

    <div id="hud-tab-tower-actions" class="mt-3 visually-hidden">
        <div id="upgrade-tower" class="hud-button mb-3" style="height: 20%; width: 100%">
        </div>

        <div id ="sell-tower" class="hud-button mb-3" style="height: 20%; width: 100%">
        </div>

        <div class="tower-stats mt-4">
            <header class="text-center">
                <img id="tower-src-value" height="60px" src="">
                <h5 id="tower-type-value" class="fw-bold">Wooden tower</h5>
            </header>

            <table class="table">
                <tbody class="text-center">
                <tr>
                    <th>Attack</th>
                    <td id="attack-value"></td>
                </tr>
                <tr>
                    <th>Attack speed</th>
                    <td id="attack-speed-value"></td>
                </tr>
                <tr>
                    <th>Range</th>
                    <td id="range-value"></td>
                </tr>
                <tr>
                    <th>Level</th>
                    <td id="level-value"></td>
                </tr>
                <tr>
                    <th>Current damage boost</th>
                    <td id="current-damage-boost-value"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</section>
