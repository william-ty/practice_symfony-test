/*Custom Cursor*/
window.addEventListener('mousemove', cursor);

function cursor(e) {
  let mouseCursor = document.querySelector(".cursor");

  mouseCursor.style.top = e.pageY + "px";
  mouseCursor.style.left = e.pageX + "px";
}