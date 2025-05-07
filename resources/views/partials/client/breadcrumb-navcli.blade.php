@if ($LBL == 'Tableau de bord')
    <div class="dashboard-header clearfix">
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <h4>{{ $LBL ?? '' }}</h4>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="breadcrumb-nav">
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="#" class="active">{{ $LBL ?? '' }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="dashboard-header clearfix">
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <h4>{{ $LBL ?? '' }}</h4>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="breadcrumb-nav">
                    <ul>
                        <li><a href="{{ route('home') }}">Accueil</a></li>
                        <li><a href="{{ route('tdbc') }}">Tableau de bord</a></li>
                        <li class="active">{{ $LBL ?? '' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
