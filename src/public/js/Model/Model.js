//Permit to store data of the game (Matrice, Enemies, Towers, Money, Life)
export class Model {
    constructor(fetchModel) {
        this.matrice = fetchModel.matrice,
        this.waves = fetchModel.waves,
        this.timeBetweenWaves = fetchModel.timeBetweenWaves,
        this.timeBetweenGroups = fetchModel.timeBetweenGroups,
        this.difficulty = fetchModel.difficulty,
        this.timeBeforeStart = fetchModel.timeBeforeStart,
        this.currentWave = fetchModel.currentWave,
        this.currentGroup = fetchModel.currentGroup,
        this.mobId = fetchModel.mobId,
        this.towerId = fetchModel.towerId,
        this.towerWeaponId = fetchModel.towerWeaponId,
        this.entryPoints = fetchModel.entryPoints,
        this.endPoints = fetchModel.endPoints
    }
    
    getMatrice(){
        return this.matrice;
    }
    
    updateMatrice(newMatrice){
        this.matrice = newMatrice;
    }
    getWaves(){
        return this.waves;
    }

    // Define a function for the heuristic (H) cost
    heuristic(coord, end) {
      // In this example, we use the Manhattan distance as the heuristic
      return Math.abs(coord[0] - end[0]) + Math.abs(coord[1] - end[1]);
    }

    // Define a function to check if two coordinates are equal
    coordEquals(coord1, coord2) {
      return coord1[0] === coord2[0] && coord1[1] === coord2[1];
    }

    // Define a function to convert a coordinate to a string for use as a key in a map
    coordToString(coord) {
      return coord.join(",");
    }

    // Define the A* algorithm function
    findPathForWaves(matrix, start, end) {
        const DIRECTIONTABLE = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
        const openList = [];
        const gCosts = {};
        const fCosts = {};
        const movesToDo = [];
        const startNode = { coord: start, gCost: 0, fCost: 0 + this.heuristic(start, end), parent: null };
        openList.push(startNode);
        gCosts[this.coordToString(start)] = 0;
        fCosts[this.coordToString(start)] = startNode.fCost;

        if(matrix[start[0]][start[1]].tile != 'basepath'){
            console.log(start, ' n\'est pas un début')
            return 0;
        }
        if(matrix[end[0]][end[1]].tile != 'basepath'){
            console.log(start, ' n\'est pas une fin')
            return 0;
        }


      while (openList.length > 0) {
        openList.sort((a, b) => a.fCost - b.fCost);
        //console.log(openList)
        const currentNode = openList.shift();
        const { coord } = currentNode;
        //console.log(coord)
        if (this.coordEquals(coord, end)) {
          // Path found, generate list of moves
          let current = currentNode;
          while (current.parent) {
            const dx = current.coord[0] - current.parent.coord[0];
            const dy = current.coord[1] - current.parent.coord[1];
            movesToDo.unshift([dx, dy]);
            current = current.parent;
          }
          return movesToDo;
        }

        for (const direction of DIRECTIONTABLE) {
          const [dx, dy] = direction;
          const nx = coord[0] + dx;
          const ny = coord[1] + dy;

          if (nx < 0 || nx >= matrix.length || ny < 0 || ny >= matrix[0].length) {
            continue;
          }
          if (matrix[nx][ny].tile == 'basepath') {
            const tentativeGCost = currentNode.gCost + 1; // Cost of moving to the neighbor (always 1 in this example)
            const neighborCoord = [nx, ny];
            const neighborGCost = gCosts[this.coordToString(neighborCoord)] || Infinity;

            if (tentativeGCost < neighborGCost) {
              const neighborNode = openList.find(node => this.coordEquals(node.coord, neighborCoord)) ||
                { coord: neighborCoord, gCost: Infinity, fCost: Infinity, parent: null };
              neighborNode.gCost = tentativeGCost;
              neighborNode.fCost = tentativeGCost + this.heuristic(neighborCoord, end);
              neighborNode.parent = currentNode;

              if (!openList.some(node => this.coordEquals(node.coord, neighborCoord))) {
                openList.push(neighborNode);
              }
            }
          }
        }
      }

      // No path found
      console.log('loooser')
      return [];
    }
}