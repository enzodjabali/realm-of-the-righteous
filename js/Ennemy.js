class Ennemy{
    constructor(name, speed, life, position) {
        this.name = name;
        this.speed = speed
        this.life = life
        this.img = 'img/zombie.gif'
        this.position = {x: 0, y: 0}
    }
    setName(name){
        this.name = name;
    }
    setSpeed(speed){
        this.speed = speed;
    }
    setLife(life){
        this.life = life;
    }
    setPosition(position){
        this.position = position;
    }

}