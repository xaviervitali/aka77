//#### Variables globales
// const url_ = document.URL.slice(0, document.URL.lastIndexOf("public/")) + "/ajax";


const url_ = "https://aka77.xaviervitali.fr/ajax";
// const url_="https://layer3.elohim.link/AKA77/public/ajax";

let tabAjax, images, articles;
let tabImageAffiche = [];
let page = 0;
let nbElements = 9;
let randomArray = [];

//##### Even listener
$(".envoiLike").on("click", like);
document
  .querySelectorAll("a[data-table]")
  .forEach(e => e.addEventListener("click", like));
//************** LIKE ****************

function like() {
  const table = this.getAttribute("data-table");
  const indexId = parseInt(this.getAttribute("data-index"));

  // console.log(table, indexId)

  switch (table) {
    case "gallery":
      //On recuprere les "datas" du this
      const dataTitle = this.getAttribute("data-title");
      const oldLike = dataTitle.slice(dataTitle.search("/i>"));
      //On met à jour le nb de like dans la balise
      const indexImage = images.findIndex(function (e) {
        if (e.id == indexId) {
          return e.id;
        }
      });
      // console.log(indexImage)
      // console.log(imageLike.imgLike)
      const newLike = dataTitle.replace(
        oldLike,
        "/i>" + parseInt(images[indexImage].imgLike + 1) + "</span>"
      );
      this.setAttribute("data-title", newLike);
      break;
  }

  //  AJAX : on injecte dans l'url la table et l'id
  $.get({
    url: url_,
    data: {
      table: table,
      id: indexId
    }
  })
    .done(function () {
      vues();
      if (table == "article") {
        let found = articles.find(function (e) {
          if (e.id == indexId) {
            return e;
          }
        });
        // console.log(found);
        const likeArticle = found.likeArticle;

        document.querySelector(".nbLikeArticle").textContent = likeArticle;
      }
    })
    .catch(() => {
      console.log("Erreur sur le GET")
    });
}

/********** LIGHTBOX *************/

lightbox.option({
  resizeDuration: 200,
  wrapAround: true
});

/************* Smooth scroll  *********** */
//
$(document).ready(function () {
  $(".smooth-scroll").on("click", function (event) {
    // console.log(this.hash)

    if (this.hash !== "") {
      event.preventDefault();

      var hash = this.hash;

      $("html, body").animate(
        {
          scrollTop: $(hash).offset().top
        },
        1000,
        function () {
          window.location.hash = hash;
        }
      );
    }
  });
});

/**
 * function get pour obtenir le json contenu dans l'url ajax
 */
function majVue() {
  return $.get(url_, function (reponse) {
    return reponse;
  });
}

/**
 * Maj des tabAsso images et articles
 */
async function vues() {
  tableauXavierAjax = await majVue();
  images = tableauXavierAjax.tabImage;
  articles = tableauXavierAjax.tabArticle;
}

/**
 *
 * @param {int} page affiche les images de l'offset du tableau généré par pagination
 */
function RandomGallery(page) {
  let strHtml = "";
  if (document.URL.indexOf("galerie") > 0) {
    if (page <= (images.length / nbElements) + 1) {
      if (images.length > 0) {
        for (i = 0; i < pagination(page).length; i++) {
          strHtml += ` <a data-table ="gallery" data-pagination="${
            pagination(page)[i]
            }" data-index="${images[pagination(page)[i]].id}" href="${
            images[pagination(page)[i]].urlImgOriginal
            }" data-lightbox="roadtrip" data-title=" ${
            images[pagination(page)[i]].imgDescription
            } par <a href ='artistes'>${
            images[pagination(page)[i]].Artist
            }</a> <span class='like'> <i class='fas fa-eye'></i>${
            images[pagination(page)[i]].imgLike
            }</span>">
    <div class="overlay">
    <img src="${images[pagination(page)[i]].imgMedium}" alt="${
            images[pagination(page)[i]].imgName
            }" >
    </div>
    </a>`;
          // console.log(strHtml);
        }
      } else {
        strHtml = "<p>Pas d'images trouvées</p>";
      }
      document.querySelector("#publicGallery").innerHTML += strHtml;
      document
        .querySelectorAll("a[data-table]")
        .forEach(e => e.addEventListener("click", like));
    }
  }
}

/**
 * on initialise la galerie
 */
async function initialisation() {
  await vues();
  randomArrayGenerator(images);
  RandomGallery(0);
  $(".back-to-top").fadeOut();
}
/**
 *
 * @param {Array} tableau genere un tableau non ordonné
 */
function randomArrayGenerator(tableau) {
  let compteur = 0;

  while (compteur < tableau.length) {
    index = parseInt(Math.random() * tableau.length);
    if (randomArray.find(e => e == index) != index) {
      randomArray.push(index);
      compteur++;
    }
  }
  return randomArray;
}
/**
 *
 * @param {int} page pagine le tableau randomArray
 */
function pagination(page) {
  index = page * nbElements;
  return randomArray.slice(index, index + nbElements);
}

/**
 * HomeMade infinity scroll
 */
function infinity() {
  page++;
  RandomGallery(page);
}

/**
 * On test la position dans la page
 */

$(document).ready(function () {

  $(window).scroll(function (e) {
    var scrollTop = $(window).scrollTop();
    var docHeight = $(document).height();
    var winHeight = $(window).height();
    var scrollPercent = scrollTop / (docHeight - winHeight);
    var scrollPercentRounded = Math.round(scrollPercent * 100);
    scrollPercentRounded > 80
      ? infinity()
      : scrollPercentRounded > 20
        ? $(".back-to-top").fadeIn()
        : $(".back-to-top").fadeOut();
  });
});

//######################### c'est parti ##########################################
initialisation();
