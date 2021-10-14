class Like {
  constructor() {
    this.events();
  }

  events() {
    jQuery(".like-box").on("click", this.ourClickDispatcher.bind(this));
  }

  ourClickDispatcher(e) {
    var likeBox = jQuery(e.target).closest(".like-box");
    if (likeBox.attr("data-exists") == "yes") {
      this.deleteLike(likeBox);
    } else {
      this.createLike(likeBox);
    }
  }

  createLike(likeBox) {
    jQuery.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      type: "POST",
      data: {
        professor_id: likeBox.data("professor"),
      },
      success: (response) => {
        console.log(response);
        likeBox.attr("data-exists", "yes");
        var likeCount = parseInt(likeBox.find(".like-count").html(), 10);
        likeCount++;
        likeBox.find(".like-count").html(likeCount);
        likeBox.attr("data-like", response);
      },
      error: (response) => {
        console.log(response);
      },
    });
  }

  deleteLike(likeBox) {
    jQuery.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: universityData.root_url + "/wp-json/university/v1/manageLike",
      data: {
        like: likeBox.attr("data-like"),
      },
      type: "DELETE",
      success: (response) => {
        console.log(response);

        likeBox.attr("data-exists", "no");
        var likeCount = parseInt(likeBox.find(".like-count").html(), 10);
        likeCount--;
        likeBox.find(".like-count").html(likeCount);
        likeBox.attr("data-like", "");
      },
      error: (response) => {
        console.log(response);
      },
    });
  }
}

export default Like;
