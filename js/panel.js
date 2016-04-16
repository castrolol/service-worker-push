(function (w) {

	function Panel() {
		this._marvelScore = document.querySelector("#marvel-score");
		this._dcScore = document.querySelector("#dc-score");
		this._container = document.querySelector("#container");

		this._itemTempate = document.querySelector(".template");

		this._scores = { dc: this._dcScore, marvel: this._marvelScore };
		this._itemClass = { marvel: "alert-danger", dc: "alert-info" };
		this._lastSearch = 0;
	}

	Panel.prototype.addPoint = function (name) {
        var cade = document.querySelector(".cade");
        if(cade) cade.style.display = "none";
        
		var hero = w.allHeroes.find(function (h) { return h.title.toLowerCase() == name.toLowerCase() });

		this._scores[hero.team].textContent = +(this._scores[hero.team].textContent) + 1;

		var alertElement = this._itemTempate.cloneNode(true);

		alertElement.classList.remove("template");
		alertElement.classList.add(this._itemClass[hero.team]);

		alertElement.querySelector("span").innerText = hero.title;
		alertElement.querySelector("img").src = "imgs/" + hero.img;

		this._container.insertBefore(alertElement, this._container.childNodes[0]);

	}


	Panel.prototype.init = function () {
		var addPoint = this.addPoint.bind(this);
		var container = this._container;
        document.body.classList.add("loading");

		fetch( location.protocol + "//castrolol.com/heroes-api/?from=0")
			.then(function(r){ 
				return r.json() 
			})
			.then(function(itens){ 
            
				itens.forEach(addPoint);	
				document.body.classList.remove("loading"); 
			})
			.catch(function () {
				console.log(arguments); 
				document.body.classList.remove("loading"); 
				})


	};



	w.panel = new Panel();

} (window));