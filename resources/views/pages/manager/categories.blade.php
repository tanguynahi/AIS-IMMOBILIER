@extends('layouts.a_template', ['titre' => $titre])

@section('content')
@include('partials.manager.breadcrumb-nav', ['LBL' => 'Categories biens'])
    <div class="submit-address dashboard-list">
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <br />
        
        <a type="button" onclick="form();" class="btn btn-outline-primary" style="margin-left: 20px">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nouvelle Categorie
        </a>
        <h4>Liste des categories de biens</h4>
        <div class="row pad-20">
            <div class="col-lg-12">
                <div class="invoice">
                    <div class="row">
                        <div class="col-md-12">
                            @if(count($categories)>0)
                                <div class="faq-accordion accordion accordion-flush faq-accordion" id="accordionFlushExample">
                                    @php (int) $n = 0; $occ = count($categories); @endphp
                                    @foreach($categories as $key => $value)
                                        @php $n++; @endphp
                                        <div class="accordion-item @if($n==$occ) mb-10 @endif">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ str_replace(' ', '-', $value->LIB_CATEGORIE) ?? 'xxxxxx' }}"
                                                    aria-expanded="false"
                                                    aria-controls="{{ str_replace(' ', '-', $value->LIB_CATEGORIE) ?? 'xxxxxx' }}">
                                                    {{ $value->LIB_CATEGORIE ?? 'xxxxxx' }}
                                                </button>
                                            </h2>
                                            <div id="{{ str_replace(' ', '-', $value->LIB_CATEGORIE) ?? 'xxxxxx' }}" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <div class="compare-table">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <img alt="small-properties" class="flex-shrink-0 me-3" style="height: 25%; width: 75%"
                                                                        src="{{asset($value->PATH_CATEGORIE ?? 'assets/img/properties/small-properties-1.png')}}">
                                                                    </td>
                                                                    <td>{{ Help::strCut($value->DESCRIPTION_CATEGORIE ?? 'xxxxx', 0, 70, '...') }}</td>
                                                                    <td>
                                                                        <div class="buttons text-center">
                                                                            <a href="{{route('categorieForm',['id'=>$value->ID_CATEGORIES])}}"
                                                                                class="btn-1 btn-gray" title="Modifier">
                                                                                <i class="fa fa-pencil"></i>
                                                                            </a>
                                                                            &nbsp;&nbsp;
                                                                            <a class="btn-1 btn-gray" type="button" title="Supprimer"
                                                                                onclick="deleted({{$value->ID_CATEGORIES}});">
                                                                                <i class="fa fa-fw fa-times-circle-o"></i>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-center">
                                    <i class="fa fa-angle-double-left"></i>
                                    <b>Aucune categories de biens trouvées.</b>
                                    <i class="fa fa-angle-double-right"></i>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function form() {
        var rout = "{{route('categorieForm',['id'=>'0'])}}";
        window.open(rout, '_self');
    }
    function deleted(params) {
        if (confirm("Voulez-vous supprimer cet enregistrement ?")) {
            var rout = "{{ route('categorieDesact',['idCategories'=>':idCategories']) }}";
            rout = rout.replace(':idCategories', params)
            window.open(rout, '_self');
        }
    }
</script>
@endsection
