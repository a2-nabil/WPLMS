document.addEventListener("DOMContentLoaded", function () {
  // sidebar js here
  window.addEventListener("scroll", function () {
    if (window.innerWidth > 767) {
      const courseSidebar = document.querySelector(".a2n-course_sidebar");
      const scrollTop =
        window.pageYOffset || document.documentElement.scrollTop;
      const parentDiv = document.querySelector(".a2n-tabs_area__container");
      const parentDivBottom = parentDiv.offsetTop + parentDiv.offsetHeight;

      if (
        scrollTop > 100 &&
        scrollTop < parentDivBottom - courseSidebar.offsetHeight
      ) {
        const parentDivTop = parentDiv.offsetTop;
        const sidebarTop = scrollTop - parentDivTop + "px";
        courseSidebar.style.position = "absolute";
        courseSidebar.style.top = sidebarTop;
        courseSidebar.style.marginTop = "90px";
      } else if (scrollTop >= parentDivBottom - courseSidebar.offsetHeight) {
        courseSidebar.style.position = "relative";
        courseSidebar.style.top =
          parentDiv.offsetHeight - courseSidebar.offsetHeight + "px";
          courseSidebar.style.marginTop = "0";
      } else {
        courseSidebar.style.position = "static";
        courseSidebar.style.marginTop = "-265px";
      }
    } else {
      const courseSidebar = document.querySelector(".a2n-course_sidebar");
      courseSidebar.removeAttribute("style");
    }
  });

  // common functions for tab sections
  function setupTabNavigation(
    navLinksSelector,
    tabsSelector,
    navActiveClass,
    tabsActiveClass
  ) {
    const navLinks = document.querySelectorAll(navLinksSelector);
    const tabs = document.querySelectorAll(tabsSelector);

    navLinks.forEach(function (link) {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        navLinks.forEach(function (navLink) {
          if (navLink !== link) {
            navLink.classList.remove(navActiveClass);
          }
        });
        link.classList.add(navActiveClass);
        const targetTabId = this.getAttribute("href").substring(1);
        switchTab(targetTabId, tabs, tabsActiveClass);
      });
    });
  }

  function switchTab(tabId, tabs, tabsActiveClass) {
    tabs.forEach((tab) => tab.classList.remove(tabsActiveClass));
    const selectedTab = document.getElementById(tabId);
    if (selectedTab) {
      selectedTab.classList.add(tabsActiveClass);
    }
  }

  // courses tab
  setupTabNavigation(
    ".a2n_nav-list li a",
    ".a2n_course_tabs",
    "a2n_active",
    "a2n_active_tab"
  );
});