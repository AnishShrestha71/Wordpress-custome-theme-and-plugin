wp.blocks.registerBlockType("anish/border-box", {
  title: "My cool border box",
  icon: "smiley",
  category: "widgets",
  attributes: {
    content: {
      type: "string",
    },
    color: {
      type: "string",
    },
  },
  edit: function (props) {
    function updateContent(event) {
      props.setAttributes({ content: event.target.value });
    }

    function updateColor(value) {
      props.setAttributes({ color: value.hex });
    }
    return wp.element.createElement(
      "div",
      null,
      wp.element.createElement("h3", null, "Your Cool Border Box"),
      wp.element.createElement("input", {
        type: "text",
        value: props.attributes.content,
        onChange: updateContent,
      }),
      wp.element.createElement(wp.components.ColorPicker, {
        color: props.attributes.color,
        onChangeComplete: updateColor,
      })
    );
  },
  save: function (props) {
    return wp.element.createElement(
      "h3",
      { style: { border: "5px solid " + props.attributes.color } },
      props.attributes.content
    );
  },
});
/* To make your block "dynamic" uncomment
  the code below and in your JS have your "save"
  method return null
*/

/*
function borderBoxOutput($props) {
  return '<h3 style="border: 5px solid' . $props['color'] . '">' . $props['content'] . '</h3>';
}

register_block_type( 'brad/border-box', array(
  'render_callback' => 'borderBoxOutput',
) );
*/