import {Controller} from "./Controller/Controller.js";
async function main(){
	let controller = new Controller()

	//diffculty = homepage()

	const diffculty = 'easy';

	controller.setup();
	controller.loop(diffculty);
	while(true){
		await new Promise(r => setTimeout(r, 300)); // Delay 500ms between each enemy's movement for smoother animation
                    
		console.log('test loop');
	}
}
main();
