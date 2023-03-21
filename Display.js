// affiche tour par tour en fonction de la logique de game
class Display{
    constructor() {
    }
    displayBoard(matrice){
        let container = document.getElementById('board-container');
        let columns;
        // HELP ME
        for (let a ; a < matrice.length ; a++){
            columns += "50px "
        }
        container.style.gridTemplateColumns = columns;
        let imgArray = ["img/chemin.png", "img/herbe.png", "img/tour.png"];
        for (let x = 0 ; x < matrice.length ; x++){
            for (let y = 0 ; y < matrice[x].length ; y++){
                switch (matrice[x][y]){
                    case 0:
                        var img = document.createElement("img");
                        img.src = imgArray[0];
                        img.width = 50;
                        img.height = 50;
                        img.alt = "alt";
                        document.getElementById('board-container').appendChild(img);
                        break;
                    case 1:
                        var img = document.createElement("img");
                        img.src = imgArray[1];
                        img.width = 50;
                        img.height = 50;
                        img.alt = "alt";
                        document.getElementById('board-container').appendChild(img);

                        break;
                    case 2:
                        var img = document.createElement("img");
                        img.src = imgArray[2];
                        img.width = 50;
                        img.height = 50;
                        img.alt = "alt";
                        document.getElementById('board-container').appendChild(img);
                        break;
                    default:
                        break;
                }
            }

        }

    }
}
export { Display };