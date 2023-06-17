import {Controller} from "./Controller/Controller.js";

const gameId = new URLSearchParams(window.location.search).get('gameId');




function getGameModel() {
	const request = new XMLHttpRequest();
	request.open('GET', '/api/v1/game/getModel?gameId='+gameId, false);  // `false` makes the request synchronous
	request.send(null);
	if (request.status === 200) {
		return JSON.parse(request.responseText);
	}
	return "";
}
function getGameDifficulty() {
	const request = new XMLHttpRequest();
	request.open('GET', ' /api/v1/game/getDifficulty?gameId='+gameId, false);  // `false` makes the request synchronous
	request.send(null);
	if (request.status === 200) {
		return JSON.parse(request.responseText).response;
	}
	return "";
}

async function main() {
	let model = getGameModel()
	let diff = getGameDifficulty()
	switch (diff){
		case 1:
			diff= "easy"
			break;
		case 2:
			diff = "normal";
			break;
		case 3:
			diff = "hard";
			break;
	}
	let controller = new Controller(model, diff)
	const difficulty = model.difficulty;

	controller.setup();

	//Enemy
	controller.loop(difficulty);

	//Tower
	controller.HUDController.createTowerButtons();
	controller.HUDController.boostTowers();

}
main();