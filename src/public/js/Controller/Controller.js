import {EnemiesController} from "./EnemiesController.js";
import {Model} from "../Model/Model.js";
import {Display} from "../Vue/Display.js";

export class Controller{
    constructor() {
        this.model = new Model();
        this.display = new Display();
        this.enemiesController = new EnemiesController(this.model);

    }
    
    /*createEnnemy(){
        // Creates enemies with this.waves.
        // ID of each enemy
        let id = 0;
        let waves = this.model.getWaves()
        for(var wave of waves){
            //For each wave of enemies
            for(var groups of wave)
                // For each type of enemy + its quantity
                for(let test = 0; test < groups[0]; test++){
                    this.enemiesController.createEnemiesIntoToPlaceList(id, groups[1])
                    id++;
                }
            //Implement a win wave condition
        }
        this.enemiesController.placeEnemiesInMatrice();
    }*/

    updateEnemiesPosition(enemy, nextPosition){
        //Update enemy position within its object (enemy.position) by tick
        const matrice = this.model.getMatrice();

        enemy.position.x += nextPosition[0]
        enemy.position.y += nextPosition[1]

        //supprime enemy dans matrice
        matrice[enemy.position.x][enemy.position.y].enemies.splice(enemy,1)

        // doit ajouter enemy dans matrice a nouvelle position
        this.updateEnemyInMatrice(enemy);
    }
    updateEnemyInMatrice(enemy) {
        //Update enemy in matrice by its position in its object (enemy.position.x / enemy.position.y)
        let matrice = this.model.getMatrice();
        matrice[enemy.position.x][enemy.position.y].enemies.push(enemy);
    }
    setup(){
        this.display.initializeBoard(this.model.getMatrice());
    }

    async loop(diffculty){
        // Find path for waves using model's matrice, entry and end points

        console.log('wait timeBeforeStart', this.model.timeBeforeStart)
        await new Promise(r => setTimeout(r, this.model.timeBeforeStart));
                

        for(let waves of this.model.waves[diffculty]){
            if (this.model.waves[diffculty].indexOf(waves) != 0)
                {console.log('wait timeBetweenWaves', this.model.timeBetweenWaves)
                await new Promise(r => setTimeout(r, this.model.timeBetweenWaves));
                }
                this.model.currentWave++;

            for (let group of waves){
                if (waves.indexOf(group) != 0)
                    {console.log('wait timeBetweenGroups', this.model.timeBetweenGroups)
                    await new Promise(r => setTimeout(r, this.model.timeBetweenGroups));
                    }
                    this.model.currentGroup++;
            
                for (let mob = 0; mob < group[0]; mob++){
                    console.log(this.model.mobId, '<<<<<')
                    let path = this.model.findPathForWaves(this.model.getMatrice(), this.model.entryPoints[0], this.model.endPoints[1]);


                    let enemy = this.enemiesController.createEnnemyObject(this.model.mobId, path,this.model.entryPoints[0], group[1])

                    this.display.initializeEnemy(enemy);
                    
                    this.run(enemy, path); // Run the movement loop for each enemy
                    await new Promise(r => setTimeout(r, 500)); // Delay 500ms between each enemy's movement for smoother animation
                    this.model.mobId++;
                }
            }
        }
    }

    
    async run(enemy, path) {
        try {
            for (let step = 0; step <= path.length; step++) {
                let test = await this.display.nextMoveEnemy(enemy, path[step]); // Await the next move of the enemy using the nextMoveEnemy() method
                if (step <= path.length-1) {
                    await this.updateEnemiesPosition(enemy, path[step]); // Await the update of the enemy's position
                }
                
                //console.log(enemy.position.x, enemy.position.y); // Log the enemy's current position
            }
            console.log('complete');
            // Add your code to handle end of path reached
        } catch (error) {
            // Handle any errors that may occur during the enemy's movement
            console.error('Error:', error);
        }
    }





}