let pres_list;

class PanelModal extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		if (!this.shadowRoot) {
			const shadow = this.attachShadow({ mode: "open" });
            
			const card = document.createElement("div");
			card.setAttribute(
				"class",
				"modal h-2/3 w-1/2 border-pink-600"
			);
			// const modal_grid = document.createElement("div");
			// modal_grid.setAttribute("class", "columns-2 h-full w-full z-30");
			// const image = document.createElement("img");
			// image.setAttribute("class", "h-full");
			// const src = this.getAttribute("img-src");
			// image.setAttribute("src", "src/" + src);
			// const text = document.createElement("div");
			// text.setAttribute(
			// 	"class",
			// 	"h-full flex flex-col justify-center items-center"
			// );

			const title = document.createElement("p");
			title.setAttribute("class", "text-center text-lg text-pink-400");
			title.innerText = this.getAttribute("title");


			const time = document.createElement("p");
			time.setAttribute("class", "for-time text-center");
			time.innerText = this.getAttribute("time");

			const speaker_list = document.createElement("p");
			speaker_list.setAttribute("class", "py-5");
			speaker_list.innerHTML =
				'<hr class = "text-pink-400"></hr>' +
				this.getAttribute("speakers") +
				'<hr class = "text-pink-400"></hr>';

			const description = document.createElement("p");
			//bio.setAttribute('class', 'self-center')
			description.innerText = this.getAttribute("description");

			const style = document.createElement("link");
			style.setAttribute("rel", "stylesheet");
			style.setAttribute("href", "./dist/output.css");

			// Attach the created elements to the shadow dom

			// shadow.appendChild(style);
			// shadow.appendChild(card);
			// card.appendChild(modal_grid);
			// modal_grid.appendChild(image);
			// modal_grid.appendChild(text);
			card.appendChild(title);
            card.appendChild(time);
            card.appendChild(speaker_list);
			card.appendChild(description);
			
			// card.appendChild(bio);

			this.shadowRoot.append(style, card);
		}
	}
}

customElements.define("panel-modal", PanelModal);
