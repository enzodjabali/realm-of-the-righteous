export class Tower{
    constructor(towerId, damage, shotRate, position, towerLevel, path, pathWeapon, WeaponId, price, type, isAttackingAir, totalFrames, rebound = null, slowness = null) {
        this.id = towerId;
        this.WeaponId = WeaponId;
        this.WeaponAngle = 0;
        this.damage = damage;
        this.shotRate = shotRate;
        this.towerLevel = towerLevel;
        this.level = 0;
        this.range = 5;
        this.position = position
        this.path = path;
        this.pathWeapon = pathWeapon;
        this.price = price;
        this.type = type;
        this.isAttackingAir = isAttackingAir;
        this.rebound = rebound;
        this.slowness = slowness;
        this.totalFrames = totalFrames;
        this.currentFrame = 1;
        this.animateSprite;
        this.animationInterval;
        this.remove = false;
    }
    getId(){
        return this.id;
    }
    getWeaponId(){
        return this.WeaponId;
    }
}