/**
 * Represents a player in the game.
 */
export class Player {
    /**
     * Create a new Player.
     * @param {number} money - The amount of money the player has.
     * @param {number} life - The player's life points.
     * @param {number} killedEnemies - The number of enemies killed by the player.
     * @param {datetime} tab - Store datetime for showRange
     */
    constructor(money, life, killedEnemies) {
        this.tab;
        this.money = money;
        this.life = life;
        this.killedEnemies = killedEnemies;
    }
}
