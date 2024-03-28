function callAppFunctions() {
  /**
   * Call this function from the Init file
   */
  rotateHeaderImage();
  rotateTheme();
  boxHover();
  onScrollNav();
}

function rotateHeaderImage() {
  /**
   * Using SetTimeout, change the header images
   */
}

function rotateTheme() {
  /**
   * Using setTimeout, rotate page theme
   */
}

function boxHover() {
  /**
   * Switches the Images on the right when hovered on
   */
}

function onScrollNav() {
  /**
   * Change Navigation color on scroll
   */
}

const text = ` <span>Save Yourself</span> Thousands With A Comprehensive <span>Vehicle</span> History Report`;

function typeWriterEffect(text, speed) {
  let i = 0;
  const container = document.getElementById("text-container");

  function type() {
    if (i < text.length) {
      container.innerText += text.charAt(i);
      i++;
      setTimeout(type, speed); // Call type() recursively with a delay
    }
  }

  type(); // Start typing
}

//typeWriterEffect(text, 100); // Adjust speed as needed
