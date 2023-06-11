<section class="hud">
    <div>
        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link" onclick="displayTab('hud-tab-general')">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="displayTab('hud-tab-tower-shop')">Buy Tower</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" onclick="displayTab('hud-tab-tower-actions')">Tower Actions</a>
            </li>
        </ul>
    </div>

    <div id="hud-tab-general" class="mt-3">
        <h4 id="life" class="text-center mb-3">Current Health: 100❤️</h4>
        <div class="d-flex game-stats">
            <div id ="money" class="p-2 flex-fill w-25"></div>
            <div class="p-2 flex-fill w-25">⏱️ 30g/m</div>
        </div>
        <div class="d-flex game-stats">
            <div id ="killedEnemies" class="p-2 flex-fill w-25"></div>
            <div class="p-2 flex-fill w-25">🧟 I</div>
        </div>

        <div class="hud-button mb-3 mt-2" style="height: 20%; width: 100%">
            <a href="#">Regain Health ❤️ 999G</a>
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
    </div>

    <div id="hud-tab-tower-shop" class="mt-3 visually-hidden">

        <div class="d-flex flex-wrap">
            <div id="button-buy-tower-container" class="d-flex flex-wrap">

            <div>
        </div>
    </div>

    <div id="hud-tab-tower-actions" class="mt-3 visually-hidden">
        <div class="hud-button mb-3" style="height: 20%; width: 100%">
            <a href="#">Upgrade tower ⚒️ 999G</a>
        </div>

        <div class="hud-button mb-3" style="height: 20%; width: 100%">
            <a href="#">Sell tower ❌ 999G</a>
        </div>

        <div class="tower-stats mt-4">
            <header class="text-center">
                <img height="60px" src="assets/images/towers/WT1.png">
                <h5 class="fw-bold">Wooden tower</h5>
            </header>

            <table class="table">
                <tbody class="text-center">
                <tr>
                    <th>Attack</th>
                    <td>10</td>
                </tr>
                <tr>
                    <th>Attack speed</th>
                    <td>0.8</td>
                </tr>
                <tr>
                    <th>Range</th>
                    <td>1000</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</section>
