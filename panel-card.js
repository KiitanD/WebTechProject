class PanelCard extends HTMLElement {
	constructor() {
		super();
	}

	connectedCallback() {
        
		if (!this.shadowRoot) {
		const shadow = this.attachShadow({ mode: "open" });
        }
		const card = document.createElement("div");
		card.setAttribute(
			"class",
			"panel-card inline-block p-5 border-2 border-pink-400 text-sm h-full w-full"
		);

		// const image = document.createElement("img");
		// image.setAttribute("class", "pb-5");
		// const src = this.getAttribute("img-src");

		// image.setAttribute("src", "src/" + src);

		const title = document.createElement("p");
		title.setAttribute(
			"class",
			"for-name text-center text-pink-400 text-lg"
		);
	    title.textContent = this.getAttribute("title");
        
        const time = document.createElement("p");
        time.setAttribute(
			"class",
			"for-time text-center"
		);
        time.textContent = this.getAttribute("time");

		const style = document.createElement("link");
		style.setAttribute("rel", "stylesheet");
		style.setAttribute("href", "./dist/output.css");

		// Attach the created elements to the shadow dom

		this.shadowRoot.appendChild(style);
		this.shadowRoot.appendChild(card);
		// card.appendChild(image);
		card.appendChild(title);
        card.appendChild(time);
		// card.appendChild(job);
		//card.appendChild(bio);

		this.shadowRoot.append(style, card);
	}
}

customElements.define("panel-card", PanelCard);
