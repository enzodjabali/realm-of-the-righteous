<?php
declare(strict_types = 1);

namespace App\classes;

/**
 * Enumeration of the game models
 */
enum GameModels: string
{
    case MODEL_EASY = '{

"matrice": [
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"se","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"sw","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"eastwest","enemies":[],"tower":null},{"tile":"nw","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"se","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"sw","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"eastwest","enemies":[],"tower":null},{"tile":"forksouth","enemies":[],"tower":null},{"tile":"forknorth","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"forknorth","enemies":[],"tower":null},{"tile":"forksouth","enemies":[],"tower":null},{"tile":"nw","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northsouth","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"ne","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"eastwest","enemies":[],"tower":null},{"tile":"nw","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],
[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}]
],
            "waves" : {
                "easy" : [[[3,"golem"]], [[3, "knight"]]],
                "medium" : [[[1,"bat"],[2,"golem"],[2,"knight"],[2,"witch"],[2,"wolf"]], [[2,"bat"],[4,"golem"],[4,"knight"],[4,"witch"],[4,"wolf"]]],
                "hard" : [[[1,100],[0,110]]] },
            "timeBetweenWaves" : 1000,
            "timeBetweenGroups" : 500,
            "difficulty" : "easy",
            "timeBeforeStart" : 1000,
            "currentWave" : 0,
            "currentGroup" : 0,
            "mobId" : 0,
            "towerId" : 0,
            "towerWeaponId" : 0,
            "entryPoints" : [[19,5]],
            "endPoints" : [[19,8]] }';
    
    case MODEL_NORMAL = "normal";
    case MODEL_HARD = "hard";
}

