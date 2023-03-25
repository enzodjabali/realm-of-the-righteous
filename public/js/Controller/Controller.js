import {EnemiesController} from "./EnemiesController.js";
import {Model} from "../Model/Model.js";

export class Controller{
    constructor() {
        this.model = new Model();
        this.enemiesController = new EnemiesController(this.model);
    }
    createEnnemies(){
        let id = 0;
        let waves = this.model.getWaves()
        for(var wave of waves){
            for(var groups of wave){
                for(let test = 0; test < groups[0]; test++){
                    this.enemiesController.createEnemiesIntoToPlaceList(id, groups[1])
                    id++;
                }
            }
            console.log(this.model.enemiesToPlace);
        }
        this.enemiesController.placeEnemiesInMatrice()
    }
    updateMatrice(){

    }


}