import {Controller} from "./Controller/Controller.js";
async function main(){
	let controller = new Controller()

	//diffculty = homepage()

	const diffculty = 'easy';

	controller.setup();
	controller.loop(diffculty);
}
main();
