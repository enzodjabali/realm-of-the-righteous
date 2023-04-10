export class Tower{
    constructor(towerId, damage, position, towerLevel = 0, path = '../../assets/images/towers/BT1.png') {
        this.id = towerId;
        this.damage = damage;
        this.towerLevel = towerLevel;
        this.range = 3;
        this.position = position
        this.path = path;
    }
    getId(){
        return this.id;
    }
}