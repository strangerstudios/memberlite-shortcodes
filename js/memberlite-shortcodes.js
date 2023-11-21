jQuery(document).ready(function () {
  // Show accordion content when clicked
  jQuery(".container").click(function (e) {
    var accordion_trigger, accordion;
    accordion_trigger = jQuery(this);
    accordion = accordion_trigger.closest(".memberlite_accordion-item");
    // Toggle the clicked item
    accordion.find(".memberlite_accordion-item-content").slideToggle(350);
    accordion.toggleClass("memberlite_accordion-active");
    accordion.find(".icon-container").toggleClass("active");
  });
  if (jQuery(".memberlite_accordion-item").length > 0) {
    // Accordion is on this page
    var accordion_id = location.hash;
    if (accordion_id !== "") {
      // Open an accordion
      jQuery(accordion_id + " h2").click();
    }
  }
});
