const contentTag = document.querySelector(".content");
const feedTag = document.querySelector(".feed");
const toggleBtn = document.querySelector(".fillBtn");
const scrollIcon = document.querySelector(".fa-scroll");

let isOpened = false;

function closeForm() {
    if (contentTag) {
        contentTag.style.top = `-870px`;
    }
    if (feedTag) {
        feedTag.style.top = `-${contentTag.offsetHeight}px`;
    }
    
    isOpened = false;
    if (toggleBtn) {
        toggleBtn.textContent = "Fill Form";
    }
}

function openForm() {
    if (contentTag) {
        contentTag.style.top = "0px";
    }
    if (feedTag) {
        feedTag.style.top = `0px`;
    }
    if (toggleBtn) {
        toggleBtn.textContent = "Close Form";
    }
    isOpened = true;
}

if (toggleBtn) {
    toggleBtn.addEventListener("click", () => {
        if (isOpened) {
            closeForm();
        } else {
            openForm();
        }
    });
}

// Automatically open the form if in edit mode
if (window.location.search.includes("editid")) {
    openForm();
} else {
    closeForm();
}
