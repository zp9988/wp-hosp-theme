import axios from 'axios';

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.addSearchHTML();
    this.resultsDiv = document.querySelector('#search-overlay__results');
    this.openButton = document.querySelectorAll('.js-search-trigger');
    this.closeButton = document.querySelector('.search-overlay__close');
    this.searchOverlay = document.querySelector('.search-overlay');
    this.searchField = document.querySelector('#search-term');
    this.isOverlayOpen = false;
    this.isSpinnerVisible = false;
    this.previousValue;
    this.typingTimer;
    this.events();
  }

  // 2. events
  events() {
    this.openButton.forEach((el) => {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        this.openOverlay();
      });
    });

    this.closeButton.addEventListener('click', () => this.closeOverlay());
    document.addEventListener('keydown', (e) => this.keyPressDispatcher(e));
    this.searchField.addEventListener('keyup', () => this.typingLogic());
  }

  // 3. methods (function, action...)
  typingLogic() {
    if (this.searchField.value != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.value) {
        if (!this.isSpinnerVisible) {
          this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>';
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        this.resultsDiv.innerHTML = '';
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = this.searchField.value;
  }

  async getResults() {
    try {
      const response = await axios.get(
        universityData.root_url +
          '/wp-json/heart/v1/search?term=' +
          this.searchField.value
      );
      const results = response.data;
      this.resultsDiv.innerHTML = `
        <div class="row">
          <div class="one-third">
            <h2 class="search-overlay__section-title">General Information</h2>
            ${
              results.generalInfo.length
                ? '<ul class="link-list min-list">'
                : '<p>No general information matches that search.</p>'
            }
              ${results.generalInfo
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a> ${
                      item.postType == 'post' ? `by ${item.authorName}` : ''
                    }</li>`
                )
                .join('')}
            ${results.generalInfo.length ? '</ul>' : ''}
          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Specialties</h2>
            ${
              results.specialties.length
                ? '<ul class="link-list min-list">'
                : `<p>No specialties match that search. <a href="${universityData.root_url}/specialties">View all specialties</a></p>`
            }
              ${results.specialties
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a></li>`
                )
                .join('')}
            ${results.specialties.length ? '</ul>' : ''}

            <h2 class="search-overlay__section-title">Doctors</h2>
            ${
              results.doctors.length
                ? '<ul class="u-cards">'
                : `<p>No doctors  match that search.</p>`
            }
              ${results.doctors
                .map(
                  (item) => `
                <li class="u-card__list-item">
                  <a class="u-card" href="${item.permalink}">
                    <img class="u-card__image" src="${item.image}">
                    <span class="u-card__name">${item.title}</span>
                  </a>
                </li>
              `
                )
                .join('')}
            ${results.doctors.length ? '</ul>' : ''}

          </div>
          <div class="one-third">
            <h2 class="search-overlay__section-title">Locations</h2>
            ${
              results.locations.length
                ? '<ul class="link-list min-list">'
                : `<p>No locations match that search. <a href="${universityData.root_url}/locations">View all locations</a></p>`
            }
              ${results.locations
                .map(
                  (item) =>
                    `<li><a href="${item.permalink}">${item.title}</a></li>`
                )
                .join('')}
            ${results.locations.length ? '</ul>' : ''}

            <h2 class="search-overlay__section-title">Events</h2>
            ${
              results.events.length
                ? ''
                : `<p>No events match that search. <a href="${universityData.root_url}/events">View all events</a></p>`
            }
              ${results.events
                .map(
                  (item) => `
                <div class="event-summary">
                  <a class="event-summary__date t-center" href="${item.permalink}">
                    <span class="event-summary__month">${item.month}</span>
                    <span class="event-summary__day">${item.day}</span>  
                  </a>
                  <div class="event-summary__content">
                    <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                    <p>${item.description} <a href="${item.permalink}" class="nu gray">Learn more</a></p>
                  </div>
                </div>
              `
                )
                .join('')}

          </div>
        </div>
      `;
      this.isSpinnerVisible = false;
    } catch (e) {
      console.log(e);
    }
  }

  keyPressDispatcher(e) {
    if (
      e.keyCode == 83 &&
      !this.isOverlayOpen &&
      document.activeElement.tagName != 'INPUT' &&
      document.activeElement.tagName != 'TEXTAREA'
    ) {
      this.openOverlay();
    }

    if (e.keyCode == 27 && this.isOverlayOpen) {
      this.closeOverlay();
    }
  }

  openOverlay() {
    this.searchOverlay.classList.add('search-overlay--active');
    document.body.classList.add('body-no-scroll');
    this.searchField.value = '';
    setTimeout(() => this.searchField.focus(), 301);
    console.log('our open method just ran!');
    this.isOverlayOpen = true;
    return false;
  }

  closeOverlay() {
    this.searchOverlay.classList.remove('search-overlay--active');
    document.body.classList.remove('body-no-scroll');
    console.log('our close method just ran!');
    this.isOverlayOpen = false;
  }

  addSearchHTML() {
    document.body.insertAdjacentHTML(
      'beforeend',
      `
      <div class="search-overlay">
        <div class="search-overlay__top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>
        </div>
        
        <div class="container">
          <div id="search-overlay__results"></div>
        </div>

      </div>
    `
    );
  }
}

export default Search;
