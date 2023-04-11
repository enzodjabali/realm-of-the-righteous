export class Tower{
    constructor(towerId, damage, shotRate, position, towerLevel, path, pathWeapon, WeaponId) {
        this.id = towerId;
        this.WeaponId = WeaponId;
        this.damage = damage;
        this.shotRate = shotRate;
        this.towerLevel = towerLevel;
        this.level = 0;
        this.range = 2;
        this.position = position
        this.path = path;
        this.pathWeapon = pathWeapon;
    }
    getId(){
        return this.id;
    }
    getWeaponId(){
        console.log(this.WeaponId)
        return this.WeaponId;
    }
}