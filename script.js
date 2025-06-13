// ICON SECTION
const iconGrid = document.getElementById("icon-grid");
const toggleBtn = document.getElementById("toggleBtn");
const dialog = document.getElementById("dialog");
const iconCode = document.getElementById("iconCode");
const closeBtn = document.getElementById("closeBtn");

const icons = [
  "fa-solid fa-star", "fa-solid fa-heart", "fa-solid fa-user",
  "fa-solid fa-check", "fa-solid fa-xmark", "fa-solid fa-moon",
  "fa-solid fa-sun", "fa-solid fa-music", "fa-solid fa-camera",
  "fa-solid fa-code", "fa-solid fa-envelope", "fa-solid fa-globe",
  "fa-solid fa-download", "fa-solid fa-upload", "fa-solid fa-bell",
  "fa-solid fa-book", "fa-solid fa-cloud", "fa-solid fa-search",
  "fa-solid fa-lock", "fa-solid fa-unlock", "fa-solid fa-wifi",
  "fa-solid fa-thumbs-up", "fa-solid fa-lightbulb", "fa-solid fa-gift",
  "fa-solid fa-phone", "fa-solid fa-message", "fa-solid fa-cart-shopping",
  "fa-solid fa-credit-card", "fa-solid fa-shield", "fa-solid fa-map"
];

let showAllIcons = false;

function renderIcons() {
  iconGrid.innerHTML = "";
  const count = showAllIcons ? icons.length : 24;

  for (let i = 0; i < count; i++) {
    const icon = document.createElement("div");
    icon.className = "icon-card";
    const iconName = icons[i].split(' ')[1].replace('fa-', '').replace(/-/g, ' ');
    icon.innerHTML = `
      <i class="${icons[i]}"></i>
      <div class="icon-name">${iconName.charAt(0).toUpperCase() + iconName.slice(1)}</div>
    `;
    icon.onclick = () => openDialog(`<i class="${icons[i]}"></i>`);
    iconGrid.appendChild(icon);
  }

  toggleBtn.textContent = showAllIcons ? "Show Less" : "Show More";
}

function openDialog(code) {
  dialog.style.display = "flex";
  iconCode.textContent = code;
}

closeBtn.onclick = () => {
  dialog.style.display = "none";
};

window.onclick = (e) => {
  if (e.target === dialog) dialog.style.display = "none";
};

toggleBtn.onclick = () => {
  showAllIcons = !showAllIcons;
  renderIcons();
};

renderIcons();

// IMAGE SECTION
document.addEventListener('DOMContentLoaded', () => {
  const filterBtns = document.querySelectorAll('.filter-btn');
  const allCards = document.querySelectorAll('.image-card');
  const showMoreBtn = document.getElementById('showMoreBtn');
  const showLessBtn = document.getElementById('showLessBtn');

  let currentCategory = 'all';
  let showAllImages = false;

  function filterImages(category) {
    currentCategory = category;

    filterBtns.forEach(btn => {
      btn.classList.toggle('active', btn.dataset.category === category);
    });

    allCards.forEach(card => {
      const matchCategory = category === 'all' || card.dataset.category === category;
      const isExtra = card.classList.contains('extra');

      if (!isExtra || showAllImages) {
        card.classList.toggle('hidden', !matchCategory);
      } else {
        card.classList.add('hidden');
      }
    });
  }

  showMoreBtn.addEventListener('click', () => {
    showAllImages = true;
    filterImages(currentCategory);
    showMoreBtn.style.display = 'none';
    showLessBtn.style.display = 'inline-block';
  });

  showLessBtn.addEventListener('click', () => {
    showAllImages = false;
    filterImages(currentCategory);
    showLessBtn.style.display = 'none';
    showMoreBtn.style.display = 'inline-block';
  });

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterImages(btn.dataset.category);
    });
  });

  filterImages(currentCategory);
});
