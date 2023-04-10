export class Tower{
    constructor(towerId, damage, shotRate, position, towerLevel, path) {
        this.id = towerId;
        this.damage = damage;
        this.shotRate = shotRate;
        this.towerLevel = towerLevel;
        this.level = 0;
        this.range = 3;
        this.position = position
        this.path = path;
    }
    getId(){
        return this.id;
    }
}