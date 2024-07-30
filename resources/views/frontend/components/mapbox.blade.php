<div class="parallax-content contact-content" id="mapbox">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <h1 class="page-title">Teknologi MapBox <span>Temukan Wisata Daerah Sumba</span></h1>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="contact-form">
                    <div class="row">
                        <form id="search-form" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-4 flex-grow-1">
                                            <fieldset>
                                                <input type="text" class="form-control" id="search-name" placeholder="Nama Wisata..." required>
                                            </fieldset>
                                        </div>
                                        <fieldset>
                                            <button type="submit" class="btn btn-primary">Cari Wisata</button>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="map-container">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="locationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="locationModalLabel">Detail Wisata</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="locationName"></h5>
                <img id="locationImage" class="modal-img" src="" alt="">
                <p id="locationDescription"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="routeButton">Cari Rute</button>
            </div>
        </div>
    </div>
</div>
