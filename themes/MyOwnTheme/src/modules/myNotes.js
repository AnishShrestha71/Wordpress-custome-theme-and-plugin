class myNotes {
  constructor() {
    this.events();
  }

  events() {
    jQuery("#my-notes").on("click", ".delete-note", this.deleteNote);
    jQuery("#my-notes").on("click", ".edit-note", this.editNote.bind(this));
    jQuery("#my-notes").on("click",".update-note", this.updateNote.bind(this));
    jQuery(".submit-note").on("click", this.createNote.bind(this));
  }

  deleteNote(e) {
    var noteID = jQuery(e.target).parents("li");

    jQuery.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url:
        "http://localhost/learn-wordpress/wp-json/wp/v2/note/" +
        noteID.data("id"),
      type: "DELETE",
      success: (Response) => {
        console.log("sucess");
        console.log(Response);
        noteID.slideUp();
      },
      error: (Response) => {
        console.log("error");
        console.log(Response);
      },
    });
  }

  editNote(e) {
    var noteID = jQuery(e.target).parents("li");
    if (noteID.data("state") == "editable") {
      this.makeNoteReadableOnly(noteID);
    } else {
      this.makeNoteEditable(noteID);
    }
  }

  makeNoteEditable(noteID) {
    noteID
      .find(".edit-note")
      .html('<i class="fa fa-times" aria-hidden="true">Cancel</i>');
    noteID
      .find(".note-title-field, .note-body-field")
      .removeAttr("readonly")
      .addClass("note-active-field");
    noteID.find(".update-note").addClass("update-note--visible");
    noteID.data("state", "editable");
  }

  makeNoteReadableOnly(noteID) {
    noteID
      .find(".edit-note")
      .html('<i class="fa fa-pencil" aria-hidden="true">Edit</i>');

    noteID
      .find(".note-title-field, .note-body-field")
      .attr("readonly", "readonly")
      .removeClass("note-active-field");

    noteID.find(".update-note").removeClass("update-note--visible");
    noteID.data("state", "cancel");
  }

  updateNote(e) {
    var noteID = jQuery(e.target).parents("li");
    var updatedPost = {
      title: noteID.find(".note-title-field").val(),
      content: noteID.find(".note-body-field").val(),
    };

    jQuery.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url:
        "http://localhost/learn-wordpress/wp-json/wp/v2/note/" +
        noteID.data("id"),
      type: "POST",
      data: updatedPost,
      success: (Response) => {
        console.log("sucess");
        console.log(Response);
        this.makeNoteReadableOnly(noteID);
      },
      error: (Response) => {
        console.log("error");
        console.log(Response);
      },
    });
  }

  createNote() {
    var createPost = {
      title: jQuery(".new-note-title").val(),
      content: jQuery(".new-note-body").val(),
      status: "publish",
    };
    jQuery.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
      },
      url: "http://localhost/learn-wordpress/wp-json/wp/v2/note/",
      type: "POST",
      data: createPost,
      success: (Response) => {
        console.log("sucess");
        console.log(Response);
        jQuery(".new-note-title, .new-note-body").val("");
        jQuery(`<li data-id="${Response.id}">
       
        <input readonly type="text" class="note-title-field" value="${Response.title.raw}">
        <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true">Edit</i></span>
        <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true">Delete</i></span>
        
        <textarea readonly name="" id="" class="note-body-field" cols="30" rows="10">${Response.content.raw}</textarea>
        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true">Save</i></span>
     </li>`)
          .prependTo("#my-notes")
          .hide()
          .slideDown();
      },
      error: (Response) => {
        console.log("error");
        console.log(Response);
      },
    });
  }
}

export default myNotes;
