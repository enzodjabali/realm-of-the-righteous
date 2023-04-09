export class TowerController{
    constructor(model, display){
        this.model = model;
        this.display = display;
    }
    placeTowerInDisplay(){
        console.log('Je suis tile de display', this.display.tile)
        this.display.pile.classList.remove('tile-shadow'); // remove class (not selected anymore)
        this.display.pile.src = '../assets/images/towers/T1.png'
        this.display.pile = -1;
    }
    placeTowerInMatrice(){

    }
}
