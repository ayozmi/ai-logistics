<style>
    .owl-prev, .owl-next{
        border: none;
        border-radius: 100px;
        background-color: #0C0E12;
        color: #9FA7AF
    }
    #article-container {
        opacity: 1;
        transition: opacity 0.5s;
    }
    #article-container.fade-out {
        opacity: 0;
    }
</style>
<script src="/Logimo/include/main_pages/news/news.js" defer></script>
<div class="row">
    <div class="col-md-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" id="summary-title" style="color: #FFAB00">🤖 AI-Powered Summary:</h4>
                <div class="row">
                    <div class="col-lg-12" style="text-align: right">
                        <div class="owl-nav">
                            <button type="button" role="presentation" class="owl-prev" onclick="showSummary()"><i class="mdi mdi-chevron-left"></i></button>
                            <button type="button" role="presentation" class="owl-next" onclick="showRelevance()"><i class="mdi mdi-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-lg-12" id="summary-div">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">News:</h4>
                <div class="row">
                    <div class="col-lg-11" id="ml-class">

                    </div>
                    <div class="col-lg-1" style="text-align: right">
                        <div class="owl-nav">
                            <button type="button" role="presentation" class="owl-prev" onclick="showPreviousArticle()"><i class="mdi mdi-chevron-left"></i></button>
                            <button type="button" role="presentation" class="owl-next" onclick="showNextArticle()"><i class="mdi mdi-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
                <div id="article-container">
                    <!-- Article content will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>
