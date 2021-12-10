

class SpeakerCard extends HTMLElement {
  constructor() {
    
    super(); 
  }
  
    connectedCallback() {
    const shadow = this.attachShadow({mode: 'open'});

    const card = document.createElement('div');
    card.setAttribute('class', 'speaker-card inline-block p-5 border-2 border-purple-400 text-sm h-full');


    const image = document.createElement('img');
    image.setAttribute('class', 'pb-5');
    const src = this.getAttribute('img-src');

    image.setAttribute('src', 'src/'+src);

    const name = document.createElement('p');
    name.setAttribute('class', 'for-name text-center text-purple-400 text-lg');
    name.textContent = this.getAttribute("name");


    const job = document.createElement('p');
    job.setAttribute('class', 'for-job text-center');
    job.innerText = this.getAttribute('job');

    const bio = document.createElement('p');
    bio.textContent = this.getAttribute('bio');
    bio.setAttribute('class', 'for-bio');
    
    const style = document.createElement('link');
    style.setAttribute('rel', 'stylesheet');
    style.setAttribute('href', './dist/output.css');

// Attach the created elements to the shadow dom

    shadow.appendChild(style);
    shadow.appendChild(card);
    card.appendChild(image);
    card.appendChild(name);
    card.appendChild(job);
    //card.appendChild(bio);

    this.shadowRoot.append(style, card);
  }
  
}

customElements.define('speaker-card', SpeakerCard);
