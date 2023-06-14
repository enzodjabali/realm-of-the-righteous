export class FetchController {
    constructor(TowerController, model) {
        this.towerController = TowerController;
        this.model = model;
    }
    run() {
        let matrice = this.model.getMatrice()
        for (let x = 0; x < matrice.length; x++) {
            for (let y = 0; y < matrice[x].length; y++) {
                if (matrice[x][y].tower) {
                    this.towerController.placeTowerInMatrice(null, null, matrice[x][y].tower)
                }
            }
        }
    }
}