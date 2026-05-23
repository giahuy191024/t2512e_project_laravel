const newsData = [

    {
        image: "/img/blog/blog1.png",
        title: "5 dấu hiệu nên nhổ răng khôn",
        desc: "Những dấu hiệu cho thấy bạn cần xử lý răng khôn sớm.",
        link: "/news/1"
    },

    {
        image: "/img/blog/blog2.png",
        title: "Niềng Invisalign có đau không?",
        desc: "Giải đáp những thắc mắc phổ biến trước khi niềng.",
        link: "/news/2"
    },

    {
        image: "/img/blog/blog3.png",
        title: "Bao lâu nên lấy cao răng?",
        desc: "Thời gian phù hợp để bảo vệ sức khỏe răng miệng.",
        link: "/news/3"
    },

    {
        image: "/img/blog/blog4.png",
        title: "Implant có bền không?",
        desc: "Tìm hiểu tuổi thọ của phương pháp Implant.",
        link: "/news/4"
    },

    {
        image: "/img/blog/blog5.png",
        title: "Răng sứ có bị hôi miệng?",
        desc: "Những điều cần biết trước khi bọc sứ.",
        link: "/news/5"
    },

    {
        image: "/img/blog/blog6.png",
        title: "Nha khoa trẻ em cần lưu ý gì?",
        desc: "Giúp trẻ hình thành thói quen chăm sóc răng.",
        link: "/news/6"
    },

    {
        image: "/img/blog/blog7.png",
        title: "Tẩy trắng răng có hại không?",
        desc: "Giải đáp từ chuyên gia nha khoa.",
        link: "/news/7"
    }

];

const newsGrid = document.getElementById("newsGrid");

let currentPage = 0;
const perPage = 3;

function renderNews(){

    newsGrid.innerHTML = "";

    const start = currentPage * perPage;

    const currentNews =
        newsData.slice(start, start + perPage);

    currentNews.forEach(news => {

        newsGrid.innerHTML += `

        <div class="news-card">

            <img src="${news.image}" alt="">

            <div class="news-content">

                <h3>
                    <a href="${news.link}">
                        ${news.title}
                    </a>
                </h3>
                <p>${news.desc}</p>

            </div>

        </div>

        `;
    });
}

document
    .getElementById("nextNews")
    .addEventListener("click", () => {

        if((currentPage + 1) * perPage < newsData.length){

            currentPage++;

            renderNews();
        }
    });

document
    .getElementById("prevNews")
    .addEventListener("click", () => {

        if(currentPage > 0){

            currentPage--;

            renderNews();
        }
    });

renderNews();
