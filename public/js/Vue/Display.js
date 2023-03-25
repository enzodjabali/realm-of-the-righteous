// Display to the users the game
class Display{
    constructor() {
    }
    displayBoard(matrice){
        let columns = '';
        // HELP ME
        let xRatio;
        let yRatio;
        let size = 0;

        xRatio = (0.95*window.innerWidth) / (matrice[0].length);
        yRatio = (0.95*window.innerHeight) / (matrice.length);
        console.log(xRatio);
        console.log(yRatio);

        if (xRatio >= yRatio){
            size = yRatio
        } else {
            size = xRatio
        }
        for (let a = 0 ; a < matrice[0].length ; a++){
           columns += `${size-1}px `

        }
        let container = document.getElementById('board-container');
        container.style.gridTemplateColumns = columns;
        let imgArray = ["img/chemin.png", "img/herbe.png", "img/tour.png"];

        for (let x = 0 ; x < matrice.length ; x++){
            for (let y = 0 ; y < matrice[x].length ; y++){
                switch (matrice[x][y]){
                    case 0:
                        var img = document.createElement("img");
                        img.src = imgArray[0];
                        img.width = size;
                        img.height = size;
                        document.getElementById('board-container').appendChild(img);
                        break;
                    case 1:
                        var img = document.createElement("img");
                        img.src = imgArray[1];
                        img.width = size;
                        img.height = size;
                        document.getElementById('board-container').appendChild(img);

                        break;
                    case 2:
                        var img = document.createElement("img");
                        img.src = imgArray[2];
                        img.width = size;
                        img.height = size;
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