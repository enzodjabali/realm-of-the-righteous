import {Controller} from "./Controller/Controller.js";
async function main(){
	let controller = new Controller()

	//diffculty = homepage()

	const diffculty = 'easy';

	controller.setup();

	//Enemy
	controller.loop(diffculty);

	//Tower
	await new Promise(r => setTimeout(r, 2000));
	controller.HUDController.createTower();
	controller.towerLoop();

}
main();
