//Permit to store data of the game (Matrice, Enemies, Towers, Money, Life)
export class Model {
    constructor() {
        this.matrice =
            [[{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []},{tile: 0, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []}],
                [{tile: 2, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 1, enemies: []},{tile: 0, enemies: []},{tile: 1, enemies: []},{tile: 2, enemies: []},{tile: 2, enemies: []}],
            ]
        // [wave 0 --> [[quantity], [type]]]
        this.waves = [[[3,100],[0,110]]];
        this.enemiesToPlace = []; //List where enemy are waiting to be put in the matrice
        this.entryPoints = [0,0];
        this.endPoints = [4,5];

    }
    getMatrice(){
        return this.matrice;
    }
    
    updateMatrice(newMatrice){
        this.matrice = newMatrice;
    }

    addEnemy(enemy){
        this.enemiesToPlace.push(enemy);
    }
    getWaves(){
        return this.waves;
    }
    findPathForWaves(matrix, start, end){
        /*Cette fonction trouve un chemin pour les vagues sur une matrice, d'un point de départ donné à un point final.
        Il utilise un algorithme de recherche en largeur d'abord pour explorer les cellules voisines dans quatre directions: Nord, Est, Sud et Ouest.
        La fonction garde une trace des cellules visitées pour éviter les cycles et utilise une file d'attente pour maintenir l'ordre d'exploration.
        Si le point final est trouvé, la fonction génère une liste de mouvements à effectuer pour atteindre le point final.
        La fonction inclut également une fonction d'assistance "isVisited" pour vérifier si une cellule a déjà été visitée.

        Saisir:
        - matrice : un tableau 2D représentant la matrice
        - start : un tableau de deux entiers représentant le point de départ [x, y]
        - end : un tableau de deux entiers représentant le point final [x, y]

        Sortir:
        - moveToDo: un tableau de mouvements [dx, dy] à effectuer pour atteindre le point final à partir du point de départ,
        ou un tableau vide si aucun chemin n'est trouvé.*/
        const DIRECTIONTABLE = [[0, -1], [1, 0], [0, 1], [-1, 0]]; //North, East, South, West
        const visited = [];
        const movesToDo = [];
        const queue = [start];

        while (queue.length > 0){
            const current = queue.shift();
            const [x, y] = current;
            /*console.log('current');
            console.log(current);
            console.log(matrix[x][y].tile);*/
            visited.push(current)
            if (current[0] === end[0] && current[1] === end[1]) {
                console.log('end found')
                // for (var i = visited.length-1; i >= 1; i--) {
                //     const tempX = visited[i][0] - visited[i-1][0]
                //     const tempY = visited[i][1] - visited[i-1][1]
                //     /*console.log(tempX)
                //     console.log(tempY)*/
                //     movesToDo.push([tempX, tempY])
                // }
                //console.log(movesToDo)
                return visited;
            }
            for (const direction of DIRECTIONTABLE){
                const [dx, dy] = direction;
                const [nx, ny] = [x+dx, y+dy];

                if (nx < 0 || nx >= matrix.length || ny < 0 || ny >= matrix[0].length) {
                    continue;
                }

                if (matrix[nx][ny].tile == 1 && !isVisited([nx,ny], visited)) {
                    //console.log('[nx, ny]');
                    //console.log([nx, ny]);
                    queue.push([nx,ny]);
                }
            }
        }
        function isVisited(coord, visitedArray) {
            for (const visitedCoord of visitedArray) {
                if (visitedCoord[0] === coord[0] && visitedCoord[1] === coord[1]) {
                    return true;
                }
            }
            return false;
        }
    }

}