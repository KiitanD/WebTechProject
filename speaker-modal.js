let pres_list;

class SpeakerModal extends HTMLElement {
	constructor() {
		super();
	}
	connectedCallback() {
		if (!this.shadowRoot) {
			const shadow = this.attachShadow({ mode: "open" });
			const card = document.createElement("div");
			card.setAttribute(
				"class",
				"modal h-500 w-800 border-purple-600"
			);
			const modal_grid = document.createElement("div");
			modal_grid.setAttribute("class", "columns-2 h-full w-full z-30");
			const image = document.createElement("img");
			image.setAttribute("class", "h-full");
			const src = this.getAttribute("img-src");
			image.setAttribute("src", "src/" + src);
			const text = document.createElement("div");
			text.setAttribute(
				"class",
				"h-full flex flex-col justify-center items-center"
			);

			const name = document.createElement("p");
			name.setAttribute("class", "text-center text-lg text-purple-400");
			const namelabel = this.getAttribute("name");
			name.innerText = namelabel;

			const job = document.createElement("p");
			job.setAttribute("class", "text-base text-center");
			job.innerText = this.getAttribute("job");

			const pres_list = document.createElement("p");
			pres_list.setAttribute("class", "py-5");
			pres_list.innerHTML =
				'<hr class = "text-purple-400"></hr>' +
				this.getAttribute("pres") +
				'<hr class = "text-purple-400"></hr>';

			const bio = document.createElement("p");
			//bio.setAttribute('class', 'self-center')
			bio.innerText = this.getAttribute("bio");

			const style = document.createElement("link");
			style.setAttribute("rel", "stylesheet");
			style.setAttribute("href", "./dist/output.css");

			// Attach the created elements to the shadow dom

			// shadow.appendChild(style);
			// shadow.appendChild(card);
			card.appendChild(modal_grid);
			modal_grid.appendChild(image);
			modal_grid.appendChild(text);
			text.appendChild(name);
			text.appendChild(job);
			text.appendChild(pres_list);
			text.appendChild(bio);

			this.shadowRoot.append(style, card);
		}
	}
}

customElements.define("speaker-modal", SpeakerModal);
