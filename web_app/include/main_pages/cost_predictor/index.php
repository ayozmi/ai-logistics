<script src="include/main_pages/cost_predictor/cost_predictor.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js" defer></script>
<div class="page-header">
    <h3 class="page-title">Cost Predictor:</h3>
</div>
<style>
    th, td{
        padding-left: 0 !important;
    }
</style>
<div class="row">
    <div class="col-lg grid-margin stretch-card" style="justify-content: center">
        <div class="pagination-fancy">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table userTable fancytbl">
                        <thead>
                        <tr>
                            <th>SKU</th>
                            <th>Carriers</th>
                            <th>Routes</th>
                            <th data-sortas='numeric'>Shipping Estimated Cost</th>
                            <th>Location</th>
                            <th data-sortas='numeric'>Demurrage Estimated Cost</th>
                            <th>Demurrage Risk</th>
                        </tr>
                        </thead>
                        <tbody id="data_table">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>