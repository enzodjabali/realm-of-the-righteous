export class FetchController {
    constructor(TowerController, model) {
        this.towerController = TowerController;
        this.model = model;
    }
    run() {
        console.log(this.model.getMatrice())
    }
}


