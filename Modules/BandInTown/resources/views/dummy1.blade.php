
(() => {
    window.mainScript = document.querySelector('#BandInTownScript');
    window.colors = {
        font: mainScript.getAttribute('data-font') ?? null,
        primary: mainScript.getAttribute('data-primary') ?? null,
        secondary: mainScript.getAttribute('data-secondary') ?? null,
    };
    window.artistInfo = {
        locationId: mainScript.getAttribute('data-locationId') ?? null,
        artist_id: mainScript.getAttribute('data-artist_id') ?? null,
        artist_name: mainScript.getAttribute('data-artist_name') ?? null,
    }
    if (window.artistInfo.artist_id && window.artistInfo.artist_name) {
        return;
    }
    if (!document.querySelector('#bandintown_css')) {
        document.head.insertAdjacentHTML('beforeend', `<style id="bandintown_css">
@import url("https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");

#custom-event-container {
  color: #fff;
  width: 100%;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-size: 62.5%;
  font-family: "Roboto Condensed", sans-serif;
}

.custom-event {
  display: flex;
  align-items: center;
  background-color: #2A2E35;
  padding: 1.5rem 1rem;
  margin: 2rem auto 1rem auto;
  border-radius: 1.5rem;
}

.custom-heading {
  width: 80%;
  font-size: 4rem;
  padding: 2rem 0;
  margin: 0 auto;
}

.custom-date {
  color: #FF6520;
  width: 10%;
  text-align: center;
}

.custom-day {
  font-size: 2rem;
  padding: 0;
  margin: 0;
}

.custom-month {
  text-transform: uppercase;
  font-size: 1rem;
  padding: 0;
  margin: 0;
}

.custom-venue {
  text-transform: uppercase;
  width: 60%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.custom-venue-name {
  font-size: 2rem;
}

.custom-venue-location {
  font-size: 1.5rem;
  font-weight: 400;
}

.custom-btns {
  width: 30%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
}

.custom-tickets,
.custom-rsvp {
  font-size: 1.5rem;
  font-weight: 400;
  padding: 1rem 2rem;
  border-radius: 2rem;
  outline: none;
}

.custom-tickets {
  background-color: #FF6520;
  color: #fff;
  border: none;
  text-decoration: none;
}

.custom-rsvp {
  color: #FF6520;
  background-color: transparent;
  border: 2px solid #FF6520;
  text-decoration: none;
}

.no-shows {
  text-align: center;
  font-size: 2rem;
  margin: 0 auto;
}

@media (max-width: 480px) {
  .custom-event {
    flex-direction: column;
    padding: .6rem .2rem;
    margin-bottom: 1rem;
  }

  .custom-heading {
    font-size: 1.5rem;
    padding: 1.5rem 0;
  }

  .custom-date {
    width: 100%;
  }

  .custom-day {
    font-size: .8rem;
  }

  .custom-month {
    font-size: .4rem;
  }

  .custom-venue {
    width: 100%;
    flex-direction: column;
    margin: .5rem 0;
  }

  .custom-venue-name {
    font-size: 1rem;
    margin-bottom: 2px;
  }

  .custom-venue-location {
    font-size: .8rem;
    margin-top: 2px;
  }

  .custom-btns {
    width: 100%;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: .3rem;
  }

  .custom-tickets,
  .custom-rsvp {
    width: 30%;
    text-align: center;
    font-size: .5rem;
    padding: .3rem .8rem;
  }

  .no-shows {
    text-align: center;
    font-size: 1.2rem;
  }
}

@media (min-width: 481px) and (max-width: 767px) {
  .custom-event {
    padding: 1rem .6rem;
  }

  .custom-heading {
    font-size: 2rem;
  }

  .custom-day {
    font-size: 1rem;
  }

  .custom-month {
    font-size: .4rem;
  }

  .custom-venue-name {
    font-size: .8rem;
  }

  .custom-venue-location {
    font-size: .6rem;
  }

  .custom-tickets,
  .custom-rsvp {
    font-size: .4rem;
    padding: .3rem .8rem;
  }
}

@media (min-width: 768px) and (max-width: 1024px) {
  .custom-event {
    padding: 1.2rem .8rem;
    margin: 2rem auto;
  }

  .custom-heading {
    font-size: 2rem;
  }

  .custom-day {
    font-size: 1.3rem;
  }

  .custom-month {
    font-size: .6rem;
  }

  .custom-venue-name {
    font-size: 1.3rem;
  }

  .custom-venue-location {
    font-size: 1rem;
  }

  .custom-tickets,
  .custom-rsvp {
    font-size: .8rem;
    padding: .5rem 1rem;
  }
}

@media (min-width: 1025px) and (max-width: 1280px) {
  .custom-heading {
    font-size: 3rem;
  }

  .custom-day {
    font-size: 1.7rem;
  }

  .custom-month {
    font-size: .8rem;
  }

  .custom-venue-name {
    font-size: 1.7rem;
  }

  .custom-venue-location {
    font-size: 1.3rem;
  }

  .custom-tickets,
  .custom-rsvp {
    font-size: 1rem;
    padding: .8rem 1.7rem;
  }
}
</style>
`);

    }

    window.customEventHTMLs = document.querySelectorAll("#custom-event-container");

    function addEvent(date, month, venue_name, venue_location, ticket_link, rsvp_link) {
        return `
  <div class="custom-event">
      <div class="custom-date custom-orange">
          <h2 class="custom-day">${date}</h2>
          <h2 class="custom-month">${month}</h2>
      </div>
      <div class="custom-venue">
          <h2 class="custom-venue-name custom-white">${venue_name}</h2>
          <h4 class="custom-venue-location custom-white">${venue_location}</h4>
      </div>
      <div class="custom-btns">
          <a target="_blank" href=${ticket_link} class="custom-tickets custom-white">TICKETS</a>
          <a target="_blank" href=${rsvp_link} class="custom-rsvp custom-orange">RSVP</a>
      </div>
  </div>`
    }

    function addNoEvents() {
        return `
  <div class="custom-event">
      <h2 class="no-shows">No Upcoming Shows</h2>
  </div>`
    }

    function changeColor(elem, hex, type = 'color') {
        try {

            elem.forEach(t => {
                elem.style[type] = hex;
            })

        } catch (error) {

        }
    }




    function changeColors(hasEvents) {
        const {
            font,
            primary,
            secondary
        } = window.colors;
        let customEvent = document.querySelectorAll(".custom-event");
        let customTicket = document.querySelectorAll(".custom-tickets");
        let customDate = document.querySelectorAll(".custom-date");
        let customRSVP = document.querySelectorAll(".custom-rsvp");
        if (hasEvents) {
            if (font) {
                changeColor(customEvent, font);
                changeColor(customTicket, font);
            }
            if (primary) {
                changeColor(customEvent, primary, 'backgroundColor');
            }
            if (secondary) {
                changeColor(customDate, secondary);
                changeColor(customTicket, secondary, 'backgroundColor');
                changeColor(customRSVP, secondary);
                changeColor(customRSVP, secondary, 'borderColor');
            }
        } else {
            if (font) {
                changeColor(customEvent, font);
            }
            if (primary) {
                changeColor(customEvent, primary, 'backgroundColor');
            }
        }
    }

    if (!(window.fetchingBandRecord ?? false)) {
        window.fetchingBandRecord = true;
        fetch(`https://bit.leadflowy.com/events/RNhRZrLskX8Dbu0QAUxy`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(window.artistInfo)
        }).then(resp => resp.json()).then(data => {
            let eventHTML = '';
            if (data.events.length > 0) {
                for (item of data.events) {
                    const match = item.date.split(" ");
                    const date = match[0];
                    const month = match[1];
                    const venue_name = item.venue_name;
                    const venue_location = item.venue_location;
                    const ticket_link = item.ticket_url;
                    const rsvp_link = item.rsvp_url;
                    eventHTML += addEvent(date, month, venue_name, venue_location, ticket_link,
                        rsvp_link);
                }
            } else {
                eventHTML = addNoEvents();
            }
            customEventHTMLs.forEach(t => {
                t.innerHTML = eventHTML;
            })
            changeColors(data.events.length);
        }).catch(err => console.log(err));
    }
})()
