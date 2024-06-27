let currentArticleIndex = 0;
let articles = [];
let ajax_call = null;
let summary_flag = 1;

$(function () {
    const summary = $("#summary-div");
    summary.html("<img src='images/spinner.svg' width='100px'>");
    fetchNews(currentArticleIndex);

    // Function to fetch news article based on index
    function fetchNews(index) {
        if (ajax_call !== null) {
            ajax_call.abort();
        }

        ajax_call = $.ajax({
            url: 'include/main_pages/news/fetch_news_ajax.php',
            type: 'POST',
            cache: false,
            contentType: 'application/json',
            processData: false,
            data: JSON.stringify({ type: 2 }), // Send the index to the server
            dataType: 'json',
            success: data => {
                articles = data;
                displayArticle(currentArticleIndex);
            },
            error: data => {
                console.error("Error fetching data", data);
            }
        });
    }

    // Function to display the current article
    function displayArticle(index) {
        const article = articles.content[index];
        summary.html("<img src='images/spinner.svg' width='100px'>");
        const ml_classifier = $("#ml-class");
        const articleContainer = document.getElementById('article-container');
        articleContainer.innerHTML = `
            <div class="d-flex py-4">
                <div class="flex-grow">
                    <div class="d-flex d-md-block d-xl-flex justify-content-between">
                        <div>
                            <p class="text-muted">${article.classification} (${article.type})</p>
                            <h4 class="preview-subject text-body"><a href="#">${article.title}</a></h4>
                            <p class="text-muted text-small">${article.date_col}</p>
                            <p class="text-body">${article.text}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        ml_classifier.html(article.ml_classification)
        setTimeout(() => {
            displaySummary();
        }, 3000)
        // Remove the fade-out class after the content is updated
        setTimeout(() => {
            articleContainer.classList.remove('fade-out');
        }, 50); // Timeout to allow the fade-out effect to be noticed
    }

    function displaySummary(){
        const Container = document.getElementById("summary-div");
        if (summary_flag === 0){
            $("#summary-title").html("🤖 AI-Powered Relevance to LATAM:")
            summary.html(articles.content[currentArticleIndex].relevance);
        }
        else if (summary_flag === 1){
            $("#summary-title").html("🤖 AI-Powered Summary:")
            summary.html(articles.content[currentArticleIndex].summary);
        }
        // Remove the fade-out class after the content is updated
        setTimeout(() => {
            Container.classList.remove('fade-out');
        }, 100); // Timeout to allow the fade-out effect to be noticed
    }

    // Function to show the next article
    window.showNextArticle = function() {
        summary_flag = 1;
        if (currentArticleIndex < articles.content.length - 1) {
            currentArticleIndex++;
            fadeAndUpdateArticle(currentArticleIndex);
        }
    }

    // Function to show the previous article
    window.showPreviousArticle = function() {
        summary_flag = 1;
        if (currentArticleIndex > 0) {
            currentArticleIndex--;
            fadeAndUpdateArticle(currentArticleIndex);
        }
    }

    window.showRelevance = function () {
        if (summary_flag === 1){
            summary_flag = 0;
            fadeAndShowSummary();
        }
    }

    window.showSummary = function () {
        if (summary_flag === 0){
            summary_flag = 1;
            fadeAndShowSummary();
        }
    }

    // Function to fade out and update the article
    function fadeAndUpdateArticle(index) {
        const articleContainer = document.getElementById('article-container');
        articleContainer.classList.add('fade-out');
        setTimeout(() => {
            displayArticle(index);
        }, 500); // Timeout to match the CSS transition duration
    }

    function fadeAndShowSummary(){
        const Container = document.getElementById("summary-div");
        Container.classList.add('fade-out');
        setTimeout(() => {
                displaySummary();
        }, 500); // Timeout to match the CSS transition duration
    }
});
