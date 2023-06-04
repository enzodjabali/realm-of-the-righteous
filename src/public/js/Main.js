import {Controller} from "./Controller/Controller.js";

const gameId = new URLSearchParams(window.location.search).get('game_id');




function getGameMatrix() {
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
	let matrix = getGameMatrix()
    /*let player = getGamePlayer()
    let waves  = getGameWaves()*/

	/*console.log(matrix)
	console.log(player)
	console.log(waves)*/

	let controller = new Controller(matrix)
	/*let controller = new Controller(matrix)
	let controller = new Controller(matrix)*/

	
	const diffculty = 'medium';

	controller.setup();

	//Enemy
	controller.loop(diffculty);

	//Tower
	await new Promise(r => setTimeout(r, 2000));
	controller.HUDController.createTower();

}
main();