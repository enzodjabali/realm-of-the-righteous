export class HUDController {
    constructor(model, display, towerController) {
        this.model = model;
        this.display = display;
        this.towerController = towerController;
    }

    createTower() {
        let button = document.getElementById('buyTower1')
        button.onclick = () => {
            if(this.display.pile == -1){
                console.log('peut pas')
            } else {
                console.log('clicked')
                this.towerController.placeTowerInMatrice()
                this.display.pile = -1;
            }
        }
    }
}