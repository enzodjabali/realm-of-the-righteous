import {Controller} from "./Controller/Controller.js";
async function main(){
	let controller = new Controller()

	//diffculty = homepage()

	const diffculty = 'easy';

	controller.setup();
	controller.loop(diffculty);
	while(true){
		console.log('here')
		await new Promise(r => setTimeout(r, 2000));
		controller.HUDController.createTower();
	}
}
main();
