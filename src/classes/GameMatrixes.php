<?php
declare(strict_types = 1);

namespace App\classes;

/**
 * Enumeration of the game matrixes
 */
enum GameMatrixes: string
{
    case MATRIX_EASY = '{
            "matrice": [[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northwest","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northeast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"southeastcorner","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"northwest","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"northwest","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"northeastcorner","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northeast","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"southeastcorner","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"southeastcorner","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"northeastcorner","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"southwest","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"southeastcorner","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southeast","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"northeastcorner","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"southwest","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"northwest","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"bordernorth","enemies":[],"tower":null},{"tile":"northeast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"southeastcorner","enemies":[],"tower":null},{"tile":"southwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"northeastcorner","enemies":[],"tower":null},{"tile":"northwestcorner","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[{"id":0,"max_life":10,"curent_life":10,"armor":0,"position":{"x":18,"y":5},"path_img":"../../assets/images/mobs/batvol.gif","path":[[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[-1,0],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[0,1],[1,0],[1,0],[1,0],[0,-1],[0,-1],[1,0],[1,0],[1,0],[0,1],[0,1],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[1,0],[0,-1],[0,-1],[0,-1],[-1,0],[-1,0],[-1,0],[-1,0],[0,-1],[0,-1],[0,-1],[1,0],[1,0],[1,0],[1,0],[1,0]],"typeOfEnemies":"bat","step":0,"speed":20}],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}],[{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"borderwest","enemies":[],"tower":null},{"tile":"basepath","enemies":[],"tower":null},{"tile":"bordereast","enemies":[],"tower":null},{"tile":"southwest","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"bordersouth","enemies":[],"tower":null},{"tile":"southeast","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null},{"tile":"basegrass","enemies":[],"tower":null}]],
            "waves" : {
                "easy" : [[[1,"bat"],[2,"golem"],[2,"knight"],[2,"witch"],[2,"wolf"]]],
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
    
    case MATRIX_NORMAL = "normal";
    case MATRIX_HARD = "hard";
}
