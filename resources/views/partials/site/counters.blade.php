<div class="counters-2">
    <div class="container">
        <div class="row g-0">
            <div class="col-lg-3 col-md-6 col-sm-6 border-r border-l">
                <div class="counter-box-2">
                    <i class="flaticon-sale"></i>
                    <h1 class="counter">{{$types[0]->Nb ?? 0}}</h1>
                    <p>Annonces à vendre</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 border-r">
                <div class="counter-box-2">
                    <i class="flaticon-rent"></i>
                    <h1 class="counter">{{$types[1]->Nb ?? 0}}</h1>
                    <p>Annonces à louer</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 border-r">
                <div class="counter-box-2">
                    <i class="flaticon-user"></i>
                    <h1 class="counter">{{$agents ?? 0}}</h1>
                    <p>Agents</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 border-r">
                <div class="counter-box-2">
                    <i class="flaticon-broker"></i>
                    <h1 class="counter">0</h1>
                    <p>Partenaires</p>
                </div>
            </div>
        </div>
    </div>
</div>
