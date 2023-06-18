//Permit to store data of the game (Matrice, Enemies, Towers, Money, Life)
export class Model {
    /**
     * Construct a new Model.
     * @param {Object} fetchModel - The fetched model data.
     * @param {string} difficulty - The difficulty level.
     */
    constructor(fetchModel, difficulty) {
        this.matrice = fetchModel.matrice; // Store the matrix data
        this.waves = fetchModel.waves; // Store the waves data
        this.timeBetweenWaves = fetchModel.timeBetweenWaves; // Store the time between waves
        this.timeBetweenGroups = fetchModel.timeBetweenGroups; // Store the time between groups
        this.difficulty = difficulty; // Store the difficulty level
        this.timeBeforeStart = fetchModel.timeBeforeStart; // Store the time before the game starts
        this.currentWave = fetchModel.currentWave; // Store the current wave
        this.currentGroup = fetchModel.currentGroup; // Store the current group
        this.mobId = fetchModel.mobId; // Store the ID of the mobs
        this.towerId = fetchModel.towerId; // Store the ID of the towers
        this.towerWeaponId = fetchModel.towerWeaponId; // Store the ID of the tower weapons
        this.entryPoints = fetchModel.entryPoints; // Store the entry points
        this.endPoints = fetchModel.endPoints; // Store the end points

        // Check if in-game towers are present, if not, initialize an empty object
        fetchModel.inGameTowers ? (this.inGameTowers = fetchModel.inGameTowers) : (this.inGameTowers = {});

        // Check if default money player data is present, if not, use default values
        if (fetchModel.defaultMoneyPlayer) {
            this.defaultMoneyPlayer = fetchModel.defaultMoneyPlayer; // Store the default money player data
            this.defaultLifePlayer = fetchModel.defaultLifePlayer; // Store the default life player data
            this.killedEnemies = fetchModel.killedEnemies; // Store the number of killed enemies
        } else {
            this.defaultMoneyPlayer = {"easy": 500, "normal": 200, "hard": 100}; // Default money values based on difficulty
            this.defaultLifePlayer = {"easy": 150, "normal": 100, "hard": 50}; // Default life values based on difficulty
            this.killedEnemies = 0; // Initialize the number of killed enemies to 0
        }
    }

    /**
     * Get the matrice property.
     * @returns {Object} - The matrice property.
     */
    getMatrice(){
        return this.matrice;
    }

    /**
     * Update the matrice property with a new value.
     * @param {Object} newMatrice - The new matrice value to be set.
     */
    updateMatrice(newMatrice){
        this.matrice = newMatrice;
    }

    /**
     * Get the waves property.
     * @returns {Array} The waves array.
     */
    getWaves(){
        return this.waves;
    }

    /**
     * Calculate the heuristic cost between two coordinates using the Manhattan distance.
     * @param {Array} coord - The starting coordinate [x, y].
     * @param {Array} end - The target coordinate [x, y].
     * @returns {number} The heuristic cost between the coordinates.
     */
    heuristic(coord, end) {
      return Math.abs(coord[0] - end[0]) + Math.abs(coord[1] - end[1]);
    }

    /**
     * Check if two coordinates are equal.
     * @param {Array} coord1 - The first coordinate [x1, y1].
     * @param {Array} coord2 - The second coordinate [x2, y2].
     * @returns {boolean} True if the coordinates are equal, false otherwise.
     */
    coordEquals(coord1, coord2) {
      return coord1[0] === coord2[0] && coord1[1] === coord2[1];
    }

    /**
     * Convert a coordinate array to a string representation.
     * @param {Array} coord - The coordinate array [x, y].
     * @returns {string} The string representation of the coordinate.
     */
    coordToString(coord) {
      return coord.join(",");
    }

    /**
     * Find a path from the start coordinate to the endpoint coordinates using the A* algorithm.
     * @param {Array} matrix - The matrix representing the game map.
     * @param {Array} start - The start coordinate [x, y].
     * @param {Array} endpoints - An array of endpoint coordinates [[x1, y1], [x2, y2], ...].
     * @returns {Array} The list of moves to reach each endpoint, represented as an array of direction vectors [dx, dy].
     */
    findPathForWaves(matrix, start, endpoints) {
        for (let i = 0; i < endpoints.length; i++) {
            let end = [endpoints[i][0], endpoints[i][1]]
            const DIRECTIONTABLE = [[0, -1], [1, 0], [0, 1], [-1, 0]]; // North, East, South, West
            const openList = [];
            const gCosts = {};
            const fCosts = {};
            const movesToDo = [];
            const startNode = {coord: start, gCost: 0, fCost: 0 + this.heuristic(start, end), parent: null};
            let counterToStopFunction = 0; //BAPLEC SI TU PASSES PAR LA REGARDES BG
            let availableTiles = ['eastwest', 'forkeast', 'forknorth', 'forksouth', 'forwest', 'ne', 'northsouth', 'nw', 'rock', 'se', 'sw'];
            openList.push(startNode);
            gCosts[this.coordToString(start)] = 0;
            fCosts[this.coordToString(start)] = startNode.fCost;

            if (!availableTiles.includes(matrix[start[0]][start[1]].tile)) {
                console.log(start, ' n\'est pas un début')
                return [];
            }
            if (!availableTiles.includes(matrix[end[0]][end[1]].tile)) {
                console.log(end, ' n\'est pas une fin');
                return [];
            }

            while (openList.length > 0 && counterToStopFunction < 75) {
                openList.sort((a, b) => a.fCost - b.fCost);
                const currentNode = openList.shift();
                const {coord} = currentNode;
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
                    if (['eastwest', 'forkeast', 'forknorth', 'forksouth', 'forwest', 'ne', 'northsouth', 'nw', 'rock', 'se', 'sw'].includes(matrix[nx][ny].tile)) {
                        try {
                            if (matrix[nx][ny].tower.type == "rock") {
                                counterToStopFunction++
                            }
                        } catch (error) {
                            const tentativeGCost = currentNode.gCost + 1; // Cost of moving to the neighbor (always 1 in this example)
                            const neighborCoord = [nx, ny];
                            const neighborGCost = gCosts[this.coordToString(neighborCoord)] || Infinity;

                            if (tentativeGCost < neighborGCost) {
                                const neighborNode = openList.find(node => this.coordEquals(node.coord, neighborCoord)) ||
                                    {coord: neighborCoord, gCost: Infinity, fCost: Infinity, parent: null};
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
            }
        }
        return []
    }
}