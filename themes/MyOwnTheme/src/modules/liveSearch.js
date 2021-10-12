class Search {
  constructor() {
    this.openButton = jQuery(".js-search-trigger");
    this.closeButton = jQuery(".search-overlay__close");
    this.searchOverlay = jQuery(".search-overlay");
    this.searchField = jQuery("#search-term");
    this.events();
    this.typingTimer;
    this.results = jQuery(".search-overlay__resilts");
    this.isSpinnerVisible = false;
    this.previousValue;
  }

  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverlay.bind(this));
    this.searchField.on("keyup", this.typingLogic.bind(this));
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    console.log("hello");
    jQuery("body").addClass("body-no-scroll");
  }

  closeOverlay() {
    this.searchOverlay.removeClass("search-overlay--active");
    jQuery("body").removeClass("body-no-scroll");
  }

  typingLogic() {
    if (this.searchField.val() != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (this.searchField.val()) {
        if (!this.isSpinnerVisible) {
          this.results.html('<div class="spinner-loader"></div>');
          this.isSpinnerVisible = true;
        }
        this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
      } else {
        this.results.html("");
        this.isSpinnerVisible = false;
      }
    }
    this.previousValue = this.searchField.val();
  }

  getResults() {
    var term = this.searchField.val();

    jQuery.getJSON(`http://localhost/learn-wordpress/wp-json/university/v1/search?term=` + term , (results) => {
      this.results.html(`
        <div class="row"> 
        <div class="one-third">
            <h2 class="earch-overlay__section-title" >general Information</h2>
            ${
              results.generalInfo.length
                ? `<ul class="link-list min-list">`
                : `<p>no results</p>`
            }
             ${results.generalInfo
               .map(
                 (item) =>
                   `<li><a href="${item.permalink}">${item.title} ${
                     item.post_type == "post" ? `by ${item.authorName} ` : ""
                   }</a></li>`
               )
               .join("")}
            </ul>
            </div>
        <div class="one-third">
          <h2 class="earch-overlay__section-title" >Programs</h2>
          ${
            results.programs.length
              ? `<ul class="link-list min-list">`
              : `<p>no results</p>`
          }
           ${results.programs
             .map(
               (item) =>
                 `<li><a href="${item.permalink}">${item.title} ${
                   item.post_type == "post" ? `by ${item.authorName} ` : ""
                 }</a></li>`
             )
             .join("")}
          </ul>
        </div>
        <div class="one-third">
          <h2 class="earch-overlay__section-title" >Professors</h2>
          ${
            results.professor.length
              ? `<ul class="link-list min-list">`
              : `<p>no results</p>`
          }
           ${results.professor
             .map(
               (item) =>
                 `<li><a href="${item.permalink}">${item.title} </a></li>`
             )
             .join("")}
          </ul>
          </div>
        <div class="one-third">
          <h2 class="earch-overlay__section-title" >Events</h2>
          ${
            results.events.length
              ? `<ul class="link-list min-list">`
              : `<p>no results</p>`
          }
           ${results.events
             .map(
               (item) =>
                 `<li><a href="${item.permalink}">${item.title +' ' + item.month +' ' + item.day +' ' + item.description} </a></li>`
             )
             .join("")}
          </ul>
        </div>
        </div>
      `);
    });


//     jQuery
//       .when(
//         jQuery.getJSON(
//           `http://localhost/learn-wordpress/wp-json/wp/v2/posts?search=` + term
//         ),
//         jQuery.getJSON(
//           `http://localhost/learn-wordpress/wp-json/wp/v2/pages?search=` + term
//         )
//       )
//       .then(
//         (posts, pages) => {
//           var combineResults = posts[0].concat(pages[0]);
//           this.results
//             .html(`<h2 class="search-overlay__section-title">general information</h2>
// ${
//   combineResults.length
//     ? `<ul class="link-list min-list">`
//     : `<p>no results</p>`
// }
//  ${combineResults
//    .map(
//      (item) =>
//        `<li><a href="${item.link}">${item.title.rendered} ${
//          item.type == "post" ? `by ${item.authorName} ` : ""
//        }</a></li>`
//    )
//    .join("")}
// </ul>`);
//         },
//         () => {
//           this.results.html(`<p>unexpected error try again !!</p>`);
//         }
//       );

    // jQuery.getJSON(
    //   `http://localhost/learn-wordpress/wp-json/wp/v2/posts?search=` + term,
    //   (posts) => {
    //     jQuery.getJSON(
    //       `http://localhost/learn-wordpress/wp-json/wp/v2/pages?search=` + term,
    //       (pages) => {
    //         var combineResults = posts.concat(pages);
    //         this.results
    //           .html(`<h2 class="search-overlay__section-title">general information</h2>
    //   ${
    //     combineResults.length
    //       ? `<ul class="link-list min-list">`
    //       : `<p>no results</p>`
    //   }
    //    ${combineResults
    //      .map(
    //        (item) =>
    //          `<li><a href="${item.link}">${item.title.rendered}</a></li>`
    //      )
    //      .join("")}
    //   </ul>`);
    //       }
    //     );
    //   }
    // );

    this.isSpinnerVisible = false;
  }
}

export default Search;
