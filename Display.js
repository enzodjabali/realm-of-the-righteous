// affiche tour par tour en fonction de la logique de game
class Display{
    constructor() {
    }
    displayBoard(matrice){
        let columns = '';
        // HELP ME
        let xRatio;
        let yRatio;
        let size = 0;

        xRatio = window.innerWidth / matrice.length;
        yRatio = window.innerHeight / matrice[0].length;
        console.log(xRatio);
        console.log(yRatio);

        if (xRatio >= yRatio){
            size = yRatio
        } else {
            size = xRatio
        }
        console.log(size);
        for (let a = 1 ; a < matrice.length ; a++){
           columns += `${size-1}px `

        }
        let container = document.getElementById('board-container');
        container.style.gridTemplateColumns = columns;
        let imgArray = ["img/chemin.png", "img/herbe.png", "img/tour.png"];

        // Per
        for (let x = 0 ; x < matrice.length ; x++){
            for (let y = 0 ; y < matrice[x].length ; y++){
                switch (matrice[x][y]){
                    case 0:
                        var img = document.createElement("img");
                        img.src = imgArray[0];
                        img.width = size;
                        img.height = size;
                        img.alt = "alt";
                        document.getElementById('board-container').appendChild(img);
                        break;
                    case 1:
                        var img = document.createElement("img");
                        img.src = imgArray[1];
                        img.width = size;
                        img.height = size;
                        img.alt = "alt";
                        document.getElementById('board-container').appendChild(img);

                        break;
                    case 2:
                        var img = document.createElement("img");
                        img.src = imgArray[2];
                        img.width = size;
                        img.height = size;
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