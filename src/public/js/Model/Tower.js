export class Tower{
    constructor(towerId, damage, shotRate, position, towerLevel, path, pathWeapon,
                WeaponId, price, type, isAttackingAir, totalTowerFrames, totalAmmoFrames, totalImpactFrames, pathAmmo, pathImpact) {
        this.id = towerId; // The ID of the tower
        this.WeaponId = WeaponId; // The ID of the weapon used by the tower
        this.WeaponAngle = 0; // The angle of the weapon
        this.damage = damage; // The damage inflicted by the tower
        this.shotRate = shotRate; // The rate of fire of the tower
        this.towerLevel = towerLevel; // The level of the tower
        this.level = towerLevel; // The level of the tower (duplicate property)
        this.position = position; // The position of the tower
        this.pathWeapon = pathWeapon; // The path to the weapon sprite
        this.price = price; // The price of the tower
        this.type = type; // The type of the tower
        this.isAttackingAir = isAttackingAir; // Indicates if the tower can attack air units

        this.totalTowerFrames = totalTowerFrames; // The total number of frames for the tower sprite animation
        this.totalAmmoFrames = totalAmmoFrames; // The total number of frames for the ammo sprite animation
        this.totalImpactFrames = totalImpactFrames; // The total number of frames for the impact sprite animation

        this.currentTowerFrame = 0; // The current frame index for the tower sprite animation
        this.currentAmmoFrame = 0; // The current frame index for the ammo sprite animation
        this.currentImpactFrame = 0; // The current frame index for the impact sprite animation

        this.animateTowerSprite; // Unclear purpose or missing information about this property
        this.animateAmmoSprite; // Unclear purpose or missing information about this property
        this.animateImpactSprite; // Unclear purpose or missing information about this property

        this.animationTowerInterval; // The interval ID for the tower sprite animation
        this.animationAmmoInterval; // The interval ID for the ammo sprite animation
        this.animationImpactInterval; // The interval ID for the impact sprite animation

        this.remove = false; // Indicates if the tower should be removed
        this.path = path; // The path the tower follows
        this.pathAmmo = pathAmmo; // The path the ammo follows
        this.pathImpact = pathImpact; // The path the impact follows
        this.towerAmmoId = 0; // The ID of the tower ammo

        this.splashRange; // The range of the splash damage
        this.slowness; // The slowness effect on enemies
        this.rebound; // Indicates if the tower projectiles rebound
        this.buffTower; // Unclear purpose or missing information about this property
        this.buffedTower = []; // Array of towers buffed by this tower
        this.armorDamage; // The additional damage against armored enemies
        this.range; // The range of the tower
    }

    /**
     * Get the ID of the tower.
     * @returns {number} The tower ID.
     */
    getId(){
        return this.id;
    }

    /**
    * Get the weapon ID of the tower.
    * @returns {number} The weapon ID.
    */
    getWeaponId(){
        return this.WeaponId;
    }

    /**
    * Set the slowness value of the tower.
    * @param {number} slowness - The slowness value.
    */
    setSlowness(slowness){
        this.slowness = slowness;
    }

    /**
    * Set the rebound value of the tower.
    * @param {boolean} rebound - The rebound value.
    */
    setRebound(rebound){
        this.rebound = rebound;
    }

    /**
    * Set the splash range of the tower.
    * @param {number} splashRange - The splash range value.
    */
    setSplashRange(splashRange){
        this.splashRange = splashRange;
    }

    /**
    * Set the buff tower flag.
    * @param {boolean} buffTower - The buff tower flag.
    */
    setBuffTower(buffTower){
        this.buffTower = buffTower;
    }

    /**
    * Set the armor damage value.
    * @param {number} armorDamage - The armor damage value.
    */
    setArmorDamage(armorDamage){
        this.armorDamage = armorDamage;
    }

    /**
    * Set the range value.
    * @param {number} range - The range value.
    */
    setRange(range){
        this.range = range;
    }
}
