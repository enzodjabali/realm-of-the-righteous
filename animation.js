class Monster{
    constructor(name, speed, life) {
        this.name = name;
        this.speed = speed
        this.life = life
        this.img = 'img/zombie.gif'
    }
    getName(){
        return this.name;
    }
    getSpeed(){
        return this.speed;
    }
    getLife(){
        return this.life;
    }
    displayMonster(){
        // const img = document.createElement("img");
        // img.setAttribute('src', `${this.img}`)
        // img.setAttribute('width', '100')
        // img.setAttribute('height', '100')
        // const position = document.getElementsByClassName('monster-container');
        // position.appendChild(img);
        // HERE --> display dynamically img
        var img = document.createElement('img');
        img.src = `/img/zombie.gif`;
        document.getElementById('monster-container').appendChild(img);
    }
    runMonster(){
    }
}
test = new Monster('Monster', 1, 1)
test.displayMonster();