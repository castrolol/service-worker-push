window.heroData = {
	dc: [
		"Superman",
		"Batman",
		"Aquaman",
		"Flash",
		"Spiderman",
		"Wonder Woman"
	],
	marvel: [
		"Hulk",
		"Iron Man",
		"Deadpool",
		"Thor",
		"Wolwerine",
		"Capitao America"
	]
};


window.allHeroes = Object
	.keys(heroData)
	.map(function (team) {
		var teamHeros = heroData[team];
		return teamHeros.map(function (hero) {
			return { 
				img: team + " - " + hero.toLowerCase() + ".png", 
				team: team, 
				title: hero 
			};
		});
	}).reduce(function (agg, item) {
		item.forEach(function (i) { agg.push(i); });
		return agg;
	}, []);
		