import {Controller} from "./Controller/Controller.js";

const gameId = new URLSearchParams(window.location.search).get('game_id');




function getGameModel() {
	const request = new XMLHttpRequest();
	request.open('GET', '/api/GetGameMatrix.php?gameId='+gameId, false);  // `false` makes the request synchronous
	request.send(null);

	if (request.status === 200) {
		return JSON.parse(request.responseText);
	}
	return "";
}

/*function getGameWaves() {
	const request = new XMLHttpRequest();
	request.open('GET', '/api/GetGameMatrix.php?gameId=' + gameId, false);  // `false` makes the request synchronous
	request.send(null);

	if (request.status === 200) {
		return JSON.parse(request.responseText);
	}
	return "";
}

function getGamePlayer() {
	const request = new XMLHttpRequest();
	request.open('GET', '/api/GetGameMatrix.php?gameId=' + gameId, false);  // `false` makes the request synchronous
	request.send(null);

	if (request.status === 200) {
		return JSON.parse(request.responseText);
	}
	return "";
}*/

async function main() {
	let model = getGameModel()
    /*let player = getGamePlayer()
    let waves  = getGameWaves()*/

	/*console.log(matrix)
	console.log(player)
	console.log(waves)*/
	let controller = new Controller(model)
	/*let controller = new Controller(matrix)
	let controller = new Controller(matrix)*/

	
	const diffculty = model.difficulty;

	controller.setup();

	//Enemy
	controller.loop(diffculty);

	//Tower
	controller.HUDController.createTower();

}
main();